<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto;
use Illuminate\Support\Facades\Validator;

class ContactoController extends Controller
{
    public function getContactos(){
        $contactos = Contacto::all();
        return response()->json($contactos, 200);
    }

    public function getContactoById(int $id_contacto){
        try {
            $contacto = Contacto::findOrFail($id_contacto);
            return response()->json($contacto,200);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'error',
                'errors'=>'El contacto no existe'
            ], 404);
        }
    }

    public function crearContacto(){
        $validator = Validator::make(
            request()->all(),
            [
                'nombre'=>'required|string|max:250',
                'telefono'=>'required|integer|max_digits:150',
                'fecha_nacimiento'=>'required|date'
            ]
        );

        if($validator->fails()){
            return response()->json([
                'message'=>'error',
                'errors'=>$validator->errors()],
                400);
        };

        $contacto = Contacto::create(request()->all());
        if(!$contacto){
            return response()->json([
                'message'=>'error',
                'errors'=>'error al crear el contacto'
            ], 400);
        }else{
            return response()->json([
                'message'=>'success',
                'result'=>$contacto
            ],200);
        };
    }

    public function editarContacto(int $id_contacto){
        $validator = Validator::make(
            request()->all(),
            [
                'nombre'=>'required|string|max:250',
                'telefono'=>'required|integer|max_digits:150',
                'fecha_nacimiento'=>'required|date'
            ]
        );

        if($validator->fails()){
            return response()->json([
                'message'=>'error',
                'errors'=>$validator->errors()
            ],400);
        };

        try {
            $contacto = Contacto::findOrFail($id_contacto);
            $contacto->nombre = request()->nombre;
            $contacto->telefono = request()->telefono;
            $contacto->fecha_nacimiento = request()->fecha_nacimiento;
            $contacto->save();
            return response()->json([
                'message'=>'success',
                'result'=>$contacto
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'error',
                'errors'=>'el contacto no existe'
            ], 404);
        }
    }

    public function eliminarContacto(int $id_contacto){
        try {
            $contacto = Contacto::findOrFail($id_contacto);
            $contacto->delete();
            return response()->json([
                'message'=>'success',
                'result'=>'contacto eliminado'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'error',
                'errors'=>'el contacto no existe'
            ], 404);
        }
    }
}
