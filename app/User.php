<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Bodega;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

     protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bodegas(){
        return $this->hasMany(Bodega::class, 'users_id');
    }
    
    public function nivel_servicios(){
        return $this->hasMany(Nivel_servicio::class);
    }

    public function calendarios(){
        return $this->hasMany(Calendario::class);
    }

    public function proveedors(){
        return $this->hasMany(Proveedor::class);
    }
}
