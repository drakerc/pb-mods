<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use App\Modification;
use App\ModificationVideo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModificationVideoController extends Controller
{
    public function createModificationVideos(Modification $mod, Request $request)
    {
        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
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

        $validator = Validator::make($request->all(), [
            'videos.*.url' => 'string|url|required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('CreateModVideos', ['mod' => $mod->id])
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->post('videos') as $key => $value) {
            $video = new ModificationVideo(['url' => $value['url'], 'availability' => true]);
            $title = $value['title'];

            if ($title === null) {
                $title = $this->getVideoTitle($value['url']);
            }

            $video->title = $title;
            $video->uploader_id = Auth::id();
            $video->modification()->associate($mod);

            $video->save();
        }

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function editModificationVideos(Modification $mod, Request $request)
    {
        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        if ($request->ajax()) {
            return response()->json([
                'mod' => $mod->toArray(),
                'videos' => $mod->getVideos(),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'mod' => $mod->toArray(),
                'videos' => $mod->getVideos(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        foreach ($request->post('videos') as $key => $value) {
            $video = $mod->videos()->find($value['id']);
            if ($video === null) {
                throw new ModelNotFoundException('Could not find a video with id' . $key);
            }

            $title = $value['title'];
            if ($title === null || ($title === $video->title && $value['url'] !== $video->url)) {
                $title = $this->getVideoTitle($value['url']); // Update the title from API if it's either null or a new video url was provided without changing the title
            }

            $video->title = $title;
            $video->uploader_id = Auth::id();
            $video->url = $value['url'];
            $video->availability = $value['availability'];

            $video->save();
        }

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    private function getVideoTitle($url)
    {
        $id = Youtube::parseVidFromURL($url);
        $info = Youtube::getVideoInfo($id);
        return $info->snippet->title;
    }

    public function destroy(Modification $mod, ModificationVideo $video, Request $request)
    {
        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        if (!$request->ajax()) {
            return false; // should never happen, if it does, show a warning
        }

        if ($video->delete()) {
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }
}
