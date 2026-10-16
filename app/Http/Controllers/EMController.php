<?php

namespace App\Http\Controllers;

use App\Models\EMPackage;
use App\Models\EMSessionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\EMPackageOrderItem;

class EMController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'packages');

        $packages = EMPackage::where('is_active', 1)
            ->latest()
            ->get();

        $sessions = EMSessionEvent::where('is_active', 1)
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Accounting Data
        |--------------------------------------------------------------------------
        | Show paid package order items where the package belongs to this logged user.
        |--------------------------------------------------------------------------
        */

        $accountingItems = EMPackageOrderItem::with([
                'package',
                'order.customer',
                'order.latestPaymentLog',
            ])
            ->whereHas('order', function ($query) {
                $query->where('payment_status', 'paid');
            })
            ->get()
            ->sortByDesc(function ($item) {
                return optional($item->order->paid_at ?? $item->order->created_at)->timestamp;
            })
            ->values();

        $paidOrders = $accountingItems
            ->pluck('order')
            ->filter()
            ->unique('id')
            ->values();

        $accountingSummary = [
            'total_orders' => $paidOrders->count(),
            'package_revenue' => $accountingItems->sum('total_price'),
            'gross_collected' => $paidOrders->sum('total'),
            'processing_fees' => $paidOrders->sum(function ($order) {
                return $order->processing_fee
                    ?? optional($order->latestPaymentLog)->processing_fee
                    ?? 0;
            }),
            'total_credits_sold' => $accountingItems->sum(function ($item) {
                return (int) $item->classes_per_package * (int) $item->quantity;
            }),
        ];

        $salesByPackage = $accountingItems
            ->groupBy('package_id')
            ->map(function ($rows) {
                $first = $rows->first();

                return [
                    'package_name' => $first->package_name,
                    'orders' => $rows->pluck('order_id')->unique()->count(),
                    'quantity' => $rows->sum('quantity'),
                    'credits' => $rows->sum(function ($item) {
                        return (int) $item->classes_per_package * (int) $item->quantity;
                    }),
                    'revenue' => $rows->sum('total_price'),
                ];
            })
            ->sortByDesc('revenue')
            ->values();

        return view('pages.em.index', compact(
            'packages',
            'sessions',
            'activeTab',
            'accountingItems',
            'accountingSummary',
            'salesByPackage'
        ));
    }

    public function createPackage()
    {
        $package = null;
        return view('pages.em.package-form', compact('package'));
    }

    public function storePackage(Request $request)
    {
        $data = $this->validatePackage($request);
        $data['user_id'] = auth()->id();
        $data['is_active'] = 1;

        EMPackage::create($data);

        return redirect()->route('schedules.index', ['tab' => 'packages'])
            ->with('success', 'Package created successfully.');
    }

    public function editPackage($id)
    {
        $package = EMPackage::where('is_active', 1)
            ->findOrFail($id);

        return view('pages.em.package-form', compact('package'));
    }

    public function updatePackage(Request $request, $id)
    {
        $package = EMPackage::where('is_active', 1)
            ->findOrFail($id);

        $package->update($this->validatePackage($request));

        return redirect()->route('schedules.index', ['tab' => 'packages'])
            ->with('success', 'Package updated successfully.');
    }

    public function destroyPackage($id)
    {
        EMPackage::findOrFail($id)->update(['is_active' => 0]);

        return response()->json(['status' => true, 'message' => 'Package deleted.']);
    }

    public function createSession()
    {
        $session = null;
        return view('pages.em.session-form', compact('session'));
    }

    private function validateSessionRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documentation' => 'nullable|file|mimes:pdf|max:20480',

            'training_type' => 'required|in:Stickwork,Speedwork,Fieldwork',

            'location' => 'required|string|max:500',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'location_lat' => 'nullable|numeric|between:-90,90',
            'location_lng' => 'nullable|numeric|between:-180,180',

            'instructor' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',

            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',

            'what_to_bring' => 'nullable|string|max:5000',
        ], [
            'name.required' => 'The session name is required.',
            'name.string' => 'The session name must be valid text.',
            'name.max' => 'The session name cannot exceed 255 characters.',

            'description.string' => 'The description must be valid text.',

            'documentation.file' => 'The documentation must be a valid file.',
            'documentation.mimes' => 'The documentation must be a PDF file.',
            'documentation.max' => 'The documentation cannot be larger than 20 MB.',

            'training_type.required' => 'Please select a training type.',
            'training_type.in' => 'Please select Stickwork, Speedwork, or Fieldwork.',

            'location.required' => 'The session location is required.',
            'location.string' => 'The location must be valid text.',
            'location.max' => 'The location cannot exceed 500 characters.',

            'street_address.string' => 'The street address must be valid text.',
            'street_address.max' => 'The street address cannot exceed 255 characters.',

            'city.string' => 'The city must be valid text.',
            'city.max' => 'The city cannot exceed 255 characters.',

            'location_lat.numeric' => 'The selected location latitude is invalid.',
            'location_lat.between' => 'The latitude must be between -90 and 90.',

            'location_lng.numeric' => 'The selected location longitude is invalid.',
            'location_lng.between' => 'The longitude must be between -180 and 180.',

            'instructor.required' => 'The instructor name is required.',
            'instructor.string' => 'The instructor name must be valid text.',
            'instructor.max' => 'The instructor name cannot exceed 255 characters.',

            'capacity.required' => 'The session capacity is required.',
            'capacity.integer' => 'The capacity must be a valid number.',
            'capacity.min' => 'The capacity must be at least 1.',

            'event_date.required' => 'The session date is required.',
            'event_date.date' => 'Please enter a valid session date.',

            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'Please enter a valid start time.',

            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'Please enter a valid end time.',
            'end_time.after' => 'The end time must be after the start time.',

            'what_to_bring.string' => 'The what-to-bring information must be valid text.',
            'what_to_bring.max' => 'The what-to-bring information cannot exceed 5000 characters.',
        ]);
    }

    public function storeSession(Request $request)
    {
        $data = $this->validateSessionRequest($request);

        $data['user_id'] = auth()->id();
        $data['is_active'] = 1;

        $uploadedDocumentation = null;

        try {
            if ($request->hasFile('documentation')) {
                $uploadedDocumentation = $request
                    ->file('documentation')
                    ->store('em/documentation', 'public');

                $data['documentation'] = $uploadedDocumentation;
            }

            EMSessionEvent::create($data);
        } catch (\Throwable $exception) {
            if (
                $uploadedDocumentation &&
                Storage::disk('public')->exists($uploadedDocumentation)
            ) {
                Storage::disk('public')->delete($uploadedDocumentation);
            }

            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'form' => 'The session could not be created. Please check the information and try again.',
                ]);
        }

        return redirect()
            ->route('schedules.index', ['tab' => 'sessions'])
            ->with('success', 'Session created successfully.');
    }

    public function editSession($id)
    {
        $session = EMSessionEvent::where('is_active', 1)
            ->findOrFail($id);

        return view('pages.em.session-form', compact('session'));
    }

    public function updateSession(Request $request, $id)
    {
        $session = EMSessionEvent::where('is_active', 1)
            ->findOrFail($id);

        $data = $this->validateSessionRequest($request);

        $oldDocumentation = $session->documentation;
        $newDocumentation = null;

        try {
            if ($request->hasFile('documentation')) {
                $newDocumentation = $request
                    ->file('documentation')
                    ->store('em/documentation', 'public');

                $data['documentation'] = $newDocumentation;
            }

            $session->update($data);
        } catch (\Throwable $exception) {
            if (
                $newDocumentation &&
                Storage::disk('public')->exists($newDocumentation)
            ) {
                Storage::disk('public')->delete($newDocumentation);
            }

            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'form' => 'The session could not be updated. Please check the information and try again.',
                ]);
        }

        if (
            $newDocumentation &&
            !empty($oldDocumentation) &&
            $oldDocumentation !== $newDocumentation &&
            Storage::disk('public')->exists($oldDocumentation)
        ) {
            Storage::disk('public')->delete($oldDocumentation);
        }

        return redirect()
            ->route('schedules.index', ['tab' => 'sessions'])
            ->with('success', 'Session updated successfully.');
    }

    public function destroySession($id)
    {
        EMSessionEvent::findOrFail($id)->update(['is_active' => 0]);

        return response()->json(['status' => true, 'message' => 'Session deleted.']);
    }

    public function calendarEvents()
    {
        $events = EMSessionEvent::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->get()
            ->map(function ($session) {
                $instructor = $session->instructor_name ?: $session->coach_name;

                return [
                    'id' => $session->id,
                    'title' => $session->name . ($instructor ? ' · ' . $instructor : ''),
                    'start' => $session->event_date . 'T' . $session->start_time,
                    'end' => $session->event_date . 'T' . $session->end_time,
                    'extendedProps' => [
                        'location' => $session->location,
                        'training_type' => $session->training_type,
                        'instructor' => $instructor,
                        'what_to_bring' => $session->what_to_bring,
                    ],
                ];
            });

        return response()->json($events);
    }

    private function validatePackage(Request $request)
    {
        return $request->validate([
            'package_name' => 'required|string|max:255',
            'package_price' => 'required|numeric|min:0|max:999999999',
            'package_description' => 'nullable|string|max:5000',
            'available_classes' => 'required|integer|min:0|max:999999',
        ], [
            'package_name.required' => 'Package name is required.',
            'package_price.required' => 'Package price is required.',
            'available_classes.required' => 'Available classes is required.',
        ]);
    }

    private function validateSession(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'training_type' => 'required|in:Stickwork,Speedwork,Fieldwork',
            'description' => 'nullable|string|max:5000',
            'documentation' => 'nullable|mimes:pdf|max:20480',
            'location' => 'required|string|max:500',
            'location_lat' => 'nullable|numeric',
            'location_lng' => 'nullable|numeric',
            'instructor_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'what_to_bring' => 'nullable|string|max:5000',
        ], [
            'name.required' => 'Session name is required.',
            'training_type.required' => 'Type of training is required.',
            'training_type.in' => 'Select Stickwork, Speedwork, or Fieldwork.',
            'location.required' => 'Location is required.',
            'instructor_name.required' => 'Instructor is required.',
            'event_date.required' => 'Date is required.',
            'start_time.required' => 'Start time is required.',
            'end_time.required' => 'End time is required.',
        ]);

        if ($data['end_time'] <= $data['start_time']) {
            abort(redirect()->back()
                ->withInput()
                ->withErrors(['end_time' => 'End time must be after start time.']));
        }

        // Keep backward compatibility with older code/views that still read coach_name.
        $data['coach_name'] = $data['instructor_name'];

        return $data;
    }
}
