<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giro extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'id', 'nombre'
    ];

    public function contribuyentes(){
        $this->hasMany(Contribuyente::class);
    }
}
