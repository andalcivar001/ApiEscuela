<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'horario',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
        // Agrega aquí otras columnas que desees permitir
    ];

      public function students()
    {
        return $this->belongsToMany('App/Models/Student') ;
    }

}
