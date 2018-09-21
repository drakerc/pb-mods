<?php

namespace App\Http\Controllers;

use App\File;
use App\Modification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        foreach ($request->allFiles() as $key => $value) {
            $file = new File();
            $file->file_path = $value->store('modification_files', ['disk' => 'public']);
            $file->file_type = $value->getMimeType();
            $file->file_size = $value->getSize();
            $file->uploader_id = Auth::id();

            $file->save();

            $mod->files()->attach($file->id, ['title' => $request->get('title-' . $key), 'description' => $request->get('description-' . $key)]);
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

        foreach ($request->allFiles() as $key => $value) {
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
