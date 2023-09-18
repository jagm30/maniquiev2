<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobroparcial extends Model
{
    //
    protected $fillable = ['id_alumno','id_user','id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','cantidad_abonada','status','forma_pago'];

}
