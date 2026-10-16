<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Sport;
use Mockery\Undefined;
use App\Models\Contact;
use App\Models\Activity;
use App\Models\OrderItem;
use App\Models\ColorMaster;
use App\Models\SummaryAtPayment;
use PharIo\Manifest\Author;
use App\Models\ColumnLayout;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\OrderItemFile;
use App\Models\OrganizationColor;
use App\Models\OrganizationEmail;
use App\Models\OrganizationLayout;
use App\Models\LeadSource;
use App\Models\SubProduct;
use App\Models\Size;
use App\Models\Fabric;
use App\Models\OrganizationReceivedSample;
use App\Models\OrganizationSampleShipment;
use App\Models\EmailTemplate;
use App\Models\UserEmailTemplate;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\PaypalPayment;
use App\Models\VenmoPayment;
use Spatie\Permission\Models\Role;
use App\Models\ContactOrganization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\PaymentService;
use App\Services\EmailNotificationBuilderService;
use App\Services\NotificationBuilderService;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use App\Models\OtherPayment;
use App\Models\AccountsLog;
use App\Models\CopySummaryAtPayment;
use App\Exports\PaymentsStatementExport;
use App\Models\StatementLayout;
use App\Models\BulkOrderEntry;
use App\Models\DebitEntry;
use Maatwebsite\Excel\Facades\Excel;





class OrganizationController extends Controller
{
    protected $PaymentService;

    public function __construct(PaymentService $PaymentService)
    {
        $this->PaymentService = $PaymentService;
    }

