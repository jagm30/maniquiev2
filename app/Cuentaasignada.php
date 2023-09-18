<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentaasignada extends Model
{
    protected $fillable = ['id_alumno','id_plan_pago','id_plan_concepto_cobro','id_ciclo_escolar','status'];
}
