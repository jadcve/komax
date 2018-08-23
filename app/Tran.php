<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tran.
 *
 * @author  The scaffold-interface created at 2018-08-23 04:31:37pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Tran extends Model
{
	
	
    public $timestamps = false;
    
    protected $table = 'trans';

	
}
