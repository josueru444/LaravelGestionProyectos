<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Faker\Core\File;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Symfony\Component\Process\Process;

class ControllerPDF extends Controller
{
    protected $openAIService;
    public function __construct(OpenAIService $openAIService) {
        $this->openAIService = $openAIService;
    }
    public function getResponse(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt');
        $response = $this->openAIService->generateResponse($prompt);

        return response()->json(['response' => $response]);
    }

    public function extractText(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt,pdf,doc,docx',
        ]);

        $path = $request->file('file')->store('uploads');

        $fileContent = Storage::get($path);
        $response = $this->openAIService->generateResponse($fileContent);

        return response()->json(['response' => $response]);
    }

}
