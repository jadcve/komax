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
     * bodega.
     *
     * @return  \Illuminate\Support\Collection;
     */
    public function bodegas()
    {
        return $this->belongsToMany('App\Bodega');
    }

    /**
     * Assign a bodega.
     *
     * @param  $bodega
     * @return  mixed
     */
    public function assignBodega($bodega)
    {
        return $this->bodegas()->attach($bodega);
    }
    /**
     * Remove a bodega.
     *
     * @param  $bodega
     * @return  mixed
     */
    public function removeBodega($bodega)
    {
        return $this->bodegas()->detach($bodega);
    }

}
