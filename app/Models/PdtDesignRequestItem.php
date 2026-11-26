<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PdtDesignRequestItem extends Model
{
    protected $guarded=['id'];
    protected $casts=['request_id'=>'integer','pdt_product_id'=>'integer'];
    public function designRequest(){return $this->belongsTo(PdtDesignRequest::class,'request_id');}
    public function product(){return $this->belongsTo(PdtProduct::class,'pdt_product_id');}
    public function designs(){return $this->belongsToMany(PdtRequestTemplate::class,'pdt_design_request_templates','request_item_id','template_id')->withPivot('added_by','design_status')->withTimestamps();}
}
