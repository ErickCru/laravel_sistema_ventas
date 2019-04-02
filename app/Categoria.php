<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /*Laravel asume que la table sera categorias.
    protected $table = 'categorias';*/
    /*Eloquent lo asume tambien
    protected $primaryKey = 'id';*/
    //Permite asignar los valores en masa
    protected $fillable = ['nombre', 'descripcion', 'condicion'];

    public function articulos(){
        return $this->hasMany('App\Articulo');
    }
}
