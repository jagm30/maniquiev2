<?php

namespace App;
use App\Grupo;
use Illuminate\Database\Eloquent\Model;

class Cicloescolar extends Model
{
    //
    protected $fillable = ['id','anio_inicio','anio_fin','periodo','descripcion','denominacion','fecha_inicio','fecha_fin','status',];

    public function grupos()
    {
        return $this->belongsToMany('App\Grupo');
    }
}
