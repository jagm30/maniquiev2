<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planpago extends Model
{
    //
    protected $fillable = ['codigo','descripcion','periocidad','status'];
}
