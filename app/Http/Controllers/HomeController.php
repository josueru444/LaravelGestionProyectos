<?php

namespace App\Http\Controllers;

use App\Models\ProfesorGrupoModel;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function mostrarGrupos()
    {

        $idUsuario=Auth::user()->id;

        $grupos = ProfesorGrupoModel::join('grupo','grupo.uuid','=','grupo_profesor.id_grupo')
        ->where('grupo_profesor.id_profesor',$idUsuario)->get();

        return view('home.home',['grupos'=>$grupos]);
    }
}