    public function index(Request $request){
        if(auth()->user()->can('view organization')){
            $organizationQuery = Organization::select('organizations.id', 'organizations.organization_name', 'organizations.website', 'organizations.email',
                                                'organizations.sport', 'organizations.size_of_club', 'organizations.colors',
                                                'organizations.shipping_street', 'organizations.shipping_city', 'organizations.shipping_state',
                                                'organizations.shipping_postal_code', 'organizations.shipping_country', 'organizations.sales_tax',
                                                'organizations.sales_tax_active', 'organizations.created_at', 'organizations.updated_at', 'users.name')
                                        ->join('users', 'users.id', '=', 'organizations.user_id')
                                        ->where('organizations.active', 1)
                                        ->orderBy('id');

            // Orgnnization name serach
            $message = false;


            if($request->org){
                $organizationQuery->where('organizations.organization_name', 'LIKE', '%'.$request->org.'%');
                if($organizationQuery->count() > 0){
                    $message = true;
                }
            }

            $backup_query = clone $organizationQuery;

            $active_page = 'organizations_leads';
            $title = 'Leads';

            $type = $request->type ?? null;
            if ($type === 'organizations_leads') {
                $organizationQuery->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('orders')
                        ->whereRaw('orders.organization_id = organizations.id');
                });
                $active_page = 'organizations_leads';
                $title = 'Leads';
                if($message && $request->org){
                    if($organizationQuery->count() < 1){
                        //This is not available on leads, Check on customers';
                        $active_page = 'organizations_customers';
                        $title = 'Customers';
                        $organizationQuery = clone $backup_query;
                    }
                }
            } elseif ($type === 'organizations_customers') {
                $organizationQuery->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('orders')
                        ->whereRaw('orders.organization_id = organizations.id');
                });
                $active_page = 'organizations_customers';
                $title = 'Customers';
                if($message && $request->org){
                    if($organizationQuery->count() < 1){
                        //This is not available on customers, Check on leads';
                        $active_page = 'organizations_leads';
                        $title = 'Leads';
                        $organizationQuery = clone $backup_query;
                    }
                }
            }

            $organizations = $organizationQuery->paginate(50);

            $peoples = Contact::where('active', 1)
                            ->orderBy('first_name')
                            ->get();

            $organizationLayout = OrganizationLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 2)->where('user_id', Auth::user()->id)->first();

            $users = User::select('id', 'name')->where('user_role_id', 3)->get();

            $activity_roleId = Role::where('name', 'Activity Users')->value('id');

            $activity_users = User::select('id', 'name')
                ->where('active', 1)
                ->whereJsonContains('role_id', (string) $activity_roleId)
                ->orderBy('name')
                ->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $colorMasters = ColorMaster::get();

            $lead_sources = LeadSource::where('active', 1)->get();

            return view('pages.contacts.organizations.index', [
                'peoples'=>$peoples, 'users'=>$users, 'organizations'=>$organizations, 'colorMasters'=>$colorMasters, 'organizationLayout'=>$organizationLayout, 'sports'=>$sports, 'columnLayout'=>$columnLayout , 'active_page'=>$active_page , 'title'=>$title, 'lead_sources'=>$lead_sources,'activity_users'=>$activity_users
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
    public function OrganizationExport(Request $request)
    {
        if (!auth()->user()->can('view organization')) {
            return redirect()->back()->withError('Permission Not Granted!');
        }

        $organizations = Organization::with([
            'contactOrganizations.contacts',
            'orders'
        ])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders')
                ->whereRaw('orders.organization_id = organizations.id');
        })
        ->orderBy('id')
        ->get();

        $filename = "organizations_export_" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ORGANIZATION NAME',
            'WEBSITE',
            'CONTACT PEOPLE',
            'CITY',
            'STATE',
            'POSTAL CODE',
            'COUNTRY',
            'CREATED AT'
        ];

        return response()->streamDownload(function () use ($organizations, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($organizations as $org) {

                $contactList = [];

                foreach ($org->contactOrganizations as $co) {
                    foreach ($co->contacts as $contact) {
                        $fullName = trim($contact->first_name . ' ' . $contact->last_name);
                        $contactList[] = $fullName . ' (' . $contact->email . ')';
                    }
                }

                $contactsString = implode("; ", $contactList);

                fputcsv($file, [
                    $org->organization_name ?? '',
                    $org->website ?? '',
                    $contactsString,
                    $org->shipping_city ?? '',
                    $org->shipping_state ?? '',
                    $org->shipping_zip ?? '',
                    $org->shipping_country ?? '',
                    $org->created_at ? $org->created_at->format('Y-m-d') : '',
                ]);
            }

            fclose($file);

        }, $filename, $headers);
    }

    public function master_index(){
        if(auth()->user()->can('view organization')){
            return view('pages.masters.organizations.index');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
    public function get_all_organizations(Request $request)
    {
        if (!empty($request->text)) {
            $organizations = Organization::where('organization_name', 'LIKE', '%' . $request->text . '%')->with('userDetails', 'sportDetails')->where('active', 1)->get();
        } else {
            $organizations = Organization::where('active', 1)->with('userDetails','sportDetails')->get();
        }

        $lead_sources = LeadSource::where('active', 1)->get();
        $sports = Sport::where('active', 1)->get();

        $response = [
            'organizations' => $organizations,
            'lead_sources' => $lead_sources,
            'sports' => $sports
        ];

        return response()->json($response);
    }
    public function update_lead_source(Request $request)
    {
        $organization = Organization::find($request->organization_id);

        if($request->has('lead_source')){
            $organization->lead_source = $request->lead_source ? $request->lead_source : null;
            $organization->save();
        }
        if($request->has('sport')){
            $organization->sport = $request->sport ? $request->sport : null;
            $organization->save();
        }

        return response()->json(['status'=>201, 'message'=>'successfully updated']);
    }


    public function getPeopleList() {
        $people = Contact::select('id', 'first_name', 'last_name')->where('active', 1)->orderBy('first_name')->get();
        return json_encode($people);
    }

    public function organizationsAdd(){
        $users = User::select('id', 'name')->get();

        $organizations = Organization::select('id', 'organization_name')->get();

        return view('pages.contacts.organizations.create', ['users'=>$users, 'organizations'=>$organizations]);
    }

    public function create(Request $request){
        if($request->has('organization_logo')){
            $logoImagePath = self::uploadOrganizationLogo($request);
        } else {
            $logoImagePath = "assets/img/organization/default.png";
        }

        $organization = new Organization();
        $organization->organization_name = $request->organization_name;
        $organization->website = $request->website;
        $organization->email = $request->email;
        $organization->sport = $request->sport;
        $organization->user_id = $request->user_id;
        $organization->sales_tax = $request->sales_tax;
        $organization->sales_tax_active = $request->sales_tax_active;
        $organization->size_of_club = $request->size_of_club;
        // $organization->colors = $request->colors;
        $organization->organization_logo = $logoImagePath;
        // $organization->shipping_po_box = $request->shipping_po_box;
        $organization->shipping_street = $request->shipping_street;
        $organization->shipping_city = $request->shipping_city;
        $organization->shipping_state = $request->shipping_state;
        $organization->shipping_postal_code = $request->shipping_postal_code;
        $organization->shipping_country = $request->shipping_country;

        $organization->lead_source = $request->lead_source;
        $organization->pl_status = $request->add_plcustomer;

        $organization->active =  1;
        $organization->save();

        if($request->customer_id!=null){
            foreach($request->customer_id as $customer){
                $contactOrganization= new ContactOrganization();
                $contactOrganization->contact_id = $customer;
                $contactOrganization->organization_id=$organization->id;
                $contactOrganization->save();
            }
        }
        if($request->colors!=null){
            foreach($request->colors as $organization_color){
                $organizationColor= new OrganizationColor();
                $organizationColor->organization_id = $organization->id;
                $organizationColor->color_id=$organization_color;
                $organizationColor->save();
            }
        }

        if($request->has('existing_people')){
            return redirect()->route('people.info', [$request->existing_people])->withSuccess('People Saved Successfully!');
        } else {
            return redirect()->route('organizations')->withSuccess('Organizations Saved Successfully!');
        }
    }

    public function editContacts(Request $request){
        ContactOrganization::where('organization_id', $request->organization_id_in_model)->delete();
        if($request->contact_ids!=null){
            foreach($request->contact_ids as $contact_id){
                $contactOrganization= new ContactOrganization();
                $contactOrganization->contact_id = $contact_id;
                $contactOrganization->organization_id=$request->organization_id_in_model;
                $contactOrganization->save();
            }
        }
        return redirect()->back()->withSuccess('Contact List Updated Successfully!');
    }

    public function createJson(Request $request){
        try {
            $checkOrganization = Organization::where('organization_name', $request->organization_name)->first();
            if($checkOrganization){
                $msg = array('error', 'Organization Already Exists!');
            } else {
                if($request->has('organization_logo')){
                    $logoImagePath = self::uploadOrganizationLogo($request);
                } else {
                    $logoImagePath = "assets/img/organization/default.png";
                }

                $organization = new Organization();
                $organization->organization_name = $request->organization_name;
                $organization->website = $request->website;
                $organization->email = $request->email;
                $organization->sport = $request->sport;
                $organization->user_id = $request->user_id;
                if(isset($request->lead_source)){
                    $organization->lead_source = $request->lead_source;
                }
                $organization->sales_tax = $request->sales_tax;
                $organization->sales_tax_active = $request->sales_tax_active;
                $organization->size_of_club = $request->size_of_club;
                // $organization->colors = $request->colors;
                $organization->organization_logo = $logoImagePath;
                $organization->pl_status = $request->add_plcustomer;
                // $organization->shipping_po_box = $request->shipping_po_box;
                $organization->shipping_street = $request->shipping_street;
                $organization->shipping_city = $request->shipping_city;
                $organization->shipping_state = $request->shipping_state;
                $organization->shipping_postal_code = $request->shipping_postal_code;
                $organization->shipping_country = $request->shipping_country;
                $organization->active =  1;
                $organization->save();

                OrganizationColor::where('organization_id', $organization->id)->delete();
                if($request->colors!=null){
                    foreach($request->colors as $organization_color){
                        $organizationColor= new OrganizationColor();
                        $organizationColor->organization_id = $organization->id;
                        $organizationColor->color_id=$organization_color;
                        $organizationColor->save();
                    }
                }

                $msg = array('success', $organization);
            }
        } catch (\Exception $ex) {
            $msg = array('error', $ex->errorInfo[2]);
        }
        return json_encode($msg);
    }

    public function uploadOrganizationLogo(Request $request) {
        $file = $request->file('organization_logo');

        $destinationPath = 'assets/img/organization';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath.'/'.$file->getClientOriginalName();
    }

    public function sortByAlphabet($id){
        if($id == 'num') {
            $organizations = Organization::select('organizations.id', 'organizations.organization_name', 'organizations.website', 'organizations.email',
                                                'organizations.sport', 'organizations.size_of_club', 'organizations.colors', 'organizations.organization_logo',
                                                'organizations.shipping_street', 'organizations.shipping_city', 'organizations.shipping_state',
                                                'organizations.shipping_postal_code', 'organizations.shipping_country', 'organizations.sales_tax',
                                                'organizations.sales_tax_active', 'organizations.created_at', 'organizations.updated_at', 'users.name')
                                        ->join('users', 'users.id', '=', 'organizations.user_id')
                                        ->where('organizations.active', 1)
                                        ->where('organizations.organization_name', 'regexp', '^[0-9]+')
                                        ->orderBy('organization_name')
                                        ->get();
        } else {
            $organizations = Organization::select('organizations.id', 'organizations.organization_name', 'organizations.website', 'organizations.email',
                                                'organizations.sport', 'organizations.size_of_club', 'organizations.colors', 'organizations.organization_logo',
                                                'organizations.shipping_street', 'organizations.shipping_city', 'organizations.shipping_state',
                                                'organizations.shipping_postal_code', 'organizations.shipping_country', 'organizations.sales_tax',
                                                'organizations.sales_tax_active', 'organizations.created_at', 'organizations.updated_at', 'users.name')
                                        ->join('users', 'users.id', '=', 'organizations.user_id')
                                        ->where('organizations.active', 1)
                                        ->where('organizations.organization_name', 'LIKE', $id.'%')
                                        ->orderBy('organization_name')
                                        ->get();
        }

        return json_encode($organizations);
    }

    public function edit($organizationId){
        $organization = Organization::find($organizationId);

        $users = User::select('id', 'name')->get();

        return view('pages.contacts.organizations.edit', ['organization'=>$organization, 'users'=>$users]);
    }

    public function update(Request $request){
        $validator = \Validator::make(
            $request->all(), [
                'organization_name' => 'required',
                ]
            );

            if($validator->fails()){
                return redirect()->back()->withError('Organization Name is Required');
            }

            if (isset($request->received_samples_products)) {
                OrganizationReceivedSample::where('organization_id', $request->organization_id)->delete();

                $received_samples_products = $request->received_samples_products;

                foreach ($received_samples_products as $received_samples_product) {
                    $sample_record = new OrganizationReceivedSample();
                    $sample_record->organization_id = $request->organization_id;
                    $sample_record->product_id = $received_samples_product;
                    $sample_record->save();
                }
            }

        $organization = Organization::find($request->organization_id);
        // $organization->shipping_street = $request->shipping_street;
        // $organization->organization_logo = $logoImagePath;

        $organization->organization_name = $request->organization_name;
        $organization->website = $request->website;
        $organization->email = $request->email;
        $organization->sport = $request->sport;
        $organization->user_id = $request->user_id;
        $organization->sales_tax = $request->sales_tax;
        $organization->sales_tax_active = $request->sales_tax_active;
        $organization->size_of_club = $request->size_of_club;
        $organization->colors = $request->colors;
        $organization->pl_status = $request->pl_status;
        $organization->organization_note = $request->organization_note;
        $organization->internal_team = $request->Internal_team_status;

        $organization->lead_source = $request->lead_source;
        if(isset($request->ordering_timeline)){
            $organization->ordering_timeline = $request->ordering_timeline;
        }
        if(isset($request->sample_received_on)){
            $sampleReceivedOn = trim($request->sample_received_on);
            $rules = [
                'sample_received_on' => 'required|date_format:m/d/Y'
                ];
                $validator = Validator::make(['sample_received_on' => $sampleReceivedOn], $rules);
                if (!$validator->fails()) {
                    $receivedSampleDate = Carbon::createFromFormat('m/d/Y', $sampleReceivedOn)->startOfDay();
                $organization->received_sample = $receivedSampleDate;
                $organization->received_samples_note = $request->received_samples_note ?? '';
            }
        }

        if($request->has('organization_logo')){
            $logoImagePath = self::uploadOrganizationLogo($request);
            $organization->organization_logo = $logoImagePath;
        }

        // $organization->shipping_po_box = $request->shipping_po_box;
        $organization->shipping_street = $request->shipping_street;
        $organization->shipping_city = $request->shipping_city;
        $organization->shipping_state = $request->shipping_state;
        $organization->shipping_postal_code = $request->shipping_postal_code;
        $organization->shipping_country = $request->shipping_country;

        $organization->same_as_shipping_address = $request->has('same_as_shipping_address') ? 1 : 0;
        if(!$request->has('same_as_shipping_address')){
            $organization->billing_street = $request->billing_street ?? null;
            $organization->billing_city = $request->billing_city ?? null;
            $organization->billing_state = $request->billing_state ?? null;
            $organization->billing_postal_code = $request->billing_postal_code ?? null;
            $organization->billing_country = $request->billing_country ?? null;
        }


        $organization->password_text = $request->unique_password;
        $organization->unique_password = Hash::make($request->unique_password);

        $organization->update();
        // $organization->update($request->all());

        OrganizationColor::where('organization_id', $request->organization_id)->delete();
            if($request->team_color!=null){
                foreach($request->team_color as $organization_color){
                    $organizationColor= new OrganizationColor();
                    $organizationColor->organization_id = $request->organization_id;
                    $organizationColor->color_id=$organization_color;
                    $organizationColor->save();
                }
            }

        $orders = Order::where('organization_id', $organization->id)->whereIn('order_status_id', [1,2,3])->get();
        foreach ($orders as $order) {
            $orderSubTotal = OrderItem::where('order_id', $order->id)->sum('total');

            $orderDetails = Order::find($order->id);
            if ($request->sales_tax_active == "1") {
                $salesTax = $request->sales_tax;
            } else {
                $salesTax = 0;
            }
            $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
            $orderShipping = $orderDetails->shipping ?? '';
            $orderArtwork = $orderDetails->artwork ?? '';
            $orderProcessingFee = $orderDetails->processing_fee ?? '';
            $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;

            $orderDetails->order_total = $orderSubTotal + $orderFeesTotal;
            $orderDetails->sales_tax = $orderSalesTax;
            $orderDetails->update();
        }

        // return redirect()->route('organizations')->withSuccess('Organizations Updated Successfully!');
        return redirect()->back()->withSuccess('Organizations Updated Successfully!');
    }

    public function migrateOldSampleShipments()
    {
        if (!auth()->user()->can('view organization')) {
            return response()->json([
                'success' => false,
                'message' => 'Permission Not Granted!',
            ], 403);
        }

        $created = 0;
        $skipped = 0;
        $failed = 0;
        $errors = [];

        $query = Organization::with('receivedSamplesOrganizations')
            ->where(function ($query) {
                $query->whereNotNull('received_sample')
                    ->orWhereHas('receivedSamplesOrganizations');
            })
            ->orderBy('id');

        $sourceCount = (clone $query)->count();

        $query->chunkById(200, function ($organizations) use (&$created, &$skipped, &$failed, &$errors) {
            foreach ($organizations as $organization) {
                try {
                    // Do not overwrite anything already created in the new workflow.
                    if (OrganizationSampleShipment::where('organization_id', $organization->id)->exists()) {
                        $skipped++;
                        continue;
                    }

                    $products = $organization->receivedSamplesOrganizations
                        ->pluck('product_id')
                        ->filter()
                        ->unique()
                        ->map(function ($productId) {
                            return [
                                'product_id' => (int) $productId,
                                // The old sample feature did not store a size.
                                'size_id' => null,
                            ];
                        })
                        ->values()
                        ->all();

                    $receivedDate = null;

                    if (!empty($organization->received_sample)) {
                        $receivedDate = Carbon::parse($organization->received_sample)->format('Y-m-d');
                    }

                    OrganizationSampleShipment::create([
                        'organization_id' => $organization->id,
                        'status' => 'received',
                        'received_date' => $receivedDate,
                        'delivered_date' => null,
                        'products' => $products,
                        'fabric_swatches' => [],
                        'shipping_street' => $organization->shipping_street,
                        'shipping_city' => $organization->shipping_city,
                        'shipping_state' => $organization->shipping_state,
                        'shipping_postal_code' => $organization->shipping_postal_code,
                        'shipping_country' => $organization->shipping_country,
                        'note' => $organization->received_samples_note ?? null,
                        'created_by' => Auth::id(),
                    ]);

                    $created++;
                } catch (\Throwable $e) {
                    $failed++;
                    $errors[] = [
                        'organization_id' => $organization->id,
                        'organization_name' => $organization->organization_name,
                        'message' => $e->getMessage(),
                    ];
                }
            }
        }, 'id');

        return response()->json([
            'success' => $failed === 0,
            'message' => 'Old organization sample data migration completed.',
            'source_records' => $sourceCount,
            'created' => $created,
            'skipped_existing' => $skipped,
            'failed' => $failed,
            'errors' => $errors,
        ]);
    }

    public function saveSampleShipment(Request $request, $id)
    {
        if (!auth()->user()->can('view organization')) {
            return response()->json([
                'success' => false,
                'message' => 'Permission Not Granted!',
            ], 403);
        }

        $organization = Organization::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'received_date' => 'required|date_format:m/d/Y',
            'products' => 'nullable|array',
            'products.*.product_id' => 'nullable|integer|exists:sub_products,id',
            'products.*.size_id' => [
                'nullable',
                'integer',
                Rule::exists('sizes', 'id')->where(function ($query) {
                    $query->where('active', 1)
                        ->where('size_name', 'not like', 'Extra Size%');
                }),
            ],
            'fabric_swatches' => 'nullable|array',
            'fabric_swatches.*' => 'integer|exists:fabrics,id',
            'shipping_street' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_postal_code' => 'nullable|string|max:100',
            'shipping_country' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:65000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $products = collect($request->input('products', []))
            ->filter(function ($item) {
                return !empty($item['product_id']) || !empty($item['size_id']);
            })
            ->map(function ($item) {
                return [
                    'product_id' => !empty($item['product_id']) ? (int) $item['product_id'] : null,
                    'size_id' => !empty($item['size_id']) ? (int) $item['size_id'] : null,
                ];
            })
            ->values();

        foreach ($products as $item) {
            if (empty($item['product_id']) || empty($item['size_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select both a product and size for every sample item.',
                ], 422);
            }
        }

        $fabricSwatches = collect($request->input('fabric_swatches', []))
            ->filter()
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values();

        if ($products->isEmpty() && $fabricSwatches->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Select at least one product sample or fabric swatch.',
            ], 422);
        }

        $existingShipment = OrganizationSampleShipment::where('organization_id', $id)->first();
        $receivedDate = Carbon::createFromFormat('m/d/Y', trim($request->received_date))->format('Y-m-d');

        // The sample shipment keeps its own shipping-address snapshot.
        // If an address field is not supplied, default it from the organization.
        $sampleShippingStreet = trim((string) $request->input('shipping_street')) !== ''
            ? $request->input('shipping_street')
            : $organization->shipping_street;
        $sampleShippingCity = trim((string) $request->input('shipping_city')) !== ''
            ? $request->input('shipping_city')
            : $organization->shipping_city;
        $sampleShippingState = trim((string) $request->input('shipping_state')) !== ''
            ? $request->input('shipping_state')
            : $organization->shipping_state;
        $sampleShippingPostalCode = trim((string) $request->input('shipping_postal_code')) !== ''
            ? $request->input('shipping_postal_code')
            : $organization->shipping_postal_code;
        $sampleShippingCountry = trim((string) $request->input('shipping_country')) !== ''
            ? $request->input('shipping_country')
            : $organization->shipping_country;

        $shipment = OrganizationSampleShipment::updateOrCreate(
            ['organization_id' => $id],
            [
                'status' => $existingShipment && $existingShipment->status === 'delivered' ? 'delivered' : 'requested',
                'received_date' => $receivedDate,
                // 'delivered_date' => $existingShipment ? $existingShipment->delivered_date : null,
                'products' => $products->all(),
                'fabric_swatches' => $fabricSwatches->all(),
                'contact_id' => $request->input('shipping_contact_id'),
                'shipping_street' => $sampleShippingStreet,
                'shipping_city' => $sampleShippingCity,
                'shipping_state' => $sampleShippingState,
                'shipping_postal_code' => $sampleShippingPostalCode,
                'shipping_country' => $sampleShippingCountry,
                // 'tracking_link' => $request->input('tracking_link'),
                // 'tracking_number' => $request->input('tracking_number'),
                'note' => $request->input('note'),
                'created_by' => $existingShipment && $existingShipment->created_by
                    ? $existingShipment->created_by
                    : Auth::id(),
            ]
        );

        // The legacy received-sample fields/tables are intentionally left untouched.
        // Historical data can be copied into the new table with the one-time migration route.

        $productIds = $products->pluck('product_id')->filter()->unique()->values();
        $sizeIds = $products->pluck('size_id')->filter()->unique()->values();

        $productNames = SubProduct::whereIn('id', $productIds)
            ->pluck('product_name', 'id');

        $sizeNames = Size::whereIn('id', $sizeIds)
            ->pluck('size_name', 'id');

        $productItems = $products->map(function ($item) use ($productNames, $sizeNames) {
            return [
                'product_name' => $productNames->get($item['product_id'], ''),
                'size_name' => $sizeNames->get($item['size_id'], ''),
            ];
        })->values()->all();

        $fabricNameMap = Fabric::whereIn('id', $fabricSwatches)
            ->pluck('fabric_name', 'id');

        $fabricNames = $fabricSwatches
            ->map(function ($fabricId) use ($fabricNameMap) {
                return $fabricNameMap->get($fabricId);
            })
            ->filter()
            ->values()
            ->all();

        $organization->loadMissing('userDetails');

        $cityState = implode(', ', array_filter([
            trim((string) $shipment->shipping_city),
            trim((string) $shipment->shipping_state),
        ], function ($value) {
            return $value !== '';
        }));

        $cityStatePostal = trim(
            $cityState
            . (!empty($shipment->shipping_postal_code)
                ? ($cityState !== '' ? ' ' : '') . $shipment->shipping_postal_code
                : '')
        );

        $shippingAddress = array_values(array_filter([
            $shipment->shipping_street,
            $cityStatePostal,
            $shipment->shipping_country,
        ], function ($value) {
            return $value !== null && trim((string) $value) !== '';
        }));

        $salesLeadName = optional($organization->userDetails)->name ?: optional(Auth::user())->name;

        $emailSent = app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
            'key_organization_sample_package_request',
            [
                'organization_id' => $organization->id,
                'organizationName' => $organization->organization_name,
                'organizationSampleRequestLink' => route('organizations.info', ['id' => $organization->id, 'tab' => 'sample']),
                'productItems' => $productItems,
                'fabricNames' => $fabricNames,
                'shippingAddress' => $shippingAddress,
                'salesLeadName' => $salesLeadName,
            ]
        );

        $itemsHtml = collect($productItems)->map(function ($item) {
            $productName = e($item['product_name'] ?? '');
            $sizeName = !empty($item['size_name'])
                ? ' - ' . e($item['size_name'])
                : '';

            return '<div style="padding:8px 0;border-bottom:1px solid #e5e7eb;">'
                . '<span style="font-weight:600;color:#111827;">' . $productName . '</span>'
                . '<span style="color:#6b7280;">' . $sizeName . '</span>'
                . '</div>';
        })->implode('');

        $fabricSwatchesHtml = collect($fabricNames)->map(function ($fabric) {
            return '<div style="padding:7px 0;border-bottom:1px solid #e5e7eb;color:#374151;">'
                . e($fabric)
                . '</div>';
        })->implode('');

        $shippingAddressHtml = collect($shippingAddress)
            ->map(function ($line) {
                return e($line);
            })
            ->implode('<br>');

        $notificationSent = app(NotificationBuilderService::class)->sendNotification(
            'key_organization_sample_package_request',
            [
                '{organization_sample_request_link}' => route('organizations.info', ['id' => $organization->id, 'tab' => 'sample']),
                '{organization_name}' => e($organization->organization_name),
                '{items_html}' => $itemsHtml
                    ?: '<span style="color:#9ca3af;">No product samples selected.</span>',
                '{fabric_swatches_html}' => $fabricSwatchesHtml
                    ?: '<span style="color:#9ca3af;">No fabric swatches selected.</span>',
                '{shipping_address_html}' => $shippingAddressHtml
                    ?: '<span style="color:#9ca3af;">No shipping address available.</span>',
                '{sales_lead_name}' => e($salesLeadName),
            ],
            [
                'new_notification' => 1,
                'target_notification_field' => 'key_organization_sample_package_request',
            ]
        );

        $message = 'Sample request sent successfully.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'email_sent' => $emailSent,
            'notification_sent' => $notificationSent,
            'status' => $shipment->status,
            'received_date' => optional($shipment->received_date)->format('m/d/Y'),
            'delivered_date' => optional($shipment->delivered_date)->format('m/d/Y'),
        ]);
    }

    public function markSampleShipmentDelivered(Request $request, $id)
    {
        if (!auth()->user()->can('view organization')) {
            return response()->json([
                'success' => false,
                'message' => 'Permission Not Granted!',
            ], 403);
        }

        $organization = Organization::findOrFail($id);
        $shipment = OrganizationSampleShipment::where('organization_id', $id)->first();

        if (!$shipment) {
            return response()->json([
                'success' => false,
                'message' => 'Request the samples before confirming delivery.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'delivered_date' => 'required|date_format:m/d/Y',
            'received_date' => 'required|date_format:m/d/Y',
            'products' => 'nullable|array',
            'products.*.product_id' => 'nullable|integer|exists:sub_products,id',
            'products.*.size_id' => [
                'nullable',
                'integer',
                Rule::exists('sizes', 'id')->where(function ($query) {
                    $query->where('active', 1)
                        ->where('size_name', 'not like', 'Extra Size%');
                }),
            ],
            'fabric_swatches' => 'nullable|array',
            'fabric_swatches.*' => 'integer|exists:fabrics,id',
            'shipping_street' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_postal_code' => 'nullable|string|max:100',
            'shipping_country' => 'nullable|string|max:255',
            'tracking_link' => 'required|string|max:255',
            'tracking_number' => 'required|string|max:255',
            'note' => 'nullable|string|max:65000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $products = collect($request->input('products', []))
            ->filter(function ($item) {
                return !empty($item['product_id']) || !empty($item['size_id']);
            })
            ->map(function ($item) {
                return [
                    'product_id' => !empty($item['product_id']) ? (int) $item['product_id'] : null,
                    'size_id' => !empty($item['size_id']) ? (int) $item['size_id'] : null,
                ];
            })
            ->values();

        foreach ($products as $item) {
            if (empty($item['product_id']) || empty($item['size_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select both a product and size for every sample item.',
                ], 422);
            }
        }

        $fabricSwatches = collect($request->input('fabric_swatches', []))
            ->filter()
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values();

        if ($products->isEmpty() && $fabricSwatches->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Select at least one product sample or fabric swatch.',
            ], 422);
        }

        $receivedDate = Carbon::createFromFormat('m/d/Y', trim($request->received_date))->format('Y-m-d');

        $sampleShippingStreet = trim((string) $request->input('shipping_street')) !== ''
            ? $request->input('shipping_street')
            : $organization->shipping_street;
        $sampleShippingCity = trim((string) $request->input('shipping_city')) !== ''
            ? $request->input('shipping_city')
            : $organization->shipping_city;
        $sampleShippingState = trim((string) $request->input('shipping_state')) !== ''
            ? $request->input('shipping_state')
            : $organization->shipping_state;
        $sampleShippingPostalCode = trim((string) $request->input('shipping_postal_code')) !== ''
            ? $request->input('shipping_postal_code')
            : $organization->shipping_postal_code;
        $sampleShippingCountry = trim((string) $request->input('shipping_country')) !== ''
            ? $request->input('shipping_country')
            : $organization->shipping_country;

        $shipment->status = 'delivered';
        $shipment->received_date = $receivedDate;
        $shipment->delivered_date = $request->filled('delivered_date')
            ? Carbon::createFromFormat('m/d/Y', trim($request->delivered_date))->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');
        $shipment->products = $products->all();
        $shipment->fabric_swatches = $fabricSwatches->all();
        $shipment->contact_id = $request->input('shipping_contact_id');
        $shipment->shipping_street = $sampleShippingStreet;
        $shipment->shipping_city = $sampleShippingCity;
        $shipment->shipping_state = $sampleShippingState;
        $shipment->shipping_postal_code = $sampleShippingPostalCode;
        $shipment->shipping_country = $sampleShippingCountry;
        $shipment->tracking_link = $request->input('tracking_link');
        $shipment->tracking_number = $request->input('tracking_number');
        $shipment->note = $request->input('note');
        $shipment->confirmed_by = Auth::id();
        $shipment->update();

        $productIds = $products->pluck('product_id')->filter()->unique()->values();
        $sizeIds = $products->pluck('size_id')->filter()->unique()->values();

        $productNames = SubProduct::whereIn('id', $productIds)
            ->pluck('product_name', 'id');

        $sizeNames = Size::whereIn('id', $sizeIds)
            ->pluck('size_name', 'id');

        $productItems = $products->map(function ($item) use ($productNames, $sizeNames) {
            return [
                'product_name' => $productNames->get($item['product_id'], ''),
                'size_name' => $sizeNames->get($item['size_id'], ''),
            ];
        })->values()->all();

        $fabricNameMap = Fabric::whereIn('id', $fabricSwatches)
            ->pluck('fabric_name', 'id');

        $fabricNames = $fabricSwatches
            ->map(function ($fabricId) use ($fabricNameMap) {
                return $fabricNameMap->get($fabricId);
            })
            ->filter()
            ->values()
            ->all();

        $organization->loadMissing('userDetails');

        $cityState = implode(', ', array_filter([
            trim((string) $shipment->shipping_city),
            trim((string) $shipment->shipping_state),
        ], function ($value) {
            return $value !== '';
        }));

        $cityStatePostal = trim(
            $cityState
            . (!empty($shipment->shipping_postal_code)
                ? ($cityState !== '' ? ' ' : '') . $shipment->shipping_postal_code
                : '')
        );

        $shippingAddress = array_values(array_filter([
            $shipment->shipping_street,
            $cityStatePostal,
            $shipment->shipping_country,
        ], function ($value) {
            return $value !== null && trim((string) $value) !== '';
        }));

        $confirmedByName = optional($shipment->confirmedUser)->name ?: optional(Auth::user())->name;

        $emailSent = app(EmailNotificationBuilderService::class)->sendEmailFromTemplate(
            'key_organization_sample_package_confirmed',
            [
                'organization_id' => $organization->id,
                'organizationName' => $organization->organization_name,
                'organizationSampleRequestLink' => route('organizations.info', ['id' => $organization->id, 'tab' => 'sample']),
                'productItems' => $productItems,
                'fabricNames' => $fabricNames,
                'shippingAddress' => $shippingAddress,
                'confirmedByName' => $confirmedByName,
                'est_delivery_date' => Carbon::parse($shipment->delivered_date)->format('m/d/Y'),
                'tracking_number' => $shipment->tracking_number,
                'tracking_link' => $shipment->tracking_link,
            ]
        );

        $itemsHtml = collect($productItems)->map(function ($item) {
            $productName = e($item['product_name'] ?? '');
            $sizeName = !empty($item['size_name'])
                ? ' - ' . e($item['size_name'])
                : '';

            return '<div style="padding:8px 0;border-bottom:1px solid #e5e7eb;">'
                . '<span style="font-weight:600;color:#111827;">' . $productName . '</span>'
                . '<span style="color:#6b7280;">' . $sizeName . '</span>'
                . '</div>';
        })->implode('');

        $fabricSwatchesHtml = collect($fabricNames)->map(function ($fabric) {
            return '<div style="padding:7px 0;border-bottom:1px solid #e5e7eb;color:#374151;">'
                . e($fabric)
                . '</div>';
        })->implode('');

        $shippingAddressHtml = collect($shippingAddress)
            ->map(function ($line) {
                return e($line);
            })
            ->implode('<br>');

        $notificationSent = app(NotificationBuilderService::class)->sendNotification(
            'key_organization_sample_package_confirmed',
            [
                '{organization_sample_request_link}' => route('organizations.info', ['id' => $organization->id, 'tab' => 'sample']),
                '{organization_name}' => e($organization->organization_name),
                '{items_html}' => $itemsHtml
                    ?: '<span style="color:#9ca3af;">No product samples selected.</span>',
                '{fabric_swatches_html}' => $fabricSwatchesHtml
                    ?: '<span style="color:#9ca3af;">No fabric swatches selected.</span>',
                '{shipping_address_html}' => $shippingAddressHtml
                    ?: '<span style="color:#9ca3af;">No shipping address available.</span>',
                '{confirmed_by_name}' => e($confirmedByName),
                '{est_delivery_date}' => Carbon::parse($shipment->delivered_date)->format('m/d/Y'),
                '{tracking_number}' => e($shipment->tracking_number),
                '{tracking_link}' => e($shipment->tracking_link),
            ],
            [
                'new_notification' => 1,
                'target_notification_field' => 'key_organization_sample_package_confirmed',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Sample shipment marked as delivered.',
            'email_sent' => $emailSent,
            'notification_sent' => $notificationSent,
            'status' => $shipment->status,
            'delivered_date' => optional($shipment->delivered_date)->format('m/d/Y'),
        ]);
    }

    public function uploadSampleShipmentImage(Request $request, $id)
    {
        if (!auth()->user()->can('view organization')) {
            return response()->json([
                'success' => false,
                'message' => 'Permission Not Granted!',
            ], 403);
        }

        try {
            if (!$request->hasFile('upload_file')) {
                return response()->json([
                    'error' => true,
                    'message' => 'No file(s) provided'
                ], 400);
            }

            $request->validate([
                'upload_file.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:20480'
            ]);

            $files = $request->file('upload_file');
            if (!is_array($files)) {
                $files = [$files];
            }

            $directoryPath = base_path('assets/Organizations/' . $id . '/samples');
            $relativePath  = 'assets/Organizations/' . $id . '/samples/';

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $results = [];

            foreach ($files as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                $originalName = $file->getClientOriginalName();
                $safeName = str_replace(["'", "\\", "/", ":", '"'], " ", $originalName);
                $finalName = $safeName;
                $counter = 1;

                while (file_exists($directoryPath . '/' . $finalName)) {
                    $nameOnly = pathinfo($safeName, PATHINFO_FILENAME);
                    $ext = pathinfo($safeName, PATHINFO_EXTENSION);
                    $finalName = $nameOnly . ' (' . $counter . ')' . ($ext ? '.' . $ext : '');
                    $counter++;
                }

                $file->move($directoryPath, $finalName);

                $storedPath = $relativePath . $finalName;
                $results[] = [
                    'name' => $finalName,
                    'path' => $storedPath,
                    'url'  => asset($storedPath),
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $results,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete($organizationId){
        $organization = Organization::find($organizationId);
        $organization->active = 0;
        $organization->update();

        return redirect()->route('organizations')->withSuccess('Organizations Deleted Successfully!');
    }

    public function info($id){
        if(auth()->user()->can('view organization')){
            $azure_logged_email = session('azure_logged_email') ?? null;

            $organizations = Organization::with('userDetails','sportDetails','receivedSamplesOrganizations')->where('id', $id)->get();

            // $contacts = Contact::select('contacts.id', 'contacts.first_name', 'contacts.last_name', 'contacts.phone_no', 'contacts.email', 'contacts.title',
            //                             'contacts.shipping_city', 'contacts.shipping_city', 'users.name')
            //                 ->join('users', 'users.id', '=', 'contacts.user_id')
            //                 ->where('contacts.organization_id', $id)
            //                 ->where('contacts.active', 1)
            //                 ->orderBy('contacts.first_name')
            //                 ->get();

            $isActive = true;

            foreach ($organizations as $organization){
                if($organization->active == 0 && $isActive){
                    return view('pages.contacts.organizations.inactive', [
                        'organization' => $organization,
                    ]);
                }
            }

            $contacts = Contact::select('contacts.id', 'contacts.first_name', 'contacts.last_name', 'contacts.phone_no', 'contacts.email', 'contacts.title',
                                        'contacts.shipping_city', 'contacts.shipping_country')
            ->join('contact_organizations', 'contact_organizations.contact_id', '=', 'contacts.id')
            ->with('leadSourceDetails')
            ->where('contacts.active', 1)
            ->where('contact_organizations.organization_id',$id)
            ->where('contact_organizations.deleted_at',null)
            ->orderBy('contacts.first_name')
            ->get();

            $contact_ids = ContactOrganization::where('organization_id', $id)->get()->pluck('contact_id');
            $peoples = Contact::where('active', 1)
                ->where(function ($query) {
                    $query->whereNotNull('first_name')
                        ->orWhereNotNull('last_name');
                })
                ->orderBy('first_name')
                ->get();

            $contactCount = ContactOrganization::where('organization_id', $id)->count();

            $users = User::select('id', 'name')->where('user_role_id', 3)->get();
            $Sales_rep_users = User::select('id', 'name')->whereJsonContains('role_id', "3")->orderBy('name')->where('active',1)->get();
            $allusers = User::select('id', 'name')->get();
            $activity_roleId = Role::where('name', 'Activity Users')->value('id');

            $activity_users = User::select('id', 'name')
                ->where('active', 1)
                ->whereJsonContains('role_id', (string) $activity_roleId)
                ->orderBy('name')
                ->get();

            $userGroups = Role::where('active','1')->orderBy('name')->get();

            $orders = Order::select('orders.id', 'orders.order_no', 'orders.order_total', 'orders.due_date', 'order_statuses.status_name',
                                    'users.name')
                        ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
                        ->join('users', 'users.id', '=', 'orders.user_id')
                        ->where('orders.organization_id', $id)
                        ->where('orders.active', 1)
                        ->orderBy('orders.order_no')
                        ->get();

            $payments = [];

            foreach ($orders as $order) {
                // Get all payment types for the current order
                $cardPayments = PaymentLog::where('order_id', $order->id)->get();
                $checkPayments = CheckPayment::where('order_id', $order->id)->where('is_approved', 1)->get();
                $paypalPayments = PaypalPayment::where('order_id', $order->id)->where('is_approved', 1)->get();
                $venmoPayments = VenmoPayment::where('order_id', $order->id)->where('is_approved', 1)->get();

                // Check if each type of payment is empty before iterating

                // Card payments
                if ($cardPayments->isNotEmpty()) {
                    foreach ($cardPayments as $payment) {
                        $payments[] = [
                            'order_id' => $order->id,
                            'order_no' => $order->order_no,
                            'payment_type' => 'Card Payment',
                            'amount' => $payment->amount,
                            'date' => $payment->created_at,
                        ];
                    }
                }

                // Check payments
                if ($checkPayments->isNotEmpty()) {
                    foreach ($checkPayments as $payment) {
                        $payments[] = [
                            'order_id' => $order->id,
                            'order_no' => $order->order_no,
                            'payment_type' => 'Check Payment',
                            'amount' => $payment->amount,
                            'date' => $payment->created_at,
                        ];
                    }
                }

                // Paypal payments
                if ($paypalPayments->isNotEmpty()) {
                    foreach ($paypalPayments as $payment) {
                        $payments[] = [
                            'order_id' => $order->id,
                            'order_no' => $order->order_no,
                            'payment_type' => 'Paypal Payment',
                            'amount' => $payment->amount,
                            'date' => $payment->created_at,
                        ];
                    }
                }

                // Venmo payments
                if ($venmoPayments->isNotEmpty()) {
                    foreach ($venmoPayments as $payment) {
                        $payments[] = [
                            'order_id' => $order->id,
                            'order_no' => $order->order_no,
                            'payment_type' => 'Venmo Payment',
                            'amount' => $payment->amount,
                            'date' => $payment->created_at,
                        ];
                    }
                }
            }

            $orderCount = Order::where('orders.organization_id', $id)->where('orders.active', 1)->count();

            $fileCount = OrderItemFile::where('organization_id', $id)->count();

            $activities = Activity::with('orderDetails', 'contactDetails', 'organizationDetails', 'assigneeDetails', 'userDetails')->where('organization_id', $id)->where('active', 1)->orderBy('start_date', 'desc')->get();

            $activityCount = Activity::where('organization_id', $id)->where('active', 1)->count();

            $user_timezone = Auth::user()->userDetails->timezone;

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $lead_sources = LeadSource::where('active', 1)->get();

            $sub_products = SubProduct::where('active', 1)
                ->orderBy('product_name')
                ->get();

            $sizes = Size::where('active', 1)
                ->where('size_name', 'not like', 'Extra Size%')
                ->orderBy('size_name')
                ->get(['id', 'size_name']);
            $fabrics = Fabric::orderBy('fabric_name')->get(['id', 'fabric_name']);

            $sampleShipment = OrganizationSampleShipment::where('organization_id', $id)->first();

            // Keep the historical "Received Sample" data visible in the new tab
            // until the record is saved in the new sample shipment table.
            if (!$sampleShipment && (!empty($organization->received_sample) || $organization->receivedSamplesOrganizations->isNotEmpty())) {
                $sampleShipment = new OrganizationSampleShipment();
                $sampleShipment->organization_id = $id;
                // $sampleShipment->status = 'requested';
                $sampleShipment->received_date = $organization->received_sample;
                $sampleShipment->products = $organization->receivedSamplesOrganizations
                    ->map(function ($sample) {
                        return [
                            'product_id' => (int) $sample->product_id,
                            'size_id' => null,
                        ];
                    })
                    ->values()
                    ->all();
                $sampleShipment->fabric_swatches = [];
                $sampleShipment->shipping_street = $organization->shipping_street;
                $sampleShipment->shipping_city = $organization->shipping_city;
                $sampleShipment->shipping_state = $organization->shipping_state;
                $sampleShipment->shipping_postal_code = $organization->shipping_postal_code;
                $sampleShipment->shipping_country = $organization->shipping_country;
                $sampleShipment->note = $organization->received_samples_note ?? null;
            }

            $organizationEmailQuery = OrganizationEmail::where('organization_id', $id)
                ->where('active', 1)
                ->where(function ($query) {
                    $query->whereNull('type')
                        ->orWhere('type', '!=', 'backup');
                });

            $orgnizationEmailCount = (clone $organizationEmailQuery)->count();

            // Load only the email metadata needed by the existing timeline.
            // The full body is fetched separately when .email-body-text is clicked.
            $orgnizationEmails = $organizationEmailQuery
                ->select([
                    'id',
                    'sender',
                    'sender_email',
                    'subject',
                    'type',
                    'date',
                    'toRecipients',
                    'ccRecipients',
                    'message_no',
                ])
                ->orderBy('date', 'desc')
                ->get();

            // Kept for the existing view contract without loading a second collection.
            $organization_email = collect();
            $colorMasters = ColorMaster::get();

            $organizationColors = OrganizationColor::where('organization_id', $id)->get();

            $organization_orders = Order::where('organization_id', $id)->get();

            if($organization_orders->count() == 0){

                $organization_status = 'Replied';

            }elseif($organization_orders->count() == 1){
                if($organization_orders->first()->order_status_id == 1){
                    $organization_status = 'Quoted';
                }else{
                    $organization_status = 'Ordered';
                }
            }else{
                $organization_status = 'Quoted';
                foreach ($organization_orders as $organization_order){
                    if($organization_order->order_status_id != 1 && $organization_order->order_status_id != 7){
                        $organization_status = 'Ordered';
                        break;
                    }
                }
            }
            $emailTemplates = EmailTemplate::where('user_id', Auth()->user()->id)->get();
            $AddedEmailTemplates = UserEmailTemplate::where('user_id', Auth()->user()->id)
                                            ->with('emailTemplate') // Eager load the associated email template details
                                            ->get();
            $mergedEmailTemplates = $emailTemplates->merge($AddedEmailTemplates->pluck('emailTemplate'));
            $emailTemplates = $mergedEmailTemplates->unique('id');

            $statementLayout = StatementLayout::firstOrCreate(
                ['user_id' => Auth::id()],
            );
            return view('pages.contacts.organizations.info', [
                'statementLayout'=>$statementLayout,'organizations'=>$organizations, 'peoples'=>$peoples,'user_timezone'=>$user_timezone, 'contacts'=>$contacts, 'orders'=>$orders, 'users'=>$users,'Sales_rep_users'=>$Sales_rep_users, 'allusers'=>$allusers,'userGroups'=>$userGroups, 'contactCount'=>$contactCount,
                'orderCount'=>$orderCount, 'activities'=>$activities, 'activityCount'=>$activityCount, 'fileCount'=>$fileCount, 'sports'=>$sports,
                'orgnizationEmailCount'=>$orgnizationEmailCount, 'orgnizationEmails'=>$orgnizationEmails, 'contact_ids'=>$contact_ids, 'colorMasters'=>$colorMasters, 'organization_status'=>$organization_status,
                'organizationColors'=>$organizationColors, 'organization_email'=>$organization_email, 'lead_sources'=>$lead_sources, 'sub_products'=>$sub_products, 'sizes'=>$sizes, 'fabrics'=>$fabrics, 'sampleShipment'=>$sampleShipment, 'AddedEmailTemplates'=>$AddedEmailTemplates, 'emailTemplates'=>$emailTemplates, 'azure_logged_email'=>$azure_logged_email,'activity_users'=>$activity_users,'payments'=>$payments
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
public function exportCsv(Request $request)
{

    if (!auth()->user()->can('view organization')) {
        return redirect()->back()
            ->withError('Permission Not Granted!');
    }

    $organizationQuery = Organization::select(
            'organizations.id',
            'organizations.organization_name',
            'organizations.website',
            'organizations.email',
            'organizations.sport',
            'organizations.size_of_club',
            'organizations.colors',
            'organizations.shipping_street',
            'organizations.shipping_city',
            'organizations.shipping_state',
            'organizations.shipping_postal_code',
            'organizations.shipping_country',
            'organizations.sales_tax',
            'organizations.sales_tax_active',
            'organizations.created_at',
            'organizations.updated_at',
            'users.name as user_name'
        )
        ->join('users', 'users.id', '=', 'organizations.user_id')
        ->where('organizations.active', 1)
        ->orderBy('organizations.id', 'asc');

    // Organization name search
    if ($request->filled('org')) {
        $organizationQuery->where(
            'organizations.organization_name',
            'LIKE',
            '%' . $request->org . '%'
        );
    }

    // Leads
    if ($request->type == 'organizations_leads') {
        $organizationQuery->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders')
                ->whereColumn(
                    'orders.organization_id',
                    'organizations.id'
                );
        });
    }

    // Customers
    if ($request->type == 'organizations_customers') {
        $organizationQuery->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders')
                ->whereRaw('orders.organization_id = organizations.id');
        });
    }

    $fileName = 'organizations_' . now()->format('Y-m-d_H-i-s') . '.csv';

    return response()->streamDownload(function () use ($organizationQuery) {
        $file = fopen('php://output', 'w');

        // UTF-8 BOM so Excel displays characters correctly
        fwrite($file, "\xEF\xBB\xBF");

        fputcsv($file, [
            'ID',
            'Organization Name',
            'Website',
            'Email',
            'Sport',
            'User',
            'Size of Club',
            'Colors',
            'Shipping Street',
            'Shipping City',
            'Shipping State',
            'Shipping Postal Code',
            'Shipping Country',
            'Sales Tax',
            'Sales Tax Active',
            'Created At',
            'Updated At',
        ]);

        // Chunk prevents memory issues for large exports
        $organizationQuery->chunk(500, function ($organizations) use ($file) {
            foreach ($organizations as $organization) {
                fputcsv($file, [
                    $organization->id,
                    $organization->organization_name,
                    $organization->website,
                    $organization->email,
                    $organization->sport,
                    $organization->user_name,
                    $organization->size_of_club,
                    $organization->colors,
                    $organization->shipping_street,
                    $organization->shipping_city,
                    $organization->shipping_state,
                    $organization->shipping_postal_code,
                    $organization->shipping_country,
                    $organization->sales_tax,
                    $organization->sales_tax_active ? 'Yes' : 'No',
                    optional($organization->created_at)->format('Y-m-d H:i:s'),
                    optional($organization->updated_at)->format('Y-m-d H:i:s'),
                ]);
            }
        });

        fclose($file);
    }, $fileName, [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Cache-Control' => 'no-store, no-cache',
    ]);
}
    public function exportCsv2(){
        $fileName = 'organizations.csv';
        $organizations = Organization::with('userDetails')->where('active', 1)->get();

        $headers = array(
            "Content-type"=>"text/csv",
            "Content-Disposition"=>"attachment; filename=$fileName",
            "Pragma"=>"no-cache",
            "Cache-Control"=>"must-revalidate, post-check=0, pre-check=0",
            "Expires"=>"0"
        );

        $columns = array('Organization Name', 'Website', 'Email', 'sport', 'Rating', 'Annual Revenue', 'Assign To',
                         'Size of Clubs', 'Colors', 'Sales Tax', 'Sales Tax Active', 'Shipping To', 'Shipping PO Box',
                         'Shipping City', 'Shipping State', 'Shipping Postal Code', 'Shipping Country', 'Billing To',
                         'Billing PO Box', 'Billing City', 'Billing State', 'Billing Postal Code', 'Billing Country');

        $callback = function() use($organizations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($organizations as $organization) {
                if($organization->sales_tax_active == 1){
                    $salesTaxActive = 'Yes';
                } else {
                    $salesTaxActive = 'No';
                }

                $row['Organization Name'] = $organization->organization_name;
                $row['Website'] = $organization->website;
                $row['Email'] = $organization->email;
                $row['sport'] = $organization->sport;
                $row['Rating'] = $organization->rating;
                $row['Annual Revenue'] = $organization->annual_revenue;
                $row['Assign To'] = $organization->userDetails['name'];
                $row['Size of Clubs'] = $organization->size_of_club;
                $row['Colors'] = $organization->colors;
                $row['Sales Tax'] = $organization->sales_tax;
                $row['Sales Tax Active'] = $salesTaxActive;
                $row['Shipping PO Box'] = $organization->shipping_po_box;
                $row['Shipping City'] = $organization->shipping_city;
                $row['Shipping State'] = $organization->shipping_state;
                $row['Shipping Postal Code'] = $organization->shipping_postal_code;
                $row['Shipping Country'] = $organization->shipping_country;
                $row['Billing To'] = $organization->billing_address;
                $row['Billing PO Box'] = $organization->billing_po_box;
                $row['Billing City'] = $organization->billing_city;
                $row['Billing State'] = $organization->billing_state;
                $row['Billing Postal Code'] = $organization->billing_postal_code;
                $row['Billing Country'] = $organization->billing_country;

                fputcsv($file, array(
                    $row['Organization Name'], $row['Website'], $row['Email'], $row['sport'], $row['Rating'],
                    $row['Annual Revenue'], $row['Assign To'], $row['Size of Clubs'], $row['Colors'], $row['Sales Tax'],
                    $row['Sales Tax Active'], $row['Shipping To'], $row['Shipping PO Box'], $row['Shipping City'],
                    $row['Shipping State'], $row['Shipping Postal Code'], $row['Shipping Country'], $row['Billing To'],
                    $row['Billing PO Box'], $row['Billing City'], $row['Billing State'], $row['Billing Postal Code'],
                    $row['Billing Country']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function layout(Request $request){
        if(OrganizationLayout::where('user_id', Auth::user()->id)->first()){
            $organizationLayout = OrganizationLayout::find($request->layout_id);
            $organizationLayout->organization_name = $request->organization_name;
            $organizationLayout->website = $request->website;
            $organizationLayout->email = $request->email;
            $organizationLayout->sport = $request->sport;
            $organizationLayout->user = $request->user_id;
            $organizationLayout->size_of_club = $request->size_of_club;
            $organizationLayout->colors = $request->colors;
            // $organizationLayout->organization_logo = $request->organization_logo;
            $organizationLayout->shipping_po_box = $request->shipping_po_box;
            $organizationLayout->shipping_city = $request->shipping_city;
            $organizationLayout->shipping_street = $request->shipping_street;
            $organizationLayout->shipping_state = $request->shipping_state;
            $organizationLayout->shipping_postal_code = $request->shipping_postal_code;
            $organizationLayout->shipping_country = $request->shipping_country;
            $organizationLayout->sales_tax = $request->sales_tax;
            $organizationLayout->sales_tax_active = $request->sales_tax_active;
            $organizationLayout->created = $request->created_at;
            $organizationLayout->updated = $request->updated_at;
            $organizationLayout->update();

            $successMsg = "Updated";

        } else {
            $organizationLayout = new OrganizationLayout();
            $organizationLayout->user_id = Auth::user()->id;
            $organizationLayout->organization_name = 1;
            $organizationLayout->website = 1;
            $organizationLayout->email = 1;
            $organizationLayout->sport = $request->sport;
            $organizationLayout->user = 1;
            $organizationLayout->size_of_club = $request->size_of_club;
            $organizationLayout->colors = $request->colors;
            // $organizationLayout->organization_logo = 1;
            $organizationLayout->shipping_po_box = $request->shipping_po_box;
            $organizationLayout->shipping_city = $request->shipping_city;
            $organizationLayout->shipping_street = $request->shipping_street;
            $organizationLayout->shipping_state = $request->shipping_state;
            $organizationLayout->shipping_postal_code = $request->shipping_postal_code;
            $organizationLayout->shipping_country = $request->shipping_country;
            $organizationLayout->sales_tax = $request->sales_tax;
            $organizationLayout->sales_tax_active = $request->sales_tax_active;
            $organizationLayout->created = $request->created_at;
            $organizationLayout->updated = $request->updated_at;
            $organizationLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }

    public function address($organizationId){
        $address = Organization::where('id', $organizationId)->first();
        return json_encode($address);
    }


    public function isDone($id, $status){
        $activity = Activity::find($id);
        $activity->is_done = $status;
        $activity->update();

        if($activity){
            if($status == 1){
                return json_encode('done');
            } else if($status == 0){
                return json_encode('not_done');
            }
        } else {
            return json_encode('error');
        }
    }

    public function omsFolders(Request $request) {
        $directoryArray = explode('/', $request->folderId);
        foreach ($directoryArray as $directory) {
            $breadcrumbFolder = Storage::disk('google')->getMetadata($directory);

            $breadcrumbDirArray = array(
                'name' => $breadcrumbFolder['name'],
                'path' => $breadcrumbFolder['path'],
            );

            $breadcrumbFolders[] = (object) $breadcrumbDirArray;
        }
        $folderDir['breadcrumbs'] = $breadcrumbFolders;

        $directories = Storage::disk('google')->directories($request->folderId);

        if($directories){
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                if (str_contains($folder['name'], 'Order ')) {
                    $orderName = explode(" ", $folder['name']);
                    $orderId = $orderName[1];

                    $order = Order::with('organizationDetails')->where('id', $orderId)->first();
                    if ($order->organization_id == $request->organization_id) {
                        $folderName = $folder['name'];
                        $folderPath = $folder['path'];
                        $organizationName = $order->organizationDetails->organization_name;
                        $display = 1;

                    } else {
                        $folderName = $folder['name'];
                        $folderPath = $folder['path'];
                        $organizationName = '';
                        $display = 0;
                    }

                } else {
                    $folderName = $folder['name'];
                    $folderPath = $folder['path'];
                    $organizationName = '';
                    $display = 1;
                }

                $dirArray = array(
                    'name' => $folderName,
                    'path' => $folderPath,
                    'organization' => $organizationName,
                    'display' => $display,
                );

                $folders[] = (object) $dirArray;
            }

        } else {
            $folders = null;
        }

        if(isset($folders)){
            $folderDir['folders'] = $folders;
        } else {
            $folderDir['folders'] = null;
        }

        return json_encode($folderDir);
    }

    public function omsFiles(Request $request) {
        $files = Storage::disk('google')->files($request->folderId);

        if($files){
            foreach($files as $file){
                $details = Storage::disk('google')->getMetadata($file);

                $url = Storage::disk('google')->url($file);

                if($details['extension'] == 'jpg' || $details['extension'] == 'png') {
                    $fileUrl = $url;
                } else {
                    $fileUrl = '';
                }

                $dataArray = array(
                    'name' => $details['name'],
                    'extension' => $details['extension'],
                    'url' => $fileUrl,
                    'timestamp' => $details['timestamp'],
                    'mimetype' => $details['mimetype'],
                    'size' => $details['size'],
                );

                $fileDatails[] = (object) $dataArray;
            }

        } else {
            $fileDatails = null;
        }

        if(isset($fileDatails)){
            $fileDatails = $fileDatails;
        } else {
            $fileDatails = null;
        }

        return json_encode($fileDatails);
    }

    public function checkContact($id){
        $contact = Contact::find($id);
        return json_encode($contact->organization_id);
    }

    public function updateSalesTaxes(){
        $organizations = Organization::with('userDetails')->where('sales_tax', NULL)->where('shipping_state','<>', NULL)->get();
        foreach($organizations as $organization){
            if($organization->shipping_state != "CA" || $organization->shipping_state != null || $organization->shipping_state != "California")
            {
                $organization = Organization::find($organization->id);
                $organization->sales_tax = 0;
                $organization->update();
            }

        }
        echo "Updated sales tax in Organizations where organization not in CA state";
    }
    public function Get_Payments_info(Request $request)
    {
        // Handle nullable start and end dates
        $startDate = $request->start_date ? \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d') : null;
        $endDate = $request->end_date ? \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d') : null;
        $filterColumn = $request->filterColumn;
        $organization_id = $request->organization_id;

        if ($filterColumn == 'all') {

            $query = Order::where('organization_id', $organization_id)->where('order_status_id', '!=', 7)
                      ->where('active', 1);

        }else{

            $query = Order::where('organization_id', $organization_id)->where('order_status_id', '!=', 7)
                    ->whereNotNull($filterColumn)
                    ->where('active', 1);

        }

        // Apply date filtering only if both dates are provided
        if ($startDate && $endDate) {
            $query->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') >= ?", [$startDate]);
        } elseif ($endDate) {
            $query->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') <= ?", [$endDate]);
        }

        $orders = $query->get();

         // Eager-load payments
        $orders = $query->get()->map(function ($order) {
            $order->payment_status = $this->PaymentService->getPaymentStatus($order->id);
            $order->payments = $this->get_order_payments($order->id); // Fetch payments
            return $order;
        });

        // Return JSON response
        return response()->json([
            'organization_id' => $organization_id,
            'orders' => $orders
        ]);
    }
    // public function Get_Payments_statement(Request $request)
    // {
    //     $startDate = $request->start_date ? \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d') : null;
    //     $endDate = $request->end_date ? \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d') : null;
    //     $organization_id = $request->organization_id;

    //     $query = AccountsLog::where('organization_id', $organization_id)->with(['order', 'user']);

    //     if ($startDate && $endDate) {
    //         $query->whereBetween('created_at', [$startDate, $endDate]);
    //     } elseif ($startDate) {
    //         $query->whereDate('created_at', '>=', $startDate);
    //     } elseif ($endDate) {
    //         $query->whereDate('created_at', '<=', $endDate);
    //     }

    //     $AccountLogs = $query->get();
    //     $debit_balance = Organization::where('id', $request->organization_id)->value('debit_balance');
    //     return response()->json([
    //         'organization_id' => $organization_id,
    //         'AccountLogs' => $AccountLogs,
    //         'debit_balance'=> $debit_balance
    //     ]);
    // public function Get_Payments_statement(Request $request)
    // {
    //     $startDate = $request->start_date ? \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d') : null;
    //     $endDate = $request->end_date ? \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d') : null;
    //     $organization_id = $request->organization_id;

    //     // Step 1: Get all order IDs for this organization
    //     $orders = Order::where('organization_id', $organization_id)
    //                 ->get(['id', 'order_no', 'order_total']);
    //     $orderIds = $orders->pluck('id', 'order_no');
    //     // Step 2: Fetch all payment transactions separately
    //     $payments = PaymentLog::whereIn('order_id', $orderIds)
    //         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
    //         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
    //         ->get();

    //     $checkPayments = CheckPayment::whereIn('order_id', $orderIds)
    //         ->where('is_approved', 1)
    //         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
    //         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
    //         ->get();

    //     $otherPayments = OtherPayment::whereIn('order_id', $orderIds)
    //         ->where('is_approved', 1)
    //         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
    //         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
    //         ->get();

    //     $paypalPayments = PaypalPayment::whereIn('order_id', $orderIds)
    //         ->where('is_approved', 1)
    //         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
    //         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
    //         ->get();

    //     $venmoPayments = VenmoPayment::whereIn('order_id', $orderIds)
    //         ->where('is_approved', 1)
    //         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
    //         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
    //         ->get();

    //     $accountsLogs = AccountsLog::where('organization_id', $organization_id)
    //         ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
    //         ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
    //         ->get();

    //     // Step 3: Combine all transactions into a single collection
    //     $allTransactions = collect()
    //         ->merge($payments)
    //         ->merge($checkPayments)
    //         ->merge($otherPayments)
    //         ->merge($paypalPayments)
    //         ->merge($venmoPayments)
    //         ->merge($accountsLogs);

    //     // Step 4: Format the transactions into the required statement structure
    //     $statements = $allTransactions->map(function ($transaction) use ($orderIds,$orders) {
    //         $transactionType = '-';
    //         if ($transaction instanceof VenmoPayment) {
    //             $transactionType = 'Venmo Payment';
    //         } elseif ($transaction instanceof PaypalPayment) {
    //             $transactionType = 'Paypal Payment';
    //         } elseif ($transaction instanceof OtherPayment) {
    //             $transactionType = 'Other Payment';
    //         } elseif ($transaction instanceof CheckPayment) {
    //             $transactionType = 'Check Payment';
    //         } elseif ($transaction instanceof PaymentLog) {
    //             $transactionType = 'Card Payment';
    //         } elseif ($transaction instanceof AccountsLog) {
    //             $transactionType = 'Debit Account';
    //         }
    //         // Find the order number by order_id
    //         $order = $orderIds->firstWhere('id', $transaction->order_id);
    //         $orderNumber = array_search($transaction->order_id, $orderIds->toArray()) ?: '-';
    //         $order = $orders->firstWhere('id', $transaction->order_id);
    //         $ordertotal = $order ? $order->order_total : '-';
    //         if( $ordertotal == $transaction->amount){
    //             $Order_balance = $ordertotal; // non paid
    //         }else{
    //             $paymentorder = $this->PaymentService->getPaymentStatus($transaction->order_id);
    //             $Order_balance =  $paymentorder['balance_to_be_paid'] ?? 0; // non paid
    //         }
    //         // Get the "Handled by" user based on the user_id
    //         $handledBy = $transaction->user_id ? User::find($transaction->user_id)->name : '-';

    //         // If it's an AccountsLog transaction, handle Amount, Paid, and Balance differently
    //         if ($transaction instanceof AccountsLog) {
    //             return [
    //                 'Transaction_Id' => $transaction->id,
    //                 'Order_no' => $orderNumber, // Show the order number
    //                 'Order_id' => $transaction->order_id, // Show the order id
    //                 'amount' => number_format($transaction->amount, 2),
    //                 'paid' => number_format($transaction->paid, 2),
    //                 'balance' => number_format($transaction->balance, 2),
    //                 'Type' => $transaction->type,
    //                 'Transaction_Type' => $transactionType,
    //                 'Handledby' => $handledBy,
    //                 'Note' => $transaction->note ?? '-',
    //                 'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
    //             ];
    //         }
    //        // For all other payment types, handle Amount, Paid, and Balance the same
    //         return [
    //             'Transaction_Id' => $transaction->id,
    //             'Order_no' => $orderNumber, // Show the order number
    //             'Order_id' => $transaction->order_id, // Show the order id
    //             'amount' => number_format($Order_balance, 2),
    //             'paid' => number_format($transaction->amount, 2),
    //             'balance' => '-',
    //             'Type' => 0, // Always 0 for other transactions
    //             'Transaction_Type' => $transactionType,
    //             'Handledby' => $handledBy,
    //             'Note' => $transaction->note ?? '-',
    //             'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
    //         ];
    //     });

    //     $statements = $statements->sortByDesc(fn ($transaction) => strtotime($transaction['created_at']))->values();

    //     $debit_balance = Organization::where('id', $organization_id)->value('debit_balance');
    //     // dd($statements);

    //     $totalBalanceToPay = 0;
    //     $p_orderIds = Order::where('organization_id', $organization_id)
    //     ->whereNotIn('order_status_id', [1, 7]) // Exclude statuses 1 and 7
    //     ->pluck('id');
    //     foreach ($p_orderIds as $orderId) {
    //         $payment = $this->PaymentService->getPaymentStatus($orderId);
    //         $totalBalanceToPay += $payment['balance_to_be_paid'] ?? 0; // Ensure it handles null values
    //     }
    //     return response()->json([
    //         'organization_id' => $organization_id,
    //         'statements' => $statements,
    //         'total_balance_to_pay' => number_format($totalBalanceToPay, 2),
    //         'debit_balance' => number_format($debit_balance, 2),
    //     ]);
    // }

//     public function Get_Payments_statement(Request $request)
//     {
//         $statementLayout = StatementLayout::firstOrCreate(
//             ['user_id' => Auth::id()],
//         );
//         $startDate = $request->start_date ? \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d') : null;
//         $endDate = $request->end_date ? \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d') : null;
//         $organization_id = $request->organization_id;

//         // Step 1: Get all order IDs for this organization
//         $orders = Order::where('organization_id', $organization_id) //SummaryAtPayment
//                     ->get(['id', 'order_no', 'order_total']);
//         $orderIds = $orders->pluck('id', 'order_no');

//         $payments = SummaryAtPayment::where('organization_id', $organization_id)
//             ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
//             ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
//             ->where('active',1)
//             ->get();
//         $accountsLogs = AccountsLog::where('organization_id', $organization_id)
//             ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
//             ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
//             ->get();
//      // Step 3: Combine all transactions into a single collection
//         $allTransactions = collect()
//             ->merge($payments)
//             ->merge($accountsLogs)
//             ->sortBy('created_at') // Sort by the 'created_at' date
//             ->values();
//         $debit_balance = Organization::where('id', $organization_id)->value('debit_balance');
//         $allBalance = 0.00;
//  // Step 4: Format the transactions into the required statement structure
//         $statements = $allTransactions->map(function ($transaction) use ($orderIds,$orders, $debit_balance,&$allBalance) {

//             // Find the order number by order_id
//             $order = $orderIds->firstWhere('id', $transaction->order_id) ?? null;
//             $orderNumber = array_search($transaction->order_id, $orderIds->toArray()) ?: '-';
//             $order = $orders->firstWhere('id', $transaction->order_id) ?? null;
//             // $ordertotal = $order ? $order->order_total : '-';
//             // if( $ordertotal == $transaction->amount){
//             //     $Order_balance = $ordertotal; // non paid
//             // }else{
//             //     $paymentorder = $this->PaymentService->getPaymentStatus($transaction->order_id);
//             //     $Order_balance =  $paymentorder['balance_to_be_paid'] ?? 0; // non paid
//             // }
//             // Get the "Handled by" user based on the user_id
//             // $handledBy = $transaction->user_id ? User::find($transaction->user_id)->name : '-';

//             // If it's an AccountsLog transaction, handle Amount, Paid, and Balance differently
//             $order_transaction_type = 'Debit Account';
//             $order_Payment_type = 'Bulk Payment';
//             if($transaction->order_id && $transaction->type == 0 && $transaction->note != 'Deducted from Debit'){
//                 $order_transaction_type = 'Invoice';
//                 $order_Payment_type = '-';

//             }
//             if ($transaction instanceof AccountsLog) {
//                 if($transaction->note  == 'Outstanding Invoice'){
//                     $allBalance += $transaction->amount;
//                 }
//                 return [
//                     'Transaction_Id' => $transaction->id,
//                     'Order_no' => $orderNumber, // Show the order number
//                     'Order_id' => $transaction->order_id ?? '-', // Show the order id
//                     'processingFee' =>number_format(0, 2),  // Show the order id
//                     'amount' => number_format($transaction->amount, 2),
//                     'paid' => number_format($transaction->paid, 2),
//                     'invoice_paid_amount' => number_format($transaction->paid, 2),
//                     'balance' => number_format($allBalance , 2),
//                     'Type' => $transaction->type,
//                     'Transaction_Type' => $order_transaction_type,
//                     'payment_Type' => $order_Payment_type,
//                     'Note' => $transaction->note ?? '-',
//                     'created_at' => $transaction->created_at->format('Y-m-d H:i:s.u'),
//                     'debitentry' =>number_format($transaction->balance, 2),
//                 ];
//             }
//            // For all other payment types, handle Amount, Paid, and Balance the same
//            if( $transaction->balancePayment == 0 || $transaction->balancePayment == null){
//                 $Order_balance = $transaction->orderTotal; // non paid
//             }else{
//                 $Order_balance =  $transaction->balancePayment; // non paid
//             }
//             $balancetopay = $Order_balance  - ($transaction->payedAmount - $transaction->processingFee);
//             $invoicepaidAmount = $transaction->payedAmount - $transaction->processingFee ;
//             if($transaction->method == 'Other'){
//                 $oldOrdertype = 'Bulk Payment';
//             }else{
//                 $oldOrdertype = 'Invoice Payment';
//             }
//             $allBalance -=  $invoicepaidAmount;
//             return [
//                 'Transaction_Id' => $transaction->id,
//                 'Order_no' => $orderNumber, // Show the order number
//                 'Order_id' => $transaction->order_id ?? '-', // Show the order id
//                 'processingFee' => number_format($transaction->processingFee, 2), // Show the order id
//                 'amount' => number_format(0, 2),
//                 'paid' => number_format($transaction->payedAmount, 2),
//                 'balance' => number_format($allBalance, 2),
//                 'invoice_paid_amount' => number_format($invoicepaidAmount, 2),
//                 'Type' => 0, // Always 0 for other transactions
//                 'Transaction_Type' => $transaction->method,
//                 'payment_Type' => $transaction->payment_type ?? $oldOrdertype,
//                 'Note' => $transaction->note ?? '-',
//                 'created_at' => $transaction->created_at->format('Y-m-d H:i:s.u'),
//                 'debitentry' =>0.00,
//             ];
//         });

//         $statements2 = $statements->sortBy(function ($transaction) {
//             return $transaction['created_at'];  // Directly using the Carbon instance for sorting
//         })->values();



//         // dd($statements);

//         $totalBalanceToPay = 0;

//         $p_orders = Order::where('organization_id', $organization_id)
//             ->whereNotIn('order_status_id', [7])
//             ->where('active', 1)
//             ->get(['id', 'order_status_id']); // Get full objects
//         foreach ($p_orders as $order) {
//             $payment = $this->PaymentService->getPaymentStatus($order->id);

//             if ($order->order_status_id == 1 && $payment['payment_status'] == 0) {
//                 continue;
//             }

//             $totalBalanceToPay += $payment['balance_to_be_paid'] ?? 0;
//         }

//         return response()->json([
//             'organization_id' => $organization_id,
//             'statements' => $statements2,
//             'total_balance_to_pay' => number_format($totalBalanceToPay, 2),
//             'debit_balance' => number_format($debit_balance, 2),
//             'statementLayout'=>$statementLayout,
//         ]);
//     }

    public function getStatementArray($request){


        $organization_id = $request->organization_id;

        $debit_balance = 0;

        $orders = Order::where('organization_id', $organization_id)
                    ->get(['id', 'order_no', 'order_total']);

        $orderIds = $orders->pluck('id', 'order_no');

        $bulkOrderEntries = BulkOrderEntry::where('organization_id', $organization_id)->get();

        $otherPayments = OtherPayment::whereIn('order_id', $orderIds)
        ->where('is_approved', 1)
        ->where('is_bulk', 0)
        ->get();

        $payments = PaymentLog::whereIn('order_id', $orderIds)->get();

        $checkPayments = CheckPayment::whereIn('order_id', $orderIds)
            ->where('is_approved', 1)->get();

        $paypalPayments = PaypalPayment::whereIn('order_id', $orderIds)
            ->where('is_approved', 1)->get();

        $venmoPayments = VenmoPayment::whereIn('order_id', $orderIds)
            ->where('is_approved', 1)->get();

        $accountsLogs = AccountsLog::where('organization_id', $organization_id)->where('active', 1)->get();

        $debitEntries = DebitEntry::where('organization_id', $organization_id)->get();


        $allTransactions = collect()
            ->merge($payments)
            ->merge($checkPayments)
            ->merge($otherPayments)
            ->merge($paypalPayments)
            ->merge($venmoPayments)
            ->merge($accountsLogs)
            ->merge($bulkOrderEntries)
            ->merge($debitEntries)
            ->sortBy('created_at')
            ->values();

        $allBalance = 0.00;

        $statements = $allTransactions->map(function ($transaction) use ($orderIds,$orders,&$allBalance,&$debit_balance) {

            $transactionType = '-';
            $OrderNumber = '-';
            $OrderId = '-';
            $order_Payment_type = 'Invoice Payment';
            $ProcessingFee = 0;
            $Amount = 0;
            $PaidAmount = $transaction->amount;
            $invoicepaidAmount = $transaction->amount;
            $debitentry = 0;
            $transactionNote = $transaction->note ?? '-';
            $isDebitEntry = false;

            if(isset($transaction->order_id)){
                $OrderId = $transaction->order_id;
                $orderTotal = Order::find($OrderId)->order_total ?? 0;
                $OrderNumber = Order::find($OrderId)->order_no ?? '-';
            }

            if ($transaction instanceof VenmoPayment) {
                $transactionType = 'Venmo';
                $entryRecord = DebitEntry::where('order_id', $OrderId)->where('transaction_type', 'VENMO')->where('transaction_id', $transaction->amount)->first();
                if($entryRecord){
                    $transaction->amount = $transaction->amount - $entryRecord->amount;
                }
                $allBalance -= $transaction->amount;
                // if($allBalance < 0){
                //     $allBalance = 0;
                // }
                $invoicepaidAmount = ($transaction->amount);

            } elseif ($transaction instanceof PaypalPayment) {
                $transactionType = 'Paypal';

                $entryRecord = DebitEntry::where('order_id', $OrderId)->where('transaction_type', 'PAYPAL')->where('transaction_id', $transaction->amount)->first();
                if($entryRecord){
                    $transaction->amount = $transaction->amount - ($entryRecord->amount * 103/100);
                }

                $ProcessingFee = ($transaction->amount) * 3 / 103;
                $allBalance -= ($transaction->amount - $ProcessingFee);
                // if($allBalance < 0){
                //     $allBalance = 0;
                // }
                $invoicepaidAmount = ($transaction->amount - $ProcessingFee);

            } elseif ($transaction instanceof OtherPayment) {
                $transactionType = 'Other';

                $entryRecord = DebitEntry::where('order_id', $OrderId)->where('transaction_type', 'OTHER')->where('transaction_id', $transaction->amount)->first();
                if($entryRecord){
                    $transaction->amount = $transaction->amount - $entryRecord->amount;
                }

                $allBalance -= $transaction->amount;
                // if($allBalance < 0){
                //     $allBalance = 0;
                // }
                $invoicepaidAmount = ($transaction->amount);
            } elseif ($transaction instanceof CheckPayment) {
                $transactionType = 'Check';

                $entryRecord = DebitEntry::where('order_id', $OrderId)->where('transaction_type', 'CHECK')->where('transaction_id', $transaction->amount)->first();
                if($entryRecord){
                    $transaction->amount = $transaction->amount - $entryRecord->amount;
                }

                $allBalance -= $transaction->amount;
                // if($allBalance < 0){
                //     $allBalance = 0;
                // }
                $invoicepaidAmount = ($transaction->amount);
            } elseif ($transaction instanceof PaymentLog) {
                $transactionType = 'Card';

                $entryRecord = DebitEntry::where('order_id', $OrderId)->where('transaction_type', 'CARD')->where('transaction_id', $transaction->amount)->first();
                if($entryRecord){
                    $transaction->amount = $transaction->amount - ($entryRecord->amount * 103/100);
                }

                $ProcessingFee = ($transaction->amount) * 3 / 103;
                $allBalance -= ($transaction->amount - $ProcessingFee);
                // if($allBalance < 0){
                //     $allBalance = 0;
                // }
                $invoicepaidAmount = ($transaction->amount - $ProcessingFee);

            } elseif ($transaction instanceof AccountsLog) {

                $transactionType = 'Debit Balance';
                $order_Payment_type = 'Bulk Payment';
                $PaidAmount = 0;
                $invoicepaidAmount = 0;
                $debitentry = $transaction->balance;

                if ($transaction->order_id && $transaction->note != 'Deducted from Debit') {
                    if($transaction->type == 0){
                        $transactionType = 'Invoice';
                        $order_Payment_type = '-';
                        $Amount = $transaction->amount;
                        $debitentry = 0;

                        $allBalance += $transaction->amount;
                        // if($allBalance < 0){
                        //     $allBalance = 0;
                        // }

                    }else{
                        $transactionType = 'Debit Account';
                        $order_Payment_type = '-';
                        $Amount = 0;
                        $debitentry = $transaction->balance;
                        $debit_balance += $transaction->balance;

                        $isDebitEntry = true;
                    }
                }


                if($transaction->note == 'Deducted from Debit'){
                    $debitentry = 0;
                    $invoicepaidAmount = $transaction->balance;
                    $debit_balance -= $transaction->balance;
                    $allBalance -= $transaction->balance;
                    // if($allBalance < 0){
                    //     $allBalance = 0;
                    // }
                    $transactionNote = 'Paid from Debit';
                }

                if ($transaction->order_id && $transaction->type == 0 && $transaction->note == 'Paid through OMG') {

                    $transactionType = 'online';
                    $order_Payment_type = 'OMG';
                    $allBalance -= $transaction->paid;
                    // if($allBalance < 0){
                    //     $allBalance = 0;
                    // }
                    $Amount = 0;
                    $PaidAmount = $transaction->paid;
                    $invoicepaidAmount = $transaction->paid;
                    $debitentry = 0;

                }

            }elseif ($transaction instanceof BulkOrderEntry) {

                $transactionType = 'Other';
                $order_Payment_type = 'Bulk Payment';
                $allBalance -= $transaction->amount;
                // if($allBalance < 0){
                //     $allBalance = 0;
                // }

            }elseif ($transaction instanceof DebitEntry) {

                $transactionType = 'Debit Account';
                $order_Payment_type = 'Invoice';
                $PaidAmount = 0;
                $invoicepaidAmount = 0;
                $debitentry = $transaction->amount;

                $debit_balance += $transaction->amount;

                $isDebitEntry = true;

            }

            return [
                'Transaction_Id' => $transaction->id,
                'Order_no' => $OrderNumber,
                'Order_id' => $OrderId,
                'processingFee' => number_format($ProcessingFee, 2),//
                'amount' => number_format($Amount, 2),//
                'paid' => number_format($PaidAmount, 2),//
                'balance' => number_format($allBalance, 2),//
                'invoice_paid_amount' => number_format($invoicepaidAmount, 2),
                'Type' => 0,//
                'Transaction_Type' => $transactionType,//
                'payment_Type' => $order_Payment_type,//
                'Note' => $transactionNote,//
                'created_at' => $transaction->created_at->format('Y-m-d H:i:s.u'),//
                'debitentry' => $debitentry,//
                'isDebitEntry' => $isDebitEntry,
            ];


        });

        $statementsWithoutDebit = $statements->filter(function ($statement) {
            return !$statement['isDebitEntry'];
        });


        $sumOfDebitEntries = $statements->where('isDebitEntry', true)->sum('debitentry');

        if ($sumOfDebitEntries > 0) {

                    $latestWithDebitTransaction = $statements
                        ->where('isDebitEntry', true)
                        ->sortByDesc('created_at')
                        ->first();
                    $latestWithDebitCreatedAt = $latestWithDebitTransaction['created_at'] ?? null;
                    $latestWithDebitBalance = $latestWithDebitTransaction['balance'] ?? 0;

                    $sumOfDebitEntrieRecord = [
                        'Transaction_Id' => '-',
                        'Order_no' => '-',
                        'Order_id' => '-',
                        'processingFee' => number_format(0, 2),
                        'amount' => number_format(0, 2),
                        'paid' => number_format(0, 2),
                        'balance' => $latestWithDebitBalance,
                        'invoice_paid_amount' => number_format(0, 2),
                        'Type' => 0,
                        'Transaction_Type' => 'Debit Account',
                        'payment_Type' => '-',
                        'Note' => 'Total Debits Related to Tax Clearance',
                        'created_at' => $latestWithDebitCreatedAt,
                        'debitentry' => number_format($sumOfDebitEntries, 2),
                        'isDebitEntry' => false,
                    ];

                    $statementsWithoutDebit = $statementsWithoutDebit->push($sumOfDebitEntrieRecord);
        }

        $statementsWithoutDebit = $statementsWithoutDebit->sortBy(function ($transaction) {
            return $transaction['created_at'];  // Directly using the Carbon instance for sorting
        })->values();

        $startDate = $request->start_date ? \Carbon\Carbon::createFromFormat('m/d/Y', $request->start_date)->startOfDay() : null;
        $endDate = $request->end_date ? \Carbon\Carbon::createFromFormat('m/d/Y', $request->end_date)->endOfDay() : null;

        if ($startDate && $endDate) {
            $statementsWithoutDebit = $statementsWithoutDebit->filter(function ($statement) use ($startDate, $endDate) {
                $createdAt = \Carbon\Carbon::parse($statement['created_at']);
                return $createdAt->between($startDate, $endDate);
            });
        }elseif ($startDate) {
            $statementsWithoutDebit = $statementsWithoutDebit->filter(function ($statement) use ($startDate) {
                $createdAt = \Carbon\Carbon::parse($statement['created_at']);
                return $createdAt->greaterThanOrEqualTo($startDate);
            });
        } elseif ($endDate) {
            $statementsWithoutDebit = $statementsWithoutDebit->filter(function ($statement) use ($endDate) {
                $createdAt = \Carbon\Carbon::parse($statement['created_at']);
                return $createdAt->lessThanOrEqualTo($endDate);
            });
        }

        if($startDate && $statementsWithoutDebit->isNotEmpty()){
            $filteredFirst = $statementsWithoutDebit->first();
            $filteredFirst['Note'] = 'Total Outstanding as at ' . $startDate->format('m/d/Y');
            $filteredFirst['created_at'] = $startDate->startOfDay()->format('Y-m-d H:i:s.u');
            $filteredFirst['Transaction_Id'] = '-';
            $filteredFirst['Order_no'] = '-';
            $filteredFirst['Order_id'] = '-';
            $filteredFirst['Transaction_Type'] = '-';
            $filteredFirst['payment_Type'] = '-';
            $filteredFirst['invoice_paid_amount'] = number_format(0, 2);
            $filteredFirst['paid'] = number_format(0, 2);
            $filteredFirst['debitentry'] = number_format(0, 2);
            if ($filteredFirst['amount'] != 0.00) {
                $filteredFirst['balance'] = floatval(str_replace(',', '', $filteredFirst['balance'])) - floatval(str_replace(',', '', $filteredFirst['amount']));
            } else {
                $filteredFirst['balance'] = floatval(str_replace(',', '', $filteredFirst['balance']));
            }
            $filteredFirst['amount'] = number_format(0, 2);
            $statementsWithoutDebit->put(0, $filteredFirst);
        }

        if ($endDate && $statementsWithoutDebit->isNotEmpty()) {
            $filteredLast = $statementsWithoutDebit->last();
            $allBalance = isset($filteredLast['balance']) ? floatval(str_replace(',', '', $filteredLast['balance'])) : 0;
        }

        $hide_debit_entries = $request->hide_debit_entries;
        if ($hide_debit_entries == 'true') {
            $statementsWithoutDebit = $statementsWithoutDebit->filter(function ($item) {
                return ($item['Transaction_Type'] !== 'Debit Account' && $item['Transaction_Type'] !== 'Debit Balance');
            })->values();
        }

        return [$statementsWithoutDebit, $debit_balance, $allBalance];

    }

    public function Get_Payments_statement(Request $request)
    {

        [$statementsWithoutDebit, $debit_balance, $allBalance] = $this->getStatementArray($request);

        $organization_id = $request->organization_id;

        $totalBalanceToPay = 0;

        $p_orders = Order::where('organization_id', $organization_id)
            ->whereNotIn('order_status_id', [7])
            ->where('active', 1)
            ->get(['id', 'order_status_id']);

        foreach ($p_orders as $order) {
            $payment = $this->PaymentService->getPaymentStatus($order->id);

            if ($order->order_status_id == 1 && $payment['payment_status'] == 0) {
                continue;
            }

            $totalBalanceToPay += $payment['balance_to_be_paid'] ?? 0;
        }

        return response()->json([
            'organization_id' => $organization_id,
            'statements' => $statementsWithoutDebit,
            'total_balance_to_pay' => number_format($allBalance, 2),
            'debit_balance' => number_format($debit_balance, 2),
        ]);
    }

    public function exportAccountStatment(Request $request)
    {
        $organization = Organization::find($request->organization_id);

        $organizationName = $organization
            ? $organization->organization_name
            : 'Organization';

        [$statements2, $debit_balance, $allBalance] = $this->getStatementArray($request);

        $statements2 = collect($statements2)
            ->sortBy(function ($item) {
                return isset($item['created_at']) ? $item['created_at'] : null;
            })
            ->values();

        $safeName = preg_replace('/[^A-Za-z0-9 _-]/', ' ', $organizationName);

        return Excel::download(
            new PaymentsStatementExport($statements2, $organizationName),
            $safeName . '_account_statement.xlsx'
        );
    }

    public function exportAccountStatmentPDF(Request $request){

        $organizationName = Organization::find($request->organization_id)->organization_name ?? 'Organization';

        $safeName = preg_replace('/[^A-Za-z0-9 _-]/', ' ', $organizationName);

        [$statements, $debit_balance, $allBalance] = $this->getStatementArray($request);

        $statements = collect($statements)->sortBy(function($item) {
            return $item['created_at'];
        })->values()->all();

        $startDate = $request->start_date ? \Carbon\Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d') : null;
        $endDate = $request->end_date ? \Carbon\Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d') : null;

        return view('pages.contacts.organizations.account_statement_pdf', compact('statements', 'organizationName', 'debit_balance', 'allBalance', 'startDate', 'endDate', 'safeName'))->render();

    }

    public function get_order_payments($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) return [];

        $payments = [];

        // Retrieve payments from different models
        $cardPayments = PaymentLog::where('order_id', $order->id)->get();
        $checkPayments = CheckPayment::where('order_id', $order->id)->where('is_approved', 1)->get();
        $paypalPayments = PaypalPayment::where('order_id', $order->id)->where('is_approved', 1)->get();
        $venmoPayments = VenmoPayment::where('order_id', $order->id)->where('is_approved', 1)->get();
        $otherPayments = OtherPayment::where('order_id', $order->id)->where('is_approved', 1)->get();

        // Helper function to map payments
        $mapPayments = function ($collection, $type, $receiptField = null, $receiptBackField = null) use (&$payments, $order) {
            foreach ($collection as $payment) {
                $paymentData = [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'payment_type' => $type,
                    'amount' => $payment->amount,
                    'date' => $payment->created_at,
                    'id' => $payment->id,
                ];

                if ($receiptField) {
                    $paymentData['receipt'] = $payment->$receiptField ?? null;
                }

                if ($receiptBackField) {
                    $paymentData['receiptBack'] = $payment->$receiptBackField ?? null;
                }

                $payments[] = $paymentData;
            }
        };

        // Map each payment type
        $mapPayments($cardPayments, 'Card');
        $mapPayments($otherPayments, 'Other', 'document_url', 'document_url_back');
        $mapPayments($checkPayments, 'Check', 'check_front', 'check_back');
        $mapPayments($paypalPayments, 'Paypal', 'paypal_receipt');
        $mapPayments($venmoPayments, 'Venmo', 'venmo_receipt');

        // Sort payments by date (newest first)
        usort($payments, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));

        return $payments;
    }


    public function get_order_invoice(Request $request){
        $id = $request->order_id;
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems','orderItems.productDetails', 'orderItems.statusDetails')
                            ->where('id', $id)
                            ->get();


        $paymentDetails = $this->PaymentService->getPaymentStatus($id);


        $balnceToBePaid = $paymentDetails['balance_to_be_paid'];
        $paymentStatus = $paymentDetails['payment_status'];
        $processingFee = $paymentDetails['processing_fee'];
        $orderTotal = $orders->sum('order_total');
        $totalPayment = $paymentDetails['total_payment'];

        // return json_encode($orders ,$processingFee);
        return view('pages.contacts.organizations.order_invoice', compact('orders', 'processingFee','balnceToBePaid','totalPayment','paymentStatus'))->render();
    }

    public function statementshowColumn(Request $request){
        $statementLayout = StatementLayout::where('user_id', Auth::user()->id)->first();

        if ($request->attribute_name == 'statement_date') {
            $statementLayout->date = 1;

        } else if ($request->attribute_name == 'statement_order_no') {
            $statementLayout->order_no = 1;

        } else if ($request->attribute_name == 'statement_payment_type') {
            $statementLayout->payment_type = 1;

        } else if ($request->attribute_name == 'statement_transaction_type') {
            $statementLayout->transaction_type = 1;

        } else if ($request->attribute_name == 'statement_note') {
            $statementLayout->note = 1;

        } else if ($request->attribute_name == 'statement_amount') {
            $statementLayout->amount = 1;

        } else if ($request->attribute_name == 'statement_payment') {
            $statementLayout->payment = 1;

        } else if ($request->attribute_name == 'statement_paid_processing_fee') {
            $statementLayout->paid_processing_fee = 1;

        } else if ($request->attribute_name == 'statement_total_paid_amount') {
            $statementLayout->total_paid_amount = 1;

        } else if ($request->attribute_name == 'statement_debit_entry') {
            $statementLayout->debit_entry = 1;

        } else if ($request->attribute_name == 'statement_balance') {
            $statementLayout->balance = 1;

        }
        $statementLayout->update();

        return json_encode('Activities Column Show!');
    }

    public function statementhideColumn(Request $request){
        $statementLayout = StatementLayout::where('user_id', Auth::user()->id)->first();

        if ($request->attribute_name == 'statement_date') {
            $statementLayout->date = 0;

        } else if ($request->attribute_name == 'statement_order_no') {
            $statementLayout->order_no = 0;

        } else if ($request->attribute_name == 'statement_payment_type') {
            $statementLayout->payment_type = 0;

        } else if ($request->attribute_name == 'statement_transaction_type') {
            $statementLayout->transaction_type = 0;

        } else if ($request->attribute_name == 'statement_note') {
            $statementLayout->note = 0;

        } else if ($request->attribute_name == 'statement_amount') {
            $statementLayout->amount = 0;

        } else if ($request->attribute_name == 'statement_payment') {
            $statementLayout->payment = 0;

        } else if ($request->attribute_name == 'statement_paid_processing_fee') {
            $statementLayout->paid_processing_fee = 0;

        } else if ($request->attribute_name == 'statement_total_paid_amount') {
            $statementLayout->total_paid_amount = 0;

        } else if ($request->attribute_name == 'statement_debit_entry') {
            $statementLayout->debit_entry = 0;

        } else if ($request->attribute_name == 'statement_balance') {
            $statementLayout->balance = 0;

        }
        $statementLayout->update();

        return json_encode('Activities Column Hide!');
    }







    // public function fill_orgId(){
    //     $payments = SummaryAtPayment::get();
    //     foreach ($payments as $payment) {
    //         if($payment->order_id){

    //             $Order = Order::where('id',$payment->order_id)->first();
    //             if($Order){

    //                 $payment->organization_id = $Order->organization_id;
    //                 $payment->save();
    //             }
    //         }
    //     }
    //     dd('done');
    // }


    public function unpaid_invoice_record(){

        $orders = order::where('active', 1)->whereNotIn('order_status_id', [7])->get();

        foreach ($orders as $key => $order) {

            $payment = $this->PaymentService->getPaymentStatus($order->id);
            if ($order->order_status_id == 1 && $payment['payment_status'] == 0) {
                dump($order->order_no.' - is inactive');
                AccountsLog::where('order_id', $order->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->delete();
                continue;
            }

            if (!AccountsLog::where('order_id', $order->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->exists() && !empty($order->order_total)) {

                $summaryAtPayment = SummaryAtPayment::where('order_id', $order->id)->orderBy('created_at', 'asc')->first();

                $logDate = now();

                if (!empty($order->production_date)) {

                    $CreditAccount = new AccountsLog();
                    $CreditAccount->organization_id = $order->organization_id;
                    $CreditAccount->amount = $order->order_total;
                    $CreditAccount->order_id = $order->id;
                    $CreditAccount->paid = 0;
                    $CreditAccount->balance = 0;
                    $CreditAccount->debit_balance = $order->order_total;
                    $CreditAccount->type = 0;
                    $CreditAccount->user_id = Auth::user()->id;
                    $CreditAccount->status = 1;
                    $CreditAccount->note = 'Outstanding Invoice';

                    $productionDate = \Carbon\Carbon::createFromFormat('m/d/Y', $order->production_date)->startOfDay();

                    if (!empty($summaryAtPayment)) {
                        if ($summaryAtPayment->created_at > $productionDate) {
                            $logDate = $productionDate->copy()->subMinutes(5);
                            $CreditAccount->created_at = $logDate;
                            $CreditAccount->updated_at = $logDate;
                            $CreditAccount->save();
                        } else {
                            $logDate = $summaryAtPayment->created_at->copy()->subMinutes(5);
                            $CreditAccount->created_at = $logDate;
                            $CreditAccount->updated_at = $logDate;
                            $CreditAccount->save();
                        }
                    } else {
                        $logDate = $productionDate->copy()->subMinutes(5);
                        $CreditAccount->created_at = $logDate;
                        $CreditAccount->updated_at = $logDate;
                        $CreditAccount->save();
                    }

                } else {

                    if (!empty($summaryAtPayment)) {
                        $CreditAccount = new AccountsLog();
                        $CreditAccount->organization_id = $order->organization_id;
                        $CreditAccount->amount = $order->order_total;
                        $CreditAccount->order_id = $order->id;
                        $CreditAccount->paid = 0;
                        $CreditAccount->balance = 0;
                        $CreditAccount->debit_balance = $order->order_total;
                        $CreditAccount->type = 0;
                        $CreditAccount->user_id = Auth::user()->id;
                        $CreditAccount->status = 1;
                        $CreditAccount->note = 'Outstanding Invoice';

                        $logDate = $summaryAtPayment->created_at->copy()->subMinutes(5);

                        $CreditAccount->created_at = $logDate;
                        $CreditAccount->updated_at = $logDate;
                        $CreditAccount->save();
                    }
                }

                dump($order->order_no.' - updated');

            }else{
                dump($order->order_no.' - no need to create record');
            }
        }

        dd('done');

    }
    // public function updateBulkPayments()
    // {
    //     $otherPayments = OtherPayment::whereNotNull('document_url')
    //         ->where('document_url', '!=', '')
    //         ->get()
    //         ->groupBy('document_url');

    //     foreach ($otherPayments as $otherPaymentGroup) {


    //         if ($otherPaymentGroup->count() > 1) {

    //             $filteredPayments = $otherPaymentGroup->filter(function ($payment) {
    //                 return !str_starts_with($payment->note, 'Deducted from Debit');
    //             });

    //             $sortedPayments = $filteredPayments->sortBy('created_at')->values();

    //             foreach ($sortedPayments as $payment) {
    //                 $payment->is_bulk = 1;
    //                 $payment->save();
    //             }

    //             $order = Order::find($sortedPayments[0]->order_id);

    //             $orderIDs = $sortedPayments->pluck('order_id')->toArray();
    //             $otherPaymentIDs = $sortedPayments->pluck('id')->toArray();

    //             $bulkOrderEntry = new BulkOrderEntry();
    //             $bulkOrderEntry->organization_id = $order->organization_id;
    //             $bulkOrderEntry->other_payment_ids = json_encode($otherPaymentIDs);
    //             $bulkOrderEntry->amount = $sortedPayments->sum('amount') ?? 0.00;
    //             $bulkOrderEntry->document_url = $sortedPayments[0]->document_url;
    //             $bulkOrderEntry->document_url_back = $sortedPayments[0]->document_url_back;
    //             $bulkOrderEntry->note = 'Applied for orders : ' . implode(', ', $orderIDs);
    //             $bulkOrderEntry->description = json_encode($orderIDs);
    //             $bulkOrderEntry->created_at = $sortedPayments[0]->created_at;
    //             $bulkOrderEntry->updated_at = $sortedPayments[0]->updated_at;
    //             $bulkOrderEntry->save();
    //         }
    //     }

    //     dd('end');
    // }

    public function updateTSRPayments(){

        $orders = Order::where('order_no', 'LIKE', 'TSR%')->where('active', 1)->get();

        // dd($orders);

        foreach ($orders as $key => $order) {

            $outstandingRecord = AccountsLog::where('order_id', $order->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->first();

            if ($outstandingRecord && !empty($order->order_total)) {

                    $CreditAccount = new AccountsLog();
                    $CreditAccount->organization_id = $order->organization_id;
                    $CreditAccount->amount = 0;
                    $CreditAccount->order_id = $order->id;
                    $CreditAccount->paid = $order->order_total;
                    $CreditAccount->balance = 0;
                    $CreditAccount->debit_balance = 0;
                    $CreditAccount->type = 0;
                    $CreditAccount->user_id = Auth::user()->id;
                    $CreditAccount->status = 1;
                    $CreditAccount->note = 'Paid through OMG';
                    $CreditAccount->created_at = $outstandingRecord->created_at->copy()->addMinutes(1);
                    $CreditAccount->save();

                dump($order->order_no.' - updated');

            }else{

                dump($order->order_no.' - no need to create record');

            }
        }
    }

    public function getSumOfPayments($orderId){

        $payment = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $paypalPayment = PaypalPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');
        $otherPayment = OtherPayment::where('order_id', $orderId)->where('is_approved', 1)->sum('amount');

        $sum = ($payment * 100/103) + $checkPayment + ($paypalPayment * 100/103) + $venmoPayment + $otherPayment;

        return $sum;

    }

    public function updateDebitEntry(){

        dump('working........');

        $payments = PaymentLog::get();

        $checkPayments = CheckPayment::where('is_approved', 1)->get();

        $paypalPayments = PaypalPayment::where('is_approved', 1)->get();

        $venmoPayments = VenmoPayment::where('is_approved', 1)->get();

        $otherPayments = OtherPayment::get();

        foreach ($payments as $payment) {
            $order = Order::find($payment->order_id);
            $sumOfPayments = $this->getSumOfPayments($payment->order_id);

            if ($order && round($sumOfPayments - $order->order_total, 2) > 0 && DebitEntry::where('order_id', $order->id)->where('note', 'like', 'Exess From%')->doesntExist()) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $order->organization_id;
                $debitEntry->order_id = $order->id;
                $debitEntry->transaction_id = $payment->id;
                $debitEntry->transaction_type = 'CARD';
                $debitEntry->amount = $sumOfPayments - $order->order_total;
                $debitEntry->note = 'Exess From CARD'.$payment->id.' (#'.$order->order_no.')';
                $debitEntry->created_at = $payment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

        }
        foreach ($paypalPayments as $payment) {
            $order = Order::find($payment->order_id);
            $sumOfPayments = $this->getSumOfPayments($payment->order_id);

            if ($order && round($sumOfPayments - $order->order_total, 2) > 0 && DebitEntry::where('order_id', $order->id)->where('note', 'like', 'Exess From%')->doesntExist()) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $order->organization_id;
                $debitEntry->order_id = $order->id;
                $debitEntry->transaction_id = $payment->id;
                $debitEntry->transaction_type = 'PAYPAL';
                $debitEntry->document_url_front = $payment->paypal_receipt;
                $debitEntry->amount = $sumOfPayments - $order->order_total;
                $debitEntry->note = 'Exess From PAYPAL'.$payment->id.' (#'.$order->order_no.')';
                $debitEntry->created_at = $payment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

        }
        foreach ($checkPayments as $payment) {
            $order = Order::find($payment->order_id);
            $sumOfPayments = $this->getSumOfPayments($payment->order_id);

            if ($order && round($sumOfPayments - $order->order_total, 2) > 0 && DebitEntry::where('order_id', $order->id)->where('note', 'like', 'Exess From%')->doesntExist()) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $order->organization_id;
                $debitEntry->order_id = $order->id;
                $debitEntry->transaction_id = $payment->id;
                $debitEntry->transaction_type = 'CHECK';
                $debitEntry->document_url_front = $payment->check_front;
                $debitEntry->document_url_back = $payment->check_back;
                $debitEntry->amount = $sumOfPayments - $order->order_total;
                $debitEntry->note = 'Exess From CHQ'.$payment->id.' (#'.$order->order_no.')';
                $debitEntry->created_at = $payment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

        }
        foreach ($venmoPayments as $payment) {
            $order = Order::find($payment->order_id);
            $sumOfPayments = $this->getSumOfPayments($payment->order_id);

            if ($order && round($sumOfPayments - $order->order_total, 2) > 0 && DebitEntry::where('order_id', $order->id)->where('note', 'like', 'Exess From%')->doesntExist()) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $order->organization_id;
                $debitEntry->order_id = $order->id;
                $debitEntry->transaction_id = $payment->id;
                $debitEntry->transaction_type = 'VENMO';
                $debitEntry->document_url_front = $payment->venmo_receipt;
                $debitEntry->amount = $sumOfPayments - $order->order_total;
                $debitEntry->note = 'Exess From VNM'.$payment->id.' (#'.$order->order_no.')';
                $debitEntry->created_at = $payment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

        }

        foreach ($otherPayments as $payment) {
            $order = Order::find($payment->order_id);
            $sumOfPayments = $this->getSumOfPayments($payment->order_id);

            if ($order && round($sumOfPayments - $order->order_total, 2) > 0 && DebitEntry::where('order_id', $order->id)->where('note', 'like', 'Exess From%')->doesntExist()) {
                $debitEntry = new DebitEntry();
                $debitEntry->organization_id = $order->organization_id;
                $debitEntry->order_id = $order->id;
                $debitEntry->transaction_id = $payment->id;
                $debitEntry->transaction_type = 'OTHER';
                $debitEntry->document_url_front = $payment->document_url;
                $debitEntry->document_url_back = $payment->document_url_back;
                $debitEntry->amount = $sumOfPayments - $order->order_total;
                $debitEntry->note = 'Exess From OTHER'.$payment->id.' (#'.$order->order_no.')';
                $debitEntry->created_at = $payment->created_at->copy()->addMinutes(1);
                $debitEntry->save();
            }

        }

        dd('done');

    }
    public function getOutstandingInvoiceDates(){

        $orders = Order::where('active', 1)->get();

        $missingProductionDates = [];

        foreach ($orders as $key => $order) {

            $outstandingRecord = AccountsLog::where('order_id', $order->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->first();

            if ($outstandingRecord && !empty($order->production_date)) {

                $outstandingRecordCreatedAt = $outstandingRecord->created_at->startOfDay();
                $orderProductionDate = \Carbon\Carbon::createFromFormat('m/d/Y', $order->production_date)->startOfDay();

                if($outstandingRecordCreatedAt > $orderProductionDate){

                    $outstandingRecord->created_at = $orderProductionDate->copy();
                    $outstandingRecord->save();

                    $missingProductionDates[] = [
                        'order_no' => $order->order_no,
                        'order_id' => $order->id,
                        'production_date' => $orderProductionDate->format('Y-m-d H:i:s'),
                        'outstanding_record_created_at' => $outstandingRecordCreatedAt->format('Y-m-d H:i:s'),
                    ];

                }

            }
        }

        dd($missingProductionDates);
    }
}






