<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseStudent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CourseStudentController extends Controller
{
    public function show($id)
    {
        //$data = DB::select('CALL sp_cursos_estudiantes(?)', array($id));

        $data = DB::table('courses as c')
    ->leftJoin('course_student as cs', function ($join) use ($id) {
        $join->on('c.id', '=', 'cs.course_id')
             ->where('cs.student_id', '=', $id);
    })
    ->select(
        'c.id',
        'c.nombre',
        'c.horario',
        'c.tipo',
        'c.fecha_inicio',
        'c.fecha_fin',
        DB::raw("CASE WHEN cs.id > 0 THEN 'S' ELSE 'N' END AS checkbox")
    )
    ->distinct()
    ->get();

      
        return response()->json($data, 200);
    }

  public function update(Request $request, $id)
{
    // Validar los datos recibidos en la solicitud
    $request->validate([
        '*.id' => 'required',
    ]);

    // Eliminar las relaciones CourseStudent existentes para el estudiante actual
    CourseStudent::where('student_id', $id)->delete();

    // Crear nuevas relaciones CourseStudent
    $courseStudentsCreados = [];
    foreach ($request->all() as $courseStudentData) {
        $courseStudent = CourseStudent::create([
            'course_id' => $courseStudentData['id'],
            'student_id' => $id,
        ]);
        $courseStudentsCreados[] = $courseStudent;
    }

    // Devolver una respuesta JSON con el resultado de la operación
    $data = [
        'message' => 'Relaciones CourseStudent actualizadas con éxito',
        'status' => 200,
        'courseStudents' => $courseStudentsCreados,
    ];

    return response()->json($request->all(), 200);
}
}
