<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'idcliente',
        'idusuario',
        'tipo_documento',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado'
    ];
}
