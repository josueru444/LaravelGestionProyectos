<?php

namespace App\Http\Controllers;

use App\Models\CalificacionGrupoModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Illuminate\Http\Request;
use League\Csv\Reader;

class CalificacionController extends Controller
{
    public function cargarCalificacion(Request $request)
    {
        $file = $request->file('calificaciones_csv');
        $unidad = $request->input('unidadInputModal'); 
        $grupoID = $request->input('grupoID');


        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0);
        $headers = $csv->getHeader();

        $records = $csv->getRecords();
        $data = [];
        foreach ($records as $record) {
            $row = [];
            foreach ($headers as $header) {
                if ($record[$header] != '') {
                    $row[$header] = $record[$header];
                }
            }
            $data[] = $row;
        }
        $jsonData = json_encode($data);

        try {

            CalificacionGrupoModel::where('unidad', '=', $unidad)->where('id_grupo', '=', $grupoID)->update(['data' => $jsonData]);

            return back();
        } catch (\Error $e) {
            dd($e);
        }
    }
}
