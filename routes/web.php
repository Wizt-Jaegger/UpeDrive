<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

route ::get('/',[HomeController::class,'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

route ::get('/redirect',[HomeController::class,'redirect']);
route ::get('/view_category',[AdminController::class,'view_category']);
route ::post('/add_category',[AdminController::class,'add_category']);
route ::get('/delete_category/{id}',[AdminController::class,'delete_category']);
route ::get('/view_producto',[AdminController::class,'view_producto']);
route ::post('/add_producto',[AdminController::class,'add_producto']);
route ::get('/show_autos',[AdminController::class,'show_autos']);
route ::get('/delete_producto/{id}',[AdminController::class,'delete_producto']);
route ::get('/update_producto/{id}',[AdminController::class,'update_producto']);
route ::post('/edit_producto/{id}',[AdminController::class,'edit_producto']);
route ::get('/producto_detalles/{id}',[HomeController::class,'producto_detalles']);
route ::post('/add_cart/{id}',[HomeController::class,'add_cart']);
route ::get('/show_cart',[HomeController::class,'show_cart']);
route ::get('/remove_cart/{id}',[HomeController::class,'remove_cart']);
route ::get('/agendar_cita',[HomeController::class,'agendar_cita']);
Route::get('/horas-disponibles', [HomeController::class, 'horasDisponibles']);
route::get('/citas',[HomeController::class,'citas']);
Route::delete('cancelar-cita/{fecha}/{hora}', [HomeController::class, 'cancelarCita']);
Route::get('/admin_citas', [AdminController::class, 'admin_citas']);
Route::delete('/admin-cancelar-cita/{fecha}/{hora}', [AdminController::class, 'admin_cancelar_cita']);