<?php

namespace App\Http\Controllers;

use App\File;
use App\Instruction;
use App\Modification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JasperPHP\JasperPHP;
use App\Services\ReportingService;

class InstructionController extends Controller
{
    private $reportingService;

    public function __construct(ReportingService $reportingService)
    {
        $this->reportingService = $reportingService;
    }

    public function create(Modification $mod, File $file, Request $request)
    {
        $canManage = ModificationController::canManageMod($mod);
        if ($canManage === false) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Nie masz uprawnień!',
                ], 403);
            }

            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        if ($request->ajax()) {
            return response()->json([
                'file' => $file->toArray(),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'file' => $file->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $validation = $this->validation($request); // $validation var is not yet used

        $instruction = new Instruction([
            'title' => $request->post('title'),
            'description' => $request->post('description')
        ]);
        $instruction->author_id = Auth::id();
        $instruction->save();

        $file->instructions()->attach($instruction->id);

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function edit(Modification $mod, File $file, Instruction $instruction, Request $request)
    {
        $canManage = ModificationController::canManageMod($mod);
        if ($canManage === false) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Nie masz uprawnień!',
                ], 403);
            }

            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        if ($request->ajax()) {
            return response()->json([
                'file' => $file->toArray(),
                'instruction' => $instruction->toArray(),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'file' => $file->toArray(),
                'instruction' => $instruction->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $instruction->update([
            'title' => $request->post('title'),
            'description' => $request->post('description'),
        ]);
        $instruction->author_id = Auth::id();
        $instruction->save();

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function destroy(Modification $mod, File $file, Instruction $instruction, Request $request)
    {
        $canManage = ModificationController::canManageMod($mod);
        if ($canManage === false) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Nie masz uprawnień!',
                ], 403);
            }

            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        if (!$request->ajax()) {
            return false; // should never happen, if it does, show a warning
        }

        if ($instruction->delete()) {
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }

    private function validation(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    }

    public function showPdf(Modification $mod, File $file, Instruction $instruction, Request $request)
    {
        $pdfFilePath = $this->reportingService->prepareFileInstruction($instruction, $file, $mod);

        return response()->file($pdfFilePath);
    }
}
