<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planpagoconcepto extends Model
{
    //
    protected $fillable = ['id','id_plan_pago','id_concepto_cobro','anio_corresponde','mes_pagar','no_parcialidad','periodo_inicio','periodo_vencimiento','cantidad','status','id_ciclo_escolar'];
}
