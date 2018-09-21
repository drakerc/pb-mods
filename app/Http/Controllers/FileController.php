<?php

namespace App\Http\Controllers;

use App\File;
use App\Modification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            'files.*' => 'file|max:1', // 1GB
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

    /**
     * @param Modification $mod
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|true
     */
    private function getModificationFileCreationRedirections(Modification $mod, Request $request)
    {
        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
            $request->session()->flash('info', 'Nie masz uprawnień');
//            return false;
        }
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
