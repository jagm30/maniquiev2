<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobrocancelado extends Model
{
     protected $fillable = ['id','id_cuenta_asignacion','motivo','id_cobro'];
}
