<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupoalumno extends Model
{
    //
    protected $fillable = ['id','id_alumno','id_grupo','status','id_ciclo_escolar'];
}
