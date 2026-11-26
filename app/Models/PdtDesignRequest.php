<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PdtDesignRequest extends Model
{
    public function organization(){return $this->belongsTo(\App\Models\Organization::class,'organization_id');}
    protected $guarded=['id'];
    protected $casts=['completed_at'=>'datetime'];
    public function requester(){return $this->belongsTo(User::class,'requested_by');}
    public function items(){return $this->hasMany(PdtDesignRequestItem::class,'request_id');}
}
