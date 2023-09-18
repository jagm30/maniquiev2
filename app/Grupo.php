<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Cicloescolar;
use App\Nivelescolar;

class Grupo extends Model
{
    //
    protected $fillable = ['id','id_ciclo_escolar','cupo_maximo','turno','id_nivel_escolar','grado_semestre','diferenciador_grupo','status'];

    public function cicloescolars()
    {
        return $this->belongsToMany('App\Cicloescolar');
    }
    public function nivelescolars()
    {
        return $this->belongsToMany('App\Nivelescolar');
    }

}
