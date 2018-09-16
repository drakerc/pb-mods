<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Modification;
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

    public function createModification(Game $game = null, Category $category = null, Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->prepareModificationCreationInfo($game, $category, $request));
        }
        if ($request->method() === 'GET') {
            return view('start', ['model' => $this->prepareModificationCreationInfo($game, $category, $request)]);
        }

        $modification = new Modification(
            [
                'title' => $request->title,
                'description' => $request->description,
                'development_status' => $request->development_status,
                'size' => $request->size,
                'replaces' => $request->replaces,
                'version' => $request->version,
                'release_date' => $request->release_date,
                'game_id' => $request->game_id,
                'category_id' => $request->category_id,
                'font_color' => $request->font_color,
//                'development_studio' => $request->development_studio,
            ]);
        $modification->creator = Auth::id();

        $modification->save();
        return redirect()->route('ModificationView', ['mod' => $modification->id]);
    }
}
