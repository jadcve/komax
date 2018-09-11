<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Semana.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:02:13pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Semana extends Model
{
	
	
    public $timestamps = false;
    
    protected $table = 'semanas';

	public function calendarios(){
        return $this->hasMany('App\Calendario');
    }
}
