<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class Proveedor.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:19:09pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Proveedor extends Model
{
    
	// use SoftDeletes;

	// protected $dates = ['deleted_at'];
    
    protected $fillable = ['codigo_proveedor', 'descripcion_proveedor', 'lead_time_proveedor', 'tiempo_entrega_proveedor', 'user_id'];
	
    protected $table = 'proveedors';
    
    public function __construct() {
        $user = Auth::user();
        $prefix = ($user->empresa == '') ? '' : $user->empresa.'_';

        $this->table = $prefix.'proveedors';
    }

	public function user(){
        return $this->belongsTo(User::class);
    }
}
