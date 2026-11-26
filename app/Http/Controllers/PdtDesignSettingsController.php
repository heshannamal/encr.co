<?php
namespace App\Http\Controllers;
use App\Models\PdtProduct;
use App\Models\PdtRequestTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class PdtDesignSettingsController extends Controller{
 public function index(Request $http,$product=null){
  abort_unless(Gate::check('view pdt design settings'),403);
  $products=PdtProduct::with('product')->addSelect(['design_count'=>PdtRequestTemplate::selectRaw('count(*)')->whereColumn('pdt_product_id','pdt_products.id')])->get()->sortBy(fn($p)=>$p->product->product_name ?? '');
  $selected=$product?PdtProduct::with('product')->findOrFail($product):null;
  $designs=null;
  if($selected){$query=PdtRequestTemplate::where('pdt_product_id',$selected->id)->latest('id');
   if($http->status==='deleted')$query->onlyTrashed();
   elseif($http->status==='hidden')$query->where('show_in_product',0);
   elseif($http->status==='visible')$query->where('show_in_product',1)->where('is_admin_created',1);
   if($http->filled('search'))$query->where('name','like','%'.substr($http->search,0,150).'%');
   $designs=$query->paginate(20)->withQueryString();
  }
  return view('pages.pdt-design-settings.index',compact('products','selected','designs'));
 }
 public function update(Request $http,$template){abort_unless(Gate::check('edit pdt design settings'),403);$data=$http->validate(['show_in_product'=>'required|boolean']);$design=PdtRequestTemplate::findOrFail($template);$design->update($data);return back()->with('status','Design visibility updated.');}
 public function destroy($template){abort_unless(Gate::check('delete pdt designs'),403);PdtRequestTemplate::findOrFail($template)->delete();return back()->with('status','Design moved to deleted designs.');}
 public function restore($template){abort_unless(Gate::check('restore pdt designs'),403);PdtRequestTemplate::onlyTrashed()->findOrFail($template)->restore();return back()->with('status','Design restored.');}
}
