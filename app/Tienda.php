<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

/**
 * Class Tienda.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:20:21pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Tienda extends Model
{
	
	
    protected $table = 'tiendas';

	public function user(){
        return $this->belongsTo(User::class);
    }

    public function calendarios(){
        return $this->hasMany(Calendario::class);
    }
}
