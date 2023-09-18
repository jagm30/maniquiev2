<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
     protected $fillable = ['id_alumno','id_user','id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','tipo_pago','status','cantidad','forma_pago'];
}
