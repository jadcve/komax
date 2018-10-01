<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

/**
 * Class Bodega.
 *
 * @author  The scaffold-interface created at 2018-08-22 05:20:21pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Bodega extends Model
{
    
    protected $fillable = ['cod_bodega', 'bodega', 'agrupacion1', 'comuna', 'ciudad', 'region', 'latitude', 'longitud', 'direccion', 'user_id'];
    
    protected $table = 'bodegas';

	public function user(){
        return $this->belongsTo(User::class);
    }

    public function calendarios(){
        return $this->hasMany(Calendario::class);
    }

    public function trans(){
        return $this->hasMany('App\Tran', 'bodega', 'bodega');
    }

	/**
     * marca.
     *
     * @return  \Illuminate\Support\Collection;
     */
    public function marcas()
    {
        return $this->belongsToMany('App\Marca');
    }

    /**
     * Assign a marca.
     *
     * @param  $marca
     * @return  mixed
     */
    public function assignMarca($marca)
    {
        return $this->marcas()->attach($marca);
    }
    /**
     * Remove a marca.
     *
     * @param  $marca
     * @return  mixed
     */
    public function removeMarca($marca)
    {
        return $this->marcas()->detach($marca);
    }

}
