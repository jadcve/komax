<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Proveedor.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:19:09pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Proveedor extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'proveedors';

	
}
