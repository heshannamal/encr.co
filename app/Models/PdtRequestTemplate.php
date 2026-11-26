<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PdtRequestTemplate extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table='templates';
    protected $guarded=['id'];
    public function getPreviewUrlAttribute()
    {
        if(!$this->preview_image)return asset('assets/images/no-template.jpg');
        if(preg_match('~^https?://~i',$this->preview_image) || preg_match('~^data:image/(png|jpeg|webp);base64,~i',$this->preview_image))return $this->preview_image;
        return rtrim(config('pdt.public_url'),'/').'/template/preview/'.$this->id;
    }
    public function getDesignUrlAttribute(){return rtrim(config('pdt.public_url'),'/').'/customize/'.$this->pdt_product_id.'?template='.$this->id;}
}
