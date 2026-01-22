<?php

namespace App\Http\Controllers;

use App\Models\AlumnoGrupoModel;
use App\Models\AlumnosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class AlumnosController extends Controller
{

    public function cargarLista(Request $request)
    {
        $file = $request->file('lista_csv');
        $idGrupo=$request->input('id-grupo-alumno-modal');

        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0);

        $headers = $csv->getHeader();

        $records = $csv->getRecords();


        foreach ($records as $record) {

            if ($record['NC'] != '') {
                $alumnoss = AlumnosModel::updateOrCreate(
                    ['nc' => $record['NC']
                ],
                    [
                        'nc' => $record['NC'],
                        'ap' => $record['AP'],
                        'am' => $record['AM'],
                        'nombres' => $record['Nombres']

                    ]
                );
                $grupoAlumno = AlumnoGrupoModel::updateOrCreate(
                    ['nc_alumno' => $record['NC'],
                    'id_grupo'=>$idGrupo
                ],
                    ['nc_alumno'=>$record['NC'],
                    'id_grupo'=>$idGrupo,
                    'status'=>1
                    ]
                );
            }
        }

        return redirect()->to(url()->previous() . '?tab=2')->with('success', 'Archivo CSV procesado correctamente.');

    }

    public function registrarAlumnoIndividual(Request $request)
    {
        try {
            $idGrupo=$request->input('idGrupo');
            $nc=$request->input('nc');
            $ap=$request->input('ap');
            $am=$request->input('am');
            $nombres=$request->input('nombre');

            $alumnoss = AlumnosModel::updateOrCreate(
                ['nc' => $nc],
                [
                    'nc' => $nc,
                    'ap' => $ap,
                    'am' => $am,
                    'nombres' => $nombres
                ]
            );
            $grupoAlumno = AlumnoGrupoModel::updateOrCreate(
                ['nc_alumno'=>$nc,
                'id_grupo'=>$idGrupo
            ],
                ['nc_alumno'=>$nc,
                'id_grupo'=>$idGrupo,
                'status'=>1
                ]
            );

            return response()->json(['status' => 'ok']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>'ok']);
        }
    }

    public function modificarAlumno(Request $request){

        $nc=$request->nc;
        $ap=$request->ap;
        $am=$request->am;
        $nombre=$request->nombre;

        try {
            AlumnosModel::where('nc',$nc)->update(['ap'=>$ap,'am'=>$am,'nombres'=>$nombre]);
            return response()->json(['status'=>'ok']);
        } catch (\Error $e) {
            return response()->json(['error'=>$e]);
        }

    }

    public function eliminarAlumnoGrupo(Request $request){
        $grupo=$request->input('idGrupo');
        $nc=$request->input('nc');
        try{
            AlumnoGrupoModel::where('id_grupo',$grupo)->where('nc_alumno',$nc)->update(['status'=>0]);

            return response()->json(['status'=>'ok']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e]);
        }


    }
}
