<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Nivel_servicio.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:00:55pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Nivel_servicio extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'nivel_servicios';

	public function user(){
        return $this->belongsTo(User::class);
    }
}
