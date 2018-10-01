<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    // protected $primaryKey = 'bodega';


    public function scopeAgrupacion1($query, $agrupacion1)
    {
        if(trim($agrupacion1 != "")){
            $query->where(\DB::raw('agrupacion1', $agrupacion1), "like","%$agrupacion1%");
        }
    }

    public function scopeMarca($query, $marca)
    {
        if(trim($marca != "")){
            $query->where(\DB::raw('agrupacion1', $marca), "like","%$marca%");
        }
    }

    public function temporal()
    {
        return $this->hasOne('App\Temporal');
    }

    public function bodegas(){
        return $this->belongsTo('App\Bodega', 'bodega', 'bodega');
    }
}
