<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Calendario.
 *
 * @author  The scaffold-interface created at 2018-08-22 06:06:23pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Calendario extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'calendarios';

	public function user(){
        return $this->belongsTo(User::class);
    }

    public function tienda(){
        return $this->belongsTo(Tienda::class);
    }

    public function semana() {
        return $this->BelongsTo('App\Semana');
    }
}
