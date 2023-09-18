<?php

namespace App;
use App\Cicloescolar;
use App\Grupo;
use Illuminate\Database\Eloquent\Model;

class Nivelescolar extends Model
{
    protected $fillable = ['clave_identificador','acuerdo_incorporacion','fecha_incorporacion','zona_escolar','denominacion_grado'];

    public function cicloescolars()
    {
        return $this->belongsToMany('App\Cicloescolar');
    }
    public function grupos()
    {
        return $this->belongsToMany('App\Grupo');
    }
}
