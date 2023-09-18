<?php

namespace App;
use App\Cicloescolar;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    //
    protected $fillable = ["apaterno","amaterno","nombres","genero","fecha_nac","lugar_nac","edo_civil","curp","domicilio","ciudad","estado","email","telefono","cp","telefono2","foto","status"];

    public function Cicloescolars()
    {
        return $this->belongsToMany('App\Cicloescolar');
    }
}
