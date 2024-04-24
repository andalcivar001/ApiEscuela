<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;

class AdminstradorController extends Controller
{
      public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'correo' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $teacher =  Teacher::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'password' => $request->password,
        ]);

        if (!$teacher) {
            $data = [
                'message' => 'Error al crear el administrador/profesor',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'administrador' => $teacher,
            'status' => 201
        ];

        return response()->json($teacher, 201);

    }

    public function show($correo,$pasword)
    {
        $teacher = Teacher::where('correo', $correo)
                            ->where('password', $pasword)
                            ->get();

        if (!$teacher) {
            $data = [
                'message' => 'Administrador no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $cursoArray = [
            'curso' => $teacher,
            'status' => 200
        ];

        return response()->json($teacher, 200);
    }
}
