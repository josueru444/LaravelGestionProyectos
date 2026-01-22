<?php

namespace App\Http\Controllers;

use App\Models\GrupoModel;
use App\Models\ProfesorGrupoModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Style\Table as TableStyle;

use function PHPSTORM_META\type;

class DocumentoController extends Controller
{

    public function generateAndDownload(Request $request)
    {
        $meses = ([
            "01" => "Enero",
            "02" => "Febrero",
            "03" => "Marzo",
            "04" => "Abril",
            "05" => "Mayo",
            "06" => "Junio",
            "07" => "Julio",
            "08" => "Agosto",
            "09" => "Septiembre",
            "10" => "Ocutbre",
            "11" => "Noviembre",
            "12" => "Diciembre",
        ]);
        $dias = ([
            "1" => "LU",
            "2" => "MA",
            "3" => "MI",
            "4" => "JU",
            "5" => "VI",

        ]);

        $inicioCurso = $request->input("inicio_curso");
        $finCurso = $request->input("fin_curso");
        $asignatura = $request->input("asignatura_input");
        $claveMateria = $request->input("cve_input");
        $carrera = $request->input("carrera_input");
        $departamento = $request->input("departamento_input");
        $creditos = $request->input("creditos_input");
        $planEstudios = $request->input("planEstudios_input");
        $profesor = $request->input("profesor_input");
        $grupo = $request->input("grupo_input");
        $aula = $request->input("aula_input");

        $horarioDia1 = $request->input('dia1-horario');
        $horaDia1 = $request->input('hora-input1');

        $horarioDia2 = $request->input('dia2-horario');
        $horaDia2 = $request->input('hora-input2');

        $horarioDia3 = $request->input('dia3-horario');
        $horaDia3 = $request->input('hora-input3');



        $horario = '';
        if ($horarioDia3 == '1') {
            if ($horaDia1 == $horaDia2) {
                $horario = $dias[$horarioDia1] . '-' . $dias[$horarioDia2] . ' (' . $horaDia1 . ')';
            } else {
                $horario = $dias[$horarioDia1] . ' (' . $horaDia1 . ')' . ' - ' . $dias[$horarioDia2] . ' (' . $horaDia2 . ')';
            }
        } else {

            $horario =  $dias[$horarioDia1] . '-' . $dias[$horarioDia2] . ' (' . $horaDia1 . ')  /' . $dias[$horarioDia3] . ' (' . $horaDia3 . ')';
        }




        $inicioMes = explode("-", $inicioCurso);
        $inicioMes2 = $meses[$inicioMes[1]];
        $finMes = explode("-", $finCurso);
        $anio = $finMes[0];
        $finMes = $meses[$finMes[1]];

        $periodo = $inicioMes2 . '-' . $finMes . '-' . $anio;

        //Temario
        $objetivoGral = $request->input('objetivo_gral');
        $competenciaEspecifica = $request->input("comptencia");
        $temas = $request->input("tema");
        $subtemas = $request->input("subtemas");
        $subtemaSeparado = [];
        $index = 0;


        $descripcion = $request->input('descripcion-area');
        $resultados = $request->input('resultado-area');
        $pArea = $request->input('p-area');
        $rArea = $request->input('r-area');

        foreach ($subtemas as $subtema) {
            $partes = explode('@', $subtema);
            $numero = $partes[0];
            $texto = $partes[1];

            if (!isset($subtemaSeparado[$numero])) {
                $subtemaSeparado[$numero] = [];
            }
            $subtemaSeparado[$numero][] = $texto;
        }

        $tr1 = $request->input('tr1');
        $tr2 = $request->input('tr2');
        $tr3 = $request->input('tr3');
        $tr4 = $request->input('tr4');
        $tr5 = $request->input('tr5');
        $tr6 = $request->input('tr6');



        $tr1Dividido = array_chunk($tr1, 9);
        $tr2Dividido = array_chunk($tr2, 9);
        $tr3Dividido = array_chunk($tr3, 9);
        $tr4Dividido = array_chunk($tr4, 9);
        $tr5Dividido = array_chunk($tr5, 9);
        $tr6Dividido = array_chunk($tr6, 9);

        $allChunks = [
            $tr1Dividido,
            $tr2Dividido,
            $tr3Dividido,
            $tr4Dividido,
            $tr5Dividido,
            $tr6Dividido
        ];
        $fechasInput = $request->input('inputFechas');
        $arrayFechas = explode(',', $fechasInput);

        $semanas = $request->input('inputSemanas');
        $arraySemanas = explode(',', $semanas);

        $observaciones = $request->input('observaciones-calendarizacion');
        $jefeAcademico = $request->input('jefeAcademico');


        $templatePath = storage_path('app/public/plantilla.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        //funcion datos generales
        $escribirDatosGral = $this->escribirDatosGenerales($templateProcessor, $periodo, $asignatura, $departamento, $claveMateria, $carrera, $creditos, $planEstudios, $profesor, $grupo, $aula, $horario, $jefeAcademico);
        // tabla de temario

        $dibujarTemario = $this->dibujarTemario($templateProcessor, $objetivoGral, $temas, $subtemaSeparado, $descripcion, $pArea, $resultados, $rArea);
        // tabla de evidencias

        $tablaEvidencias = $this->dibujarTablasEvidencias($templateProcessor, $allChunks);

        //Tabla de evaluacion en semanas-------

        $this->dibujarTablaSemanas($templateProcessor, $arraySemanas,  $arrayFechas, $observaciones);

        // Guardar el documento como archivo DOCX
        $fileName = 'updatedDocument.docx';
        $tempFilePath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($tempFilePath);



        try {
            $userId = Auth::user();

            $user = User::where('email', $userId->email)->get();

            $uuidGRp = Str::uuid();
            $grupoModel = new GrupoModel();
            $grupoModel->uuid = $uuidGRp;
            $grupoModel->nombre = $grupo . ' - ' . $asignatura;
            $grupoModel->clave = $claveMateria;
            $grupoModel->creditos = $creditos;
            $grupoModel->save();

            $ultimoGrupo = GrupoModel::latest()->first();


            $uuid2 = Str::uuid();

            $GrupoProfesor = new ProfesorGrupoModel();
            $GrupoProfesor->uuid = $uuid2;
            $GrupoProfesor->id_profesor = $userId->id;
            $GrupoProfesor->id_grupo = ($ultimoGrupo->uuid);
            $GrupoProfesor->num_unidades = count($temas);
            $GrupoProfesor->save();



            return response()->download($tempFilePath)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            dd(['Error' => $e]);
        }

        // Descargar el archivo y eliminarlo después

    }

    // Insertar datos generales al documento/////////////////////////////////////////////////////////////
    public function escribirDatosGenerales($templateProcessor, $periodo, $asignatura, $departamento, $claveMateria, $carrera, $creditos, $planEstudios, $profesor, $grupo, $aula, $horario, $jefeAcademico)
    {
        $templateProcessor->setValue('periodo', $periodo);
        $templateProcessor->setValue('asignatura', $asignatura);
        $templateProcessor->setValue('depto', $departamento);
        $templateProcessor->setValue('clave', $claveMateria);
        $templateProcessor->setValue('carrera', $carrera);
        $templateProcessor->setValue('creditos', $creditos);
        $templateProcessor->setValue('plan', $planEstudios);
        $templateProcessor->setValue('profesor', $profesor);
        $templateProcessor->setValue('grupo', $grupo);
        $templateProcessor->setValue('aula', $aula);
        $templateProcessor->setValue('horario', $horario);
        $templateProcessor->setValue('nombreJEFE', $jefeAcademico);
    }

    // Dibujar la tabla del temario///////////////////////////////////////////////////////
    public function dibujarTemario($templateProcessor, $objetivoGral, $temas, $subtemaSeparado, $descripcion, $pArea, $resultados, $rArea)
    {
        // Crear la tabla
        $fancyTableStyle = [
            'borderSize'  => 6,
            'borderColor' => '000000',
            'cellMargin'  => 40,
            'alignment'   => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
        ];


        $table = new Table($fancyTableStyle);

        //Estilos
        $myFontStyle = array('bold' => true, 'align' => 'center');
        $myFontStyle2 = array('bold' => false, 'align' => 'center', 'size' => 9);

        $cellRowSpan = array('vMerge' => 'restart');



        $table->addRow();
        $cell = $table->addCell(2937, [
            'borderSize' => 6,
            'borderColor' => '000000',
            'gridSpan' => 5
        ]);

        $textRun = $cell->addTextRun();
        $textRun->addText('Objetivo General del Curso: ', ['bold' => true]);
        $textRun->addText($objetivoGral);


        $table->addRow();
        $table->addCell(2937, ['align' => 'center',  'borderSize' => 6, 'borderColor' => '000000'])->addText(htmlspecialchars("Competencia específica a desarrollar de cada tema"), $myFontStyle, array('align' => 'center'));
        $table->addCell(2088, ['align' => 'center',  'borderSize' => 6, 'borderColor' => '000000'])->addText(htmlspecialchars("Temas"), $myFontStyle, array('align' => 'center'));
        $table->addCell(3859, ['align' => 'center',  'borderSize' => 6, 'borderColor' => '000000'])->addText(htmlspecialchars("Subtemas"), $myFontStyle, array('align' => 'center'));
        $table->addCell(2966, ['align' => 'center',  'borderSize' => 6, 'borderColor' => '000000'])->addText(htmlspecialchars("Práctica"), $myFontStyle, array('align' => 'center'));
        $table->addCell(1814, ['align' => 'center',  'borderSize' => 6, 'borderColor' => '000000'])->addText(htmlspecialchars("Hrs. Teórico – Prácticas"), $myFontStyle, array('align' => 'center'));


        //Dibuujar renglones
        foreach ($temas as $unidad => $tema) {
            $table->addRow(700);
            $table->addCell(1000, ['vMerge' => 'restart', 'align' => 'center', 'borderSize' => 6, 'borderColor' => '000000'])->addText(htmlspecialchars($tema), $myFontStyle2, array('align' => 'left'));

            $table->addCell(1000, ['vMerge' => 'restart', 'align' => 'center', 'borderSize' => 6, 'borderColor' => '000000'])->addText(htmlspecialchars($tema), $myFontStyle2, array('align' => 'left'));

            $index2 = 0;
            $cell = $table->addCell(2000, [
                'valign' => 'center',
                'align' => 'left',
                'borderSize' => 6,
                'borderColor' => '000000'
            ]);

            if (isset($subtemaSeparado[$unidad + 1])) {
                foreach ($subtemaSeparado[$unidad + 1] as $subtema) {
                    $textRun = $cell->addTextRun(['align' => 'left']);
                    $textRun->addText(htmlspecialchars(($unidad + 1) . '.' . ($index2 + 1) . ' ' . $subtema), $myFontStyle2);
                    $textRun->addTextBreak();
                    $index2++;
                }
            } else {
                $textRun = $cell->addTextRun(['align' => 'left']);
                $textRun->addText('No hay subtemas para esta unidad.', $myFontStyle2);
            }

            $cell = $table->addCell(2937, [
                'borderSize' => 6,
                'borderColor' => '000000',
                'width' => 2937
            ]);
            $cell->setWidth(2000); // Por ejemplo, 2000 twips es aproximadamente 1 pulgada

            $cell->setWidthType('dxa');
            $textRun = $cell->addTextRun();
            $textRun->addText('Descripción:', ['size' => 8, 'bold' => true]);
            $textRun->addTextBreak();
            $textRun->addText($descripcion[$unidad], ['size' => 8]);


            $cell = $table->addCell(2937, [
                'borderSize' => 6,
                'borderColor' => '000000',
                'width' => 2937
            ]);
            $cell->setWidth(2000); // Por ejemplo, 2000 twips es aproximadamente 1 pulgada

            $cell->setWidthType('dxa');
            $textRun = $cell->addTextRun();
            $textRun->addText('P:', ['size' => 8, 'bold' => true]);
            $textRun->addTextBreak();
            $textRun->addText($pArea[$unidad], ['size' => 8]);

            $table->addRow(700);
            $table->addCell(1000, ['vMerge' => 'continue', 'align' => 'center', 'borderSize' => 6, 'borderColor' => '000000']);
            $table->addCell(1000, ['vMerge' => 'continue', 'align' => 'center', 'borderSize' => 6, 'borderColor' => '000000']);
            $table->addCell(1000, ['vMerge' => 'continue', 'align' => 'center', 'borderSize' => 6, 'borderColor' => '000000']);

            $cell = $table->addCell(2937, [
                'borderSize' => 6,
                'borderColor' => '000000',
                'width' => 2937,
                'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,

            ]);
            $textRun = $cell->addTextRun();
            $textRun->addText('Resultado(s):', ['size' => 8, 'bold' => true]);
            $textRun->addTextBreak();
            $textRun->addText($resultados[$unidad], ['size' => 8]);


            $cell = $table->addCell(2937, [
                'borderSize' => 6,
                'borderColor' => '000000',
                'width' => 2937,
                'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,

            ]);
            $textRun = $cell->addTextRun();
            $textRun->addText('R:', ['size' => 8, 'bold' => true]);
            $textRun->addTextBreak();
            $textRun->addText($rArea[$unidad], ['size' => 8]);
        }

        $templateProcessor->setComplexBlock('tabla1', $table);
    }

    //Funcion DibujarTablaEvidencias-------------------------------------------------------------------------------------
    public function dibujarTablasEvidencias($templateProcessor, $datos)
    {

        $fancyTableStyle = [
            'borderSize'  => 6,
            'borderColor' => '000000',
            'cellMargin'  => 10,
            'alignment'   => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
        ];

        $index = 0;
       $cantidadUnidades= count($datos[0]);
        if($cantidadUnidades==4){

                $templateProcessor->setValue('tbEvidencias5', '');
                $templateProcessor->setValue('tbEvidencias6', '');

        }
        if($cantidadUnidades==5){

            $templateProcessor->setValue('tbEvidencias6', '');

    }

        for ($columna = 0; $columna < count($datos[0]); $columna++) {

            $table = new Table($fancyTableStyle);


            $myFontStyle = array('bold' => true, 'align' => 'center', 'size' => 11);
            $myFontStyle2 = array('bold' => false, 'align' => 'center', 'size' => 11);

            $table->addRow(400);
            $table->addCell(4248, array('bgColor' => 'F2F2F2'))->addText("Evidencia de Aprendizaje", $myFontStyle, array('align' => 'center'));
            $table->addCell(1368, array('bgColor' => 'F2F2F2'))->addText("%", $myFontStyle, array('align' => 'center'));
            $table->addCell(3, array('gridSpan' => 6, 'bgColor' => 'F2F2F2'))->addText("Indicador de alcance", $myFontStyle, array('align' => 'center'));
            $table->addCell(4118, array('bgColor' => 'F2F2F2'))->addText("Evaluación formativa de la competencia", $myFontStyle, array('align' => 'center'));


            $table->addRow();
            $table->addCell(null, array('bgColor' => 'F2F2F2'));
            $table->addCell(null, array('bgColor' => 'F2F2F2'));
            for ($i = 0; $i < 6; $i++) {
                $table->addCell(662, array('bgColor' => 'F2F2F2'))->addText(chr(65 + $i), $myFontStyle, array('align' => 'center'));
            }
            $table->addCell(null, array('bgColor' => 'F2F2F2'));

            $filaaaaa = 0;
            foreach ($datos as $fila) {
                $table->addRow(400);
                $table->addCell()->addText($fila[$columna][0]);

                for ($i = 1; $i < count($fila[$columna]); $i++) {

                    $table->addCell(null, ['align' => 'center'])->addText($fila[$columna][$i], $myFontStyle2, array('align' => 'center'));
                }
                $filaaaaa++;
            }


            $templateProcessor->setComplexBlock('tbEvidencias' . ($index + 1), $table);
            $index++;
        }
    }

    public function dibujarTablaSemanas($templateProcessor, $arraySemanas,  $arrayFechas, $observaciones)
    {
        $fancyTableStyle = [
            'borderSize'  => 6,
            'borderColor' => '000000',
            'cellMargin'  => 10,
            'alignment'   => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
        ];

        $index = 0;

        $table = new Table($fancyTableStyle);


        $myFontStyle = array('bold' => true, 'align' => 'center', 'size' => 11);
        $myFontStyle2 = array('bold' => false, 'align' => 'center', 'size' => 11);

        $table->addRow(406);
        $table->addCell(1764, array('bgColor' => 'F2F2F2'))->addText("Semana", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("1", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("2", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("3", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("4", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("5", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("6", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("7", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("8", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("9", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("10", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("11", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("12", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("13", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("14", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("15", $myFontStyle, array('align' => 'center'));
        $table->addCell(700, array('bgColor' => 'F2F2F2'))->addText("16", $myFontStyle, array('align' => 'center'));


        $table->addRow(300);
        $table->addCell(1764, array('bgColor' => 'white'))->addText("TP", $myFontStyle, array('align' => 'center'));
        for ($fech = 0; $fech < count($arrayFechas); $fech++) {
            $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => ($arraySemanas[$fech])))->addText("TPU" . ($fech + 1), $myFontStyle, array('align' => 'center'));
        }

        $table->addRow(300);
        $table->addCell(1764, array('bgColor' => 'white'))->addText("TR", $myFontStyle, array('align' => 'center'));
        for ($i = 1; $i <= 16; $i++) {
            $table->addCell(700, array('bgColor' => 'white'))->addText("", $myFontStyle, array('align' => 'center'));
        }
        $table->addRow(300);
        $table->addCell(1764, array('bgColor' => 'white'))->addText("SD", $myFontStyle, array('align' => 'center'));
        for ($i = 1; $i <= 16; $i++) {
            $table->addCell(700, array('bgColor' => 'white'))->addText("", $myFontStyle, array('align' => 'center'));
        }


        $table->addRow(300);
        $table->addCell(1764, array('bgColor' => 'white'))->addText("ED", $myFontStyle, array('align' => 'center'));
        $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => 16))->addText("ED", $myFontStyle, array('align' => 'center'));



        $table->addRow(300);
        $table->addCell(1764, array('bgColor' => 'white'))->addText("EFn", $myFontStyle, array('align' => 'center'));
        for ($fech = 0; $fech < count($arrayFechas); $fech++) {
            $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => ($arraySemanas[$fech])))->addText($arrayFechas[$fech], $myFontStyle, array('align' => 'center'));
        }

        $table->addRow(300);
        $table->addCell(1764, array('bgColor' => 'white'))->addText("TP", $myFontStyle, array('align' => 'center'));
        for ($i = 1; $i <= 16; $i++) {
            $table->addCell(700, array('bgColor' => 'white'))->addText("", $myFontStyle, array('align' => 'center'));
        }





        $table->addRow();
        $cell = $table->addCell(2937, [
            'borderSize' => 6,
            'borderColor' => '000000',
            'gridSpan' => 17,
            'cellMargin' => [
                'top' => 80,
                'left' => 80,
                'right' => 80,
                'bottom' => 80
            ]
        ]);

        $textRun = $cell->addTextRun([
            'spaceBefore' => 80,
            'spaceAfter' => 80,
            'indentation' => [
                'left' => 80,
                'right' => 80,
            ]
        ]);
        $textRun->addText('Objetivo General del Curso: ', ['bold' => true]);
        $textRun->addText($observaciones);

        $table->addRow(1006);
        $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => 1))->addText("Firma del docente por seguimiento", $myFontStyle, array('align' => 'center'));
        $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => 5))->addText("", $myFontStyle, array('align' => 'center'));
        $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => 4))->addText("", $myFontStyle, array('align' => 'center'));
        $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => 4))->addText("", $myFontStyle, array('align' => 'center'));
        $table->addCell(1764, array('bgColor' => 'white', 'gridSpan' => 3))->addText("", $myFontStyle, array('align' => 'center'));



        $templateProcessor->setComplexBlock('tbCalendarizacion', $table);
    }
}
