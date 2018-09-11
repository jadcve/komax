<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Marca.
 *
 * @author  The scaffold-interface created at 2018-09-04 02:54:33pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Marca extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'marcas';

	

	/**
     * tienda.
     *
     * @return  \Illuminate\Support\Collection;
     */
    public function tiendas()
    {
        return $this->belongsToMany('App\Tienda');
    }

    /**
     * Assign a tienda.
     *
     * @param  $tienda
     * @return  mixed
     */
    public function assignTienda($tienda)
    {
        return $this->tiendas()->attach($tienda);
    }
    /**
     * Remove a tienda.
     *
     * @param  $tienda
     * @return  mixed
     */
    public function removeTienda($tienda)
    {
        return $this->tiendas()->detach($tienda);
    }

}
