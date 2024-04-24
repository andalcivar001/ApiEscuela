<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    public function index()
    {
        $curso = Course::all();
        $data = ['curso' => $curso];
        return response()->json($curso, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'horario' => 'required|max:255',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'tipo' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $curso =  Course::create([
            'nombre' => $request->nombre,
            'horario' => $request->horario,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'tipo' => $request->tipo,
        ]);

        if (!$curso) {
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'curso' => $curso,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

    public function show($id)
    {
        $curso = Course::find($id);

        if (!$curso) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $cursoArray = [
            'curso' => $curso,
            'status' => 200
        ];

        return response()->json($curso, 200);
    }

    public function destroy($id)
    {
        $curso = Course::find($id);

        if (!$curso) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($curso, 404);
        }
        
        $curso->delete();

        $data = [
            'message' => 'Estudiante eliminado',
            'curso' => $curso,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $curso = Course::find($id);

        if (!$curso) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($curso, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'horario' => 'required|max:255',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'tipo' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $curso->nombre = $request->nombre;
        $curso->horario = $request->horario;
        $curso->fecha_inicio = $request->fecha_inicio;
        $curso->fecha_fin = $request->fecha_fin;
        $curso->tipo = $request->tipo;

        $curso->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'curso' => $curso,
            'status' => 200
        ];

        return response()->json($data, 200);

    }
}
