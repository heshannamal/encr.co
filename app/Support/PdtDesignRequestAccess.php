<?php
namespace App\Support;
use Illuminate\Support\Facades\Gate;
class PdtDesignRequestAccess
{
    public static function manage($user){return $user && Gate::forUser($user)->check('manage pdt design requests');}
    public static function create($user){return $user && Gate::forUser($user)->check('create pdt design requests');}
    public static function view($user){return $user && Gate::forUser($user)->check('view pdt design requests');}
    public static function action($user,$action){return $user && Gate::forUser($user)->check($action.' pdt request designs');}
    public static function request($user,$request){return self::view($user) && (self::manage($user) || (int)$request->requested_by===(int)$user->id);}
}
