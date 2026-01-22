<?php

namespace App\Http\Controllers;

use App\Models\AlumnoGrupoModel;
use App\Models\CalificacionGrupoModel;
use App\Models\ProfesorGrupoModel;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function cargarGrupo($id)
    {
        $InfoGrupo = ProfesorGrupoModel::where('id_grupo', $id)->first();
        $unidades = $InfoGrupo->num_unidades;

        $calificaciones = CalificacionGrupoModel::where('id_grupo', $InfoGrupo->id_grupo)->get();

        if (count($calificaciones) === 0) {
            for ($i = 1; $i <= $unidades; $i++) {
                $crearRegistrosVacios = new CalificacionGrupoModel();
                $crearRegistrosVacios->unidad = $i;
                $crearRegistrosVacios->data = json_encode([
                    [
                        "NC" => "",
                        "Nombre Completo" => "",
                        "Act1" => "",
                        "Act2" => "",
                        "Act3" => "",
                        "Ev Practica" => "",
                        "Ev Teorica" => "",
                        "Valor de actividades" => "",
                        "V. Ev Practica" => "",
                        "V. Ev  Teorica" => "",
                        "Calificacion_Final" => ""
                    ]
                ]);
                $crearRegistrosVacios->id_grupo = $InfoGrupo->id_grupo;
                $crearRegistrosVacios->save();
            }

            $calificaciones = CalificacionGrupoModel::where('id_grupo', $InfoGrupo->id_grupo)->get();
        }
        $alumnos = AlumnoGrupoModel::join('_alumnos', 'grupo_alumno.nc_alumno', '=', '_alumnos.nc')
            ->select('_alumnos.nc', '_alumnos.ap', '_alumnos.am', '_alumnos.nombres')
            ->where('grupo_alumno.id_grupo', '=', $InfoGrupo->id_grupo)
            ->where('grupo_alumno.status','=',1)
            ->orderBy('_alumnos.ap', 'asc')
            ->get();



        return view('grupos.grupoBase', ['unidades' => $unidades, 'grupo' => $InfoGrupo->id_grupo, 'calificaciones' => $calificaciones,'alumnos'=>$alumnos]);
    }
}
