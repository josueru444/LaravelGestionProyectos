<?php

use App\Http\Controllers\ControllerPDF;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\MicrosoftAuthController;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\HomeController;
use Google\Service\Adsense\Row;
use Illuminate\Support\Facades\Route;



Route::get('/', [MicrosoftAuthController::class, 'signInForm'])->name('login');
// Route::get('microsoft-oAuth',[MicrosoftAuthController::class,'microsoftOAuth'])->name('microsoft.oAuth');
// Route::get('callback',[MicrosoftAuthController::class,'microsoftOAuthCallback'])->name('microsoft.oAuth.callback');

Route::get('/login-microsoft', [MicrosoftAuthController::class, 'redirectToProvider'])->name('microsoft.login');
Route::get('/callback', [MicrosoftAuthController::class, 'handleProviderCallback']);




Route::get('grupos/', [HomeController::class, 'mostrarGrupos'])->name('home')->middleware('auth');
Route::post('grupos/', [ControllerPDF::class, 'processPdf'])->middleware('auth');
Route::get('instrumentacion/', function () {
    return view('home.formatos.instrumentacion');
})->name('instrumentacion')->middleware('auth');



Route::get('grupo/{id}', [GrupoController::class, 'cargarGrupo'])->name('grupo')->middleware('auth');
Route::post('/obtener-alumnos/', [AlumnosController::class, 'cargarLista'])->middleware('auth');
Route::post('registrar-calificacion', [CalificacionController::class, 'cargarCalificacion'])->middleware('auth');

Route::post('/registrar-alumno-individual', [AlumnosController::class, 'registrarAlumnoIndividual'])->middleware('auth');
Route::post('modificar-alumno', [AlumnosController::class, 'modificarAlumno'])->middleware('auth');
Route::post('eliminar-alumno', [AlumnosController::class, 'eliminarAlumnoGrupo'])->middleware('auth');

Route::get('recordatorios/{id}')->middleware('auth');

// Route::get('descargar-docx/',[DocumentoController::class,'generateAndDownload']);
Route::post('descargar-docx/', [DocumentoController::class, 'generateAndDownload'])->middleware('auth');

Route::get('logout', [MicrosoftAuthController::class, 'logout'])->name('logout')->middleware('auth');
