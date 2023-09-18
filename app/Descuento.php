<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    //
    protected $fillable = ['id_cuentaasignada','id_alumno','fecha_descuento','id_ciclo_escolar','cantidad','observaciones','status','id_usuario'];
}
