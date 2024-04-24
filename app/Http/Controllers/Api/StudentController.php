<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        $data = [
            'estudiante' => $students,
            'status' => 200
        ];

        return response()->json( $students, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'edad' => 'required|max:255',
            'cedula' => 'required',
            'correo' => 'required|email|unique:students'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student =  Student::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'edad' => $request->edad,
            'cedula' => $request->cedula,
            'correo' => $request->correo,
        ]);

        if (!$student) {
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'estudiante' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $dataArray = [
            'estudiante' => $student,
            'status' => 200
        ];

        return response()->json($student, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado',
            'estudiante' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'edad' => 'required|max:255',
            'cedula' => 'required',
            'correo' => 'required|email'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->nombre = $request->nombre;
        $student->apellido = $request->apellido;
        $student->edad = $request->edad;
        $student->cedula = $request->cedula;
        $student->correo = $request->correo;

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'estudiante' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);

    }


}
