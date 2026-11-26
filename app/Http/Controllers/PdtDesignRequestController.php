<?php
namespace App\Http\Controllers;

use App\Models\PdtDesignRequest;
use App\Models\PdtDesignRequestItem;
use App\Models\PdtProduct;
use App\Models\PdtRequestTemplate;
use App\Services\PdtDesignRequestNotifier;
use App\Support\PdtDesignRequestAccess as Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PdtDesignRequestController extends Controller
{
    public function index(Request $http)
    {
        abort_unless(Access::view($http->user()),403);
        $manager=Access::manage($http->user());$canCreate=Access::create($http->user());
        $query=PdtDesignRequest::with('requester','organization','items.product.product','items.designs')->latest();
        if(!$manager)$query->where('requested_by',$http->user()->id);
        if(in_array($http->status,['pending','in_progress','completed']))$query->where('status',$http->status);
        if($http->filled('search'))$query->where('title','like','%'.substr($http->search,0,150).'%');
        $requests=$query->paginate(15)->withQueryString();
        $products=$canCreate ? PdtProduct::with('product')->where('active',1)->get()->sortBy(function($p){return $p->product->product_name ?? '';}) : collect();
        $organizations=$canCreate ? \App\Models\Organization::orderBy('organization_name')->get(['id','organization_name']) : collect();
        return view('pages.pdt-design-requests.index',compact('requests','products','manager','canCreate','organizations'));
    }
    public function store(Request $http,PdtDesignRequestNotifier $notifier)
    {
        abort_unless(Access::create($http->user()),403);
        $data=$http->validate(['organization_id'=>'nullable|integer|exists:organizations,id','title'=>'required|string|max:180','brief'=>'nullable|string|max:10000','products'=>'required|array|min:1|max:50','products.*'=>['required','integer','distinct',Rule::exists('pdt_products','id')->where('active',1)]]);
        $request=DB::transaction(function()use($data,$http){
            $request=PdtDesignRequest::create(['organization_id'=>$data['organization_id'] ?? null,'title'=>$data['title'],'brief'=>$data['brief'] ?? null,'requested_by'=>$http->user()->id,'status'=>'pending']);
            foreach($data['products'] as $id)$request->items()->create(['pdt_product_id'=>$id]);
            return $request;
        });
        $request->load('requester','items.product.product');
        $notice=$notifier->created($request);
        $message='Design request created.';
        if(!$notice['notified'])$message.=' Request notification is not configured; check System Configuration > Notifications.';
        if(!$notice['email_sent'])$message.=' Designer email was not sent; check the PDT request email template and recipients.';
        return redirect()->route('pdt.design-requests.show',$request)->with('status',$message);
    }
    public function show(Request $http,PdtDesignRequest $designRequest)
    {
        abort_unless(Access::request($http->user(),$designRequest),403);
        $designRequest->load('organization','requester','items.product.product','items.designs');
        $manager=Access::manage($http->user());
        return view('pages.pdt-design-requests.show',compact('designRequest','manager'));
    }
    public function workspace(Request $http,PdtDesignRequest $designRequest)
    {
        abort_unless(Access::request($http->user(),$designRequest),403);
        $token=bin2hex(random_bytes(32));
        DB::table('pdt_workspace_links')->insert(['request_id'=>$designRequest->id,'issued_by'=>$http->user()->id,'token_hash'=>hash('sha256',$token),'expires_at'=>now()->addDays(30),'created_at'=>now(),'updated_at'=>now()]);
        return redirect()->away(rtrim(config('pdt.public_url'),'/').'/concept-request/'.$designRequest->id.'?access='.$token);
    }
    public function designs(Request $http,PdtDesignRequest $designRequest,PdtDesignRequestItem $item)
    {
        abort_unless(Access::manage($http->user()) && Access::action($http->user(),'add') && $item->request_id===$designRequest->id,403);
        $query=PdtRequestTemplate::where('pdt_product_id',$item->pdt_product_id)->where('is_admin_created',1)->latest('id');
        if($http->filled('search'))$query->where('name','like','%'.substr($http->search,0,150).'%');
        $page=$query->paginate(12)->withQueryString();
        $selected=$item->designs()->wherePivot('design_status','ready')->pluck('templates.id')->all();
        return response()->json(['designs'=>$page->getCollection()->map(function($t)use($selected){return ['id'=>$t->id,'name'=>$t->name,'preview_url'=>$t->preview_url,'design_url'=>$t->design_url,'selected'=>in_array($t->id,$selected)];}),'next'=>$page->nextPageUrl()]);
    }
    public function addDesigns(Request $http,PdtDesignRequest $designRequest,PdtDesignRequestItem $item)
    {
        abort_unless(Access::manage($http->user()) && Access::action($http->user(),'add') && $item->request_id===$designRequest->id,403);
        $data=$http->validate(['templates'=>'required|array|min:1|max:100','templates.*'=>'required|integer|distinct']);
        DB::transaction(function()use($http,$data,$designRequest,$item){
            $locked=PdtDesignRequest::whereKey($designRequest->id)->lockForUpdate()->firstOrFail();
            abort_if($locked->status==='completed',409,'Reopen this request before changing its designs.');
            $ids=PdtRequestTemplate::whereIn('id',$data['templates'])->where('pdt_product_id',$item->pdt_product_id)->where('is_admin_created',1)->pluck('id');
            if($ids->count()!==count($data['templates']))throw ValidationException::withMessages(['templates'=>'Choose published designs belonging to this product only.']);
            $links=[];foreach($ids as $id)$links[$id]=['added_by'=>$http->user()->id,'design_status'=>'ready'];
            $item->designs()->syncWithoutDetaching($links);
            if($locked->status==='pending')$locked->update(['status'=>'in_progress']);
        });
        return response()->json(['success'=>true]);
    }
    public function removeDesign(Request $http,PdtDesignRequest $designRequest,PdtDesignRequestItem $item,$template)
    {
        abort_unless(Access::manage($http->user()) && Access::action($http->user(),'remove') && $item->request_id===$designRequest->id,403);
        DB::transaction(function()use($designRequest,$item,$template){
            $locked=PdtDesignRequest::whereKey($designRequest->id)->lockForUpdate()->firstOrFail();
            abort_if($locked->status==='completed',409,'Reopen this request before changing its designs.');
            $item->designs()->detach($template);
        });
        return back()->with('status','Design removed.');
    }
    public function redesign(Request $http,PdtDesignRequest $designRequest,PdtDesignRequestItem $item,$template)
    {
        abort_unless(Access::request($http->user(),$designRequest) && Access::action($http->user(),'redesign') && $item->request_id===$designRequest->id,403);
        DB::transaction(function()use($designRequest,$item,$template){
            $locked=PdtDesignRequest::whereKey($designRequest->id)->lockForUpdate()->firstOrFail();
            abort_unless($item->designs()->where('templates.id',$template)->exists(),404);
            $item->designs()->updateExistingPivot($template,['design_status'=>'needs_redesign']);
            $locked->update(['status'=>'in_progress','completed_by'=>null,'completed_at'=>null]);
        });
        return back()->with('status','Design marked as needs redesign.');
    }
    public function status(Request $http,PdtDesignRequest $designRequest,PdtDesignRequestNotifier $notifier)
    {
        abort_unless(Access::manage($http->user()),403);
        $data=$http->validate(['status'=>['required',Rule::in(['pending','in_progress','completed'])]]);
        abort_unless(Access::action($http->user(),$data['status']==='completed'?'complete':($designRequest->status==='completed'?'reopen':'start')),403);
        $completed=false;
        DB::transaction(function()use($designRequest,$data,$http,&$completed){
            $request=PdtDesignRequest::whereKey($designRequest->id)->lockForUpdate()->firstOrFail();
            if($data['status']==='completed' && (!$request->items()->exists() || $request->items()->doesntHave('designs')->exists() || DB::table('pdt_design_request_templates')->whereIn('request_item_id',$request->items()->select('id'))->where('design_status','needs_redesign')->exists()))throw ValidationException::withMessages(['status'=>'Add at least one design to every requested product before completing.']);
            $completed=$request->status!=='completed' && $data['status']==='completed';
            $request->update(['status'=>$data['status'],'completed_by'=>$data['status']==='completed'?$http->user()->id:null,'completed_at'=>$data['status']==='completed'?now():null]);
        });
        if($completed)$notifier->completed($designRequest);
        return back()->with('status','Request status updated.');
    }
}
