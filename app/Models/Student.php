<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido',
        'edad',
        'cedula',
        'correo',
        // Agrega aquí otras columnas que desees permitir
    ];
   
    public function courses()
    {
        return $this->belongsToMany('App/Models/Course') ;
    }
}


