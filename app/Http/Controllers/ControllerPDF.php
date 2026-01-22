<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use Orhanerday\OpenAi\OpenAi;

class ControllerPDF extends Controller
{
    public function processPdf(Request $request)
    {
        // Store the uploaded file
        $path = $request->file('pdf_file')->store('pdfs');

        // Parse the PDF
        $parser = new Parser();
        $pdf = $parser->parseFile(storage_path('app/' . $path));
        $text = $pdf->getText();

        // Extract relevant data from the text using OpenAI API
        $data = $this->extractDataWithOpenAI($text);

        // Convert data to JSON (optional)
        $json = json_encode($data, JSON_PRETTY_PRINT);

        // Save the JSON to a file (optional)
        $jsonPath = 'json/' . pathinfo($path, PATHINFO_FILENAME) . '.json';
        Storage::put($jsonPath, $json);

        // Redirect to the 'instrumentacion' route with the data
        return redirect()->route('instrumentacion')->with('data', $data);
    }

    protected function extractDataWithOpenAI($text)
    {
        // Create a new OpenAI client instance
        $openai = new OpenAi(env('OPENAI_API_KEY'));

        // Create the payload for the API request
        $payload = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a data extraction assistant.'
                ],
                [
                    'role' => 'user',
                    'content' => $this->generatePrompt($text)
                ]
            ],
            'max_tokens' => 1500,
        ];

        // Send the API request
        $response = $openai->chat($payload);

        // Decode the API response
        $responseData = json_decode($response, true);

        // Extract the content from the response
        $content = $responseData['choices'][0]['message']['content'];

        return json_decode($content, true);
    }

    protected function generatePrompt($text)
    {
        return "
        Extrae la siguiente información de este texto de un documento PDF sobre una asignatura:
        - Nombre de la asignatura
        - Clave de la asignatura
        - SATCA
        - Carrera
        - Competencias a desarrollar
        - Temario con números, temas y subtemas

        Texto del PDF:
        $text

        Formato de respuesta esperado:
        {
            \"nombre\": \"\",
            \"clave\": \"\",
            \"satca\": \"\",
            \"carrera\": \"\",
            \"competencias\": [],
            \"temario\": []
        }
        ";
    }
}
