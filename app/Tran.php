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


    public function scopeCanal($query, $canal)
    {
        if(trim($canal != "")){
            $query->where(\DB::raw('canal', $canal), "like","%$canal%");
        }
    }

    public function scopeMarca($query, $marca)
    {
        if(trim($marca != "")){
            $query->where(\DB::raw('canal', $marca), "like","%$marca%");
        }
    }

    public function temporal()
    {
        return $this->hasOne('App\Temporal');
    }

    public function tiendas(){
        return $this->belongsTo('App\Tienda', 'bodega', 'bodega');
    }
}
