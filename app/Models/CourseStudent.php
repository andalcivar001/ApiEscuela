<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class CourseStudent extends Model
{
    protected $table = 'course_student';
    use HasFactory;
    protected $fillable = [
        'course_id',
        'student_id',
        // Agrega aquí otras columnas que desees permitir
    ];

      public function students()
    {
        return $this->belongsToMany('App/Models/CourseStudent') ;
    }

}
