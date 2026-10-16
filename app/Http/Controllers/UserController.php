<?php

namespace App\Http\Controllers;

use App\Exports\UserLogExport;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use OwenIt\Auditing\Contracts\Auditable;
class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $orderValues = Order::select('id','invoice_no')->get();

        // $usHolidays = OrderItem::select('date')->where('active', '1')->get();

        return view('users.index',['orderValues'=>$orderValues]);
    }

    public function user_log(Request $request)
    {
        // dd($request->all());
        if(auth()->user()->can('view user logs')){
            $users = User::all();
            $sr_event = '';
            $sr_module = '';
            $sr_id = '';
            $sr_update = '';
            $sr_text = '';
            $userId = '';
            $std = Carbon::now()->subMonth()->format('Y-m-d');
            $end = Carbon::now()->format('Y-m-d');
            $auditQry = Audit::query();
            if(isset($request->user_id) && $request->user_id != '') {
                $userId = $request->user_id;
                if($request->user_id == 'customer') {
                    $auditQry->where('user_id', null);
                } else {
                    $auditQry->where('user_id', $request->user_id);
                }
            }
            if(isset($request->std) && isset($request->end)) {
                $std = Carbon::parse($request->std)->format('Y-m-d');
                $end = Carbon::parse($request->end)->format('Y-m-d');
            }

            if(isset($request->sr_text) && $request->sr_text != '') {
                $sr_text = $request->sr_text;
                // $auditQry->where(function ($qr) use($request) { $qr->where('event', 'LIKE', '%'.$request->sr_text.'%')
                //                                                     ->orWhere('auditable_type', 'LIKE', '%'.$request->sr_text.'%')
                //                                                     ->orWhere('auditable_id', 'LIKE', '%'.$request->sr_text.'%')
                //                                                     ->orWhere('source', 'LIKE', '%'.$request->sr_text.'%');});
                $auditQry->where('source', 'LIKE', '%'.$request->sr_text.'%');
            }
            if(isset($request->sr_update) && $request->sr_update != '') {
                $sr_update = $request->sr_update;
                $srUpdate = str_replace(' ', '_', $sr_update);
                $auditQry->where('old_values', 'LIKE', '%'.$srUpdate.'%');
            }
            if(isset($request->sr_event) && $request->sr_event != '') {
                $sr_event = $request->sr_event;
                $auditQry->where('event', $request->sr_event);
            }
            if(isset($request->sr_module) && $request->sr_module != '') {
                $sr_module = $request->sr_module;
                $auditQry->where('auditable_type', $request->sr_module);
            }
            if(isset($request->sr_id) && $request->sr_id != '') {
                $sr_id = $request->sr_id;
                $auditQry->where('auditable_id',  $request->sr_id);
            }
            $auditQry->whereBetween('created_at', [$std." 00:00:00", $end." 23:59:59"]);
            $audits = $auditQry->orderBy('created_at', 'DESC')->paginate(50);

            // $groupedAudits = $audits->groupBy(function ($item) {
            //     return $item->parent_id . ' ' . $item->created_at->format('Y-m-d H:i:s');
            // });

            // // Convert grouped audits to a collection
            // $groupedAuditsCollection = new Collection($groupedAudits->values()->all());

            // // Paginate the grouped audits
            // $page = $request->input('page', 1);
            // $perPage = 50;
            // $paginatedGroupedAudits = new LengthAwarePaginator(
            //     $groupedAuditsCollection->forPage($page, $perPage),
            //     $groupedAuditsCollection->count(),
            //     $perPage,
            //     $page,
            //     ['path' => $request->url(), 'query' => $request->query()]
            // );

            $auditableModels = [];

            $modelsPath = app_path('Models'); // adjust if your models are somewhere else
            $files = File::allFiles($modelsPath);

            foreach ($files as $file) {
                $path = $file->getRealPath();
                $class = 'App\\Models\\' . str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());

                if (class_exists($class) && in_array(Auditable::class, class_implements($class))) {
                    $auditableModels[] = $class;
                }
            }

            return view('pages.user_log.index', compact('users', 'auditableModels', 'userId', 'std', 'end', 'audits',
                        'sr_text', 'sr_event', 'sr_module', 'sr_id', 'sr_update'
                        ));
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function getLogDetail($id, $type)
    {
        $audits = Audit::find($id)->getModified();
        return view('pages.user_log.partials.view', compact('audits', 'type'));
        // return json_encode($audits);
    }

    public function user_log_export(Request $request)
    {
        $std = Carbon::now()->subMonth()->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');
        $auditQry = Audit::query();
        if(isset($request->user_id) && $request->user_id != '') {
            $auditQry->where('user_id', $request->user_id);
        }
        if(isset($request->std) && isset($request->end)) {
            $std = Carbon::parse($request->std)->format('Y-m-d');
            $end = Carbon::parse($request->end)->format('Y-m-d');
        }

        if(isset($request->sr_text) && $request->sr_text != '') {
            $sr_text = $request->sr_text;
            // $auditQry->where(function ($qr) use($request) { $qr->where('event', 'LIKE', '%'.$request->sr_text.'%')
            //                                                     ->orWhere('auditable_type', 'LIKE', '%'.$request->sr_text.'%')
            //                                                     ->orWhere('auditable_id', 'LIKE', '%'.$request->sr_text.'%')
            //                                                     ->orWhere('source', 'LIKE', '%'.$request->sr_text.'%');});
            $auditQry->where('source', 'LIKE', '%'.$request->sr_text.'%');
        }
        if(isset($request->sr_update) && $request->sr_update != '') {
            $sr_update = $request->sr_update;
            $srUpdate = str_replace(' ', '_', $sr_update);
            $auditQry->where('old_values', 'LIKE', '%'.$srUpdate.'%');
        }
        if(isset($request->sr_event) && $request->sr_event != '') {
            $sr_event = $request->sr_event;
            $auditQry->where('event', $request->sr_event);
        }
        if(isset($request->sr_module) && $request->sr_module != '') {
            $sr_module = $request->sr_module;
            $auditQry->where('auditable_type', $request->sr_module);
        }
        if(isset($request->sr_id) && $request->sr_id != '') {
            $sr_id = $request->sr_id;
            $auditQry->where('auditable_id',  $request->sr_id);
        }
        $auditQry->whereBetween('created_at', [$std." 00:00:00", $end." 23:59:59"]);
        $audits = $auditQry->orderBy('created_at', 'ASC')->get();

        return Excel::download(new UserLogExport($audits), 'Customer_Log_Report.xlsx');

    }

    public function deleteLogDetail(Request $request)
    {
        if(auth()->user()->can('delete user logs')){

            try {
                $actionType = $request->action_type;

                if($actionType == 'selected'){
                    Audit::whereIn('id', $request->audit_ids)->delete();
                } elseif($actionType == 'filtered') {
                    $auditQry = Audit::query();
                    if(isset($request->user_id) && $request->user_id != '') {
                        $auditQry->where('user_id', $request->user_id);
                    }
                    if(isset($request->search_text) && $request->search_text != '') {
                        $auditQry->where(function ($qr) use($request) { $qr->where('event', 'LIKE', '%'.$request->search_text.'%')
                                                                            ->orWhere('auditable_type', 'LIKE', '%'.$request->search_text.'%')
                                                                            ->orWhere('auditable_id', 'LIKE', '%'.$request->search_text.'%')
                                                                            ->orWhere('source', 'LIKE', '%'.$request->search_text.'%');});
                    }
                    $auditQry->whereBetween('created_at', [$request->start_date." 00:00:00", $request->end_date." 23:59:59"])->delete();
                }
                return json_encode(['response'=>'success', 'title'=>'Success!', 'message'=>'Audits Have Been Deleted Successfully!']);
            } catch (\Throwable $th) {
                return json_encode(['response'=>'error', 'title'=>'Error!', 'message'=>$th->getMessage()]);
                //throw $th;
            }

        } else {
            return json_encode(['response'=>'error', 'title'=>'Error!', 'message'=>'Permission Not Granted!']);
        }

    }
    public function impersonateUser($userId)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::findOrFail($userId);

        // Store the original user ID to allow reverting later
        session(['original_user_id' => auth()->id()]);

        // Log in as the selected user
        Auth::login($user);


        return redirect('/')->with('success', 'You are now logged in as ' . $user->name);


    }
    public function revertImpersonation()
    {
        if (session()->has('original_user_id')) {
            $originalUser = User::find(session('original_user_id'));
            Auth::login($originalUser);
            session()->forget('original_user_id');
        }

        return redirect('/')->with('success', 'You are back as Admin');
    }
    public function updateUserStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|boolean'
        ]);

        $user = User::find($request->user_id);

        if ($user) {
            $user->active = $request->status; // Assuming 'active' is the column name
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found.'
        ], 404);
    }

}
