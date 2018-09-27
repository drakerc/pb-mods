<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Modification;
use App\ModificationVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModificationController extends Controller
{
    private function prepareModificationArray(Modification $modification, Request $request)
    {
        $modification->size = $modification->getModificationSizeName();
        $modification->development_status = $modification->getModificationDevStatus();

        if ($request->ajax()) {
            return [
                'mod' => $modification->toArray(),
            ];
        }
        return [
            'mod' => $modification->toArray(),
            'path' => $request->getPathInfo()
        ];
    }

    // TODO: this is pretty much the same as prepareCategoryCreationInfo - maybe move to a helper?
    private function prepareModificationCreationInfo(Game $game, Category $category, Request $request)
    {
        if ($request->ajax()) {
            return [
                'category' => $category->toArray(),
                'game' => $game->toArray(),
                'auth' => Auth::check()
            ];
        }
        return [
            'category' => $category->toArray(),
            'game' => $game->toArray(),
            'path' => $request->getPathInfo(),
            'auth' => Auth::check()
        ];
    }

    public function getModification(Modification $mod, Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->prepareModificationArray($mod, $request));
        }
        return view('start', ['model' => $this->prepareModificationArray($mod, $request)]);
    }

    public function getModificationsInCategoryApi(Category $category)
    {
        return response()->json(($category->getModificationsInCategory())->toArray());
    }

    public function getFilesApi(Modification $mod)
    {
        return response()->json($mod->getFiles());
    }

    public function getImagesApi(Modification $mod)
    {
        return response()->json($mod->getImages());
    }

    public function getVideosApi(Modification $mod)
    {
        return response()->json($mod->getVideos());
    }

    private function validation(Request $request)
    {
        //https://scotch.io/tutorials/simple-laravel-crud-with-resource-controllers
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'development_status' => 'required|integer|in:0,1,2,3,4',
            'size' => 'required|integer|in:0,1,2',
            'replaces' => 'string|max:100',
            'version' => 'string|max:20',
            'release_date' => 'date',
            'font_color' => 'string',
//                'development_studio' => $request->development_studio,
            'creator' => 'exists:users',
            'game_id' => 'exists:games',
            'category_id' => 'exists:categories',
        ]);
    }

    public function create(Game $game = null, Category $category = null, Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->prepareModificationCreationInfo($game, $category, $request));
        }
        if ($request->method() === 'GET') {
            return view('start', ['model' => $this->prepareModificationCreationInfo($game, $category, $request)]);
        }

        $validation = $this->validation($request);

        $modification = new Modification(
            [
                'title' => $request->title,
                'description' => $request->description,
                'development_status' => $request->development_status,
                'size' => $request->size,
                'replaces' => $request->replaces,
                'version' => $request->version,
                'release_date' => \DateTime::createFromFormat('d-m-Y', $request->release_date)->format('Y-m-d'),
                'font_color' => $request->font_color,
//                'development_studio' => $request->development_studio,
            ]);
        $modification->creator = Auth::id();
        $modification->game_id = $request->gameid;
        $modification->category_id = $request->categoryid;

        $modification->save();
        return redirect()->route('ModificationView', ['mod' => $modification->id]);
    }

    public function edit(Modification $mod, Request $request)
    {
        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }
        if ($request->ajax()) {
            return response()->json([
                'mod' => $mod->toArray(),
                'category' => Category::find($mod->category_id)->toArray(),
                'game' => Game::find($mod->game_id)->toArray(),
                'auth' => Auth::check()
            ]);
        }
        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'mod' => $mod->toArray(),
                'category' => Category::find($mod->category_id)->toArray(),
                'game' => Game::find($mod->game_id)->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $validation = $this->validation($request); // $validation var is not yet used

        $mod->update([
            'title' => $request->title,
            'description' => $request->description,
            'development_status' => $request->development_status,
            'size' => $request->size,
            'replaces' => $request->replaces,
            'version' => $request->version,
            'release_date' => \DateTime::createFromFormat('Y-m-d', $request->release_date)->format('Y-m-d'),
            'game_id' => $request->game_id,
            'category_id' => $request->category_id,
            'font_color' => $request->font_color,
//                'development_studio' => $request->development_studio,
        ]);

        // these fields should probably not be able to be updated?
//        $mod->creator = Auth::id();
//        $mod->game_id = $request->gameid;
//        $mod->category_id = $request->categoryid;

        $mod->save();
        $request->session()->flash('info', 'Pomyślnie zaktualizowano modyfikację!');

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function destroy(Modification $mod, Request $request)
    {
        if (Auth::id() !== $mod->creator) { //TODO: or admin, or one of the dev studio members
            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }
        if (!$request->ajax()) {
            return false; // should never happen, if it does, show a warning
        }
        if ($mod->delete()) {
            $request->session()->flash('info', 'Pomyślnie usunięto modyfikację!');
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }
}
