<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;

Route::get('/contacto', [ContactoController::class,'getContactos'])->name('get_contactos');
Route::get('/contacto/{id_contacto}', [ContactoController::class, 'getContactoById'])->name('get_contacto_id');
Route::post('/contacto', [ContactoController::class, 'crearContacto'])->name('crear_contacto');
Route::patch('/contacto/{id_contacto}', [ContactoController::class, 'editarContacto'])->name('editar_contacto');
Route::delete('/contacto/{id_contacto}', [ContactoController::class, 'eliminarContacto'])->name('eliminar_contacto');