<?php

namespace App\Http\Controllers;

use App\File;
use App\Modification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ZanySoft\Zip\Zip;

class FileController extends Controller
{
    /**
     * @param Modification $mod
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|true
     */
    public function createModificationFiles(Modification $mod, Request $request)
    {
        $redirectionData = $this->getModificationFileCreationRedirections($mod, $request);
        if ($redirectionData !== true) {
            return $redirectionData;
        }

        $textsValidator = Validator::make($request->all(), [
            'files.*.title' => 'string|required',
            'files.*.description' => 'string|max:100',
        ]);

        $filesValidator = Validator::make($request->allFiles(), [
            'files.*' => 'file|max:1000000', // 1GB
        ]);

        if ($textsValidator->fails() || $filesValidator->fails()) {
            $validationMessages = array_merge($textsValidator->messages()->toArray(), $filesValidator->messages()->toArray());

            return redirect()->route('CreateModFiles', ['mod' => $mod->id])
                ->withErrors($validationMessages)
                ->withInput();
        }

        $params = $request->post('files');

        foreach ($request->file('files') as $key => $value) {
            $file = new File();
            $file->file_path = $value->store('modification_files', ['disk' => 'public']);
            $file->file_type = $value->getMimeType();
            $file->file_size = $value->getSize();
            $file->uploader_id = Auth::id();

            $file->save();

            $mod->files()->attach($file->id, ['title' => $params[$key]['title'], 'description' => $params[$key]['description']]);
        }

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    /**
     * @param Modification $mod
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|true
     */
    public function createModificationImageFiles(Modification $mod, Request $request)
    {
        $redirectionData = $this->getModificationFileCreationRedirections($mod, $request);
        if ($redirectionData !== true) {
            return $redirectionData;
        }

        $filesValidator = Validator::make($request->allFiles(), [
            'files.*' => 'file|image|max:10000', // 10MB
        ]);

        if ($filesValidator->fails()) {
            return redirect()->route('CreateModImages', ['mod' => $mod->id])
                ->withErrors($filesValidator)
                ->withInput();
        }

        foreach ($request->file('files') as $key => $value) {
            $file = new File();
            $file->file_path = $value->store('modification_files', ['disk' => 'public']);
            $file->file_type = $value->getMimeType();
            $file->file_size = $value->getSize();
            $file->uploader_id = Auth::id();

            $file->save();

            $mod->images()->attach($file->id, ['active' => true, 'type' => $request->get('type')]);
        }

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function editModificationFiles(Modification $mod, Request $request)
    {
//        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
//            $request->session()->flash('info', 'Nie masz uprawnień');
//            return redirect()->route('ModificationView', ['mod' => $mod->id]);
//        }

        if ($request->ajax()) {
            return response()->json([
                'mod' => $mod->toArray(),
                'files' => $mod->getFiles(true),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'mod' => $mod->toArray(),
                'files' => $mod->getFiles(true),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $files = $request->file('files');

        foreach ($request->post('files') as $key => $value) {
            $file = $mod->files()->find($key);
            if ($file === null) {
                throw new ModelNotFoundException('Could not find a file with id' . $key);
            }

            if (isset($files[$key])) {
                $file->file_path = $files[$key]->store('modification_files', ['disk' => 'public']);
                $file->file_type = $files[$key]->getMimeType();
                $file->file_size = $files[$key]->getSize();
                $file->uploader_id = Auth::id();
            }

            $file->availability = $value['availability'];
            $file->pivot->title = $value['title'];
            $file->pivot->description = $value['description'];
            $file->save();
            $file->pivot->save();
        }

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function destroy(Modification $mod, File $file, Request $request)
    {
//        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
//            $request->session()->flash('info', 'Nie masz uprawnień');
//            return redirect()->route('ModificationView', ['mod' => $mod->id]);
//        }

        if (!$request->ajax()) {
            return false; // should never happen, if it does, show a warning
        }
        if ($file->delete()) {
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }

    public function editModificationImageFiles(Modification $mod, Request $request)
    {
//        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
//            $request->session()->flash('info', 'Nie masz uprawnień');
//            return redirect()->route('ModificationView', ['mod' => $mod->id]);
//        }

        if ($request->ajax()) {
            return response()->json([
                'mod' => $mod->toArray(),
                'files' => $mod->getImages(true),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'mod' => $mod->toArray(),
                'files' => $mod->getImages(true),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $files = $request->file('files');

        foreach ($request->post('files') as $key => $value) {
            $file = $mod->images()->find($key);
            if (isset($files[$key])) {
                $file->file_path = $files[$key]->store('modification_files', ['disk' => 'public']);
                $file->file_type = $files[$key]->getMimeType();
                $file->file_size = $files[$key]->getSize();
                $file->uploader_id = Auth::id();
            }
            $file->availability = $value['availability'];
            $file->save();
        }

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function massDownload(Modification $mod, Request $request)
    {
        $files = $request->get('files');
        $files = File::findMany(explode(',', $files))->pluck('file_path');

        $files->transform(function ($value) {
            return public_path() . '/storage/' . $value;
        });

        $filePath = tempnam(public_path() . '/storage/zips', 'temp_mass_download_');

        $zip = Zip::create($filePath, true);
        $zip->add($files->toArray());
        $zip->close();

        return response()->download($filePath, 'mass-download.zip');
    }

    /**
     * @param Modification $mod
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|true
     */
    private function getModificationFileCreationRedirections(Modification $mod, Request $request)
    {
//        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
//            $request->session()->flash('info', 'Nie masz uprawnień');
//            return redirect()->route('ModificationView', ['mod' => $mod->id]);
//        }
        if ($request->ajax()) {
            return response()->json([
                'mod' => $mod->toArray(),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'mod' => $mod->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        return true;
    }
}
