<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporal extends Model
{
    public function trans()
    {
        return $this->belongsTo('App\Tran');
    }
}
