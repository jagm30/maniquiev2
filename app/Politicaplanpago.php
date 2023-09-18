<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Politicaplanpago extends Model
{
    //
    protected $fillable = ['id','id_ciclo_escolar','id_plan_pago','dias_limite_pronto_pago','cant_porc_descuento','valor_descuento','cant_porc_recargo','valor_recargo','status',];
}
