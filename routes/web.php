<?php

use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('bem-vindo');
});;

Auth::routes(['verify' => true]);

Route::get('/tarefa/exportacao/{extensao}', [TarefaController::class, 'exportacao'])->name('tarefa.exportacao');
Route::get('/tarefa/exportar', [TarefaController::class, 'exportar'])->name('tarefa.exportar');
Route::middleware(['verified'])->group(function (){
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('tarefa', TarefaController::class);
});

Route::get('/mensagem-teste', function () {
    return new MensagemTesteMail();
//    Mail::to('abrahao.martins@wedev.software')->send(new MensagemTesteMail());
//    return 'E-mail enviado com sucesso';
});
