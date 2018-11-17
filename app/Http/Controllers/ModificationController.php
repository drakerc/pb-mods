<?php

namespace App\Http\Controllers;

use App\Category;
use App\DevelopmentStudio;
use App\Game;
use App\Modification;
use App\User;
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
                'canManageMod' => self::canManageMod($modification),
            ];
        }
        return [
            'mod' => $modification->toArray(),
            'canManageMod' => self::canManageMod($modification),
            'path' => $request->getPathInfo()
        ];
    }

    // TODO: this is pretty much the same as prepareCategoryCreationInfo - maybe move to a helper?
    private function prepareModificationCreationInfo(Game $game, Category $category, Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            return [
                'category' => $category->toArray(),
                'game' => $game->toArray(),
                'studios' => $user->studios()->get()->toArray(),
                'auth' => Auth::check()
            ];
        }
        return [
            'category' => $category->toArray(),
            'game' => $game->toArray(),
            'studios' => $user->studios()->get()->toArray(),
            'path' => $request->getPathInfo(),
            'auth' => Auth::check()
        ];
    }

    public static function canManageMod($mod)
    {
        if (Auth::id() === null && Auth('api')->user() === null) {
            return false;
        }
        $user = Auth::user();

        if ($user === null) {
            $user = Auth('api')->user();
        }

        if ($user->id === $mod->creator) {
            return true;
        }

        $studio = $mod->developmentStudio()->first();

        if ($studio !== null) {
            $members = $studio->users()->get();

            if ($members->contains('id', $user->id)) {
                return true;
            }
        }
        return false;
    }

    public function getModification(Modification $mod, Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->prepareModificationArray($mod, $request));
        }
        return view('start', ['model' => $this->prepareModificationArray($mod, $request)]);
    }

    public function getRatings(Modification $mod, Request $request)
    {
        if ($request->ajax()) {
            return response()->json(
                [
                    'ratings' => ($mod->ratings()->get())->toArray(),
                    'mod' => $mod->toArray(),
                    'auth' => Auth::check()
                ]);
        }
        return view('start', ['model' => [
            'ratings' => ($mod->ratings()->get())->toArray(),
            'mod' => $mod->toArray(),
            'auth' => Auth::check(),
            'path' => $request->getPathInfo(),
        ]]);
    }

    public function getNews(Modification $mod, Request $request)
    {
        if ($request->ajax()) {
            return response()->json(
                [
                    'news' => ($mod->news()->get()->sortByDesc('created_at'))->values()->toArray(),
                    'mod' => $mod->toArray(),
                    'auth' => Auth::check()
                ]);
        }
        return view('start', ['model' => [
            'news' => ($mod->news()->get())->toArray(),
            'mod' => $mod->toArray(),
            'auth' => Auth::check(),
            'path' => $request->getPathInfo(),
        ]]);
    }

    public function getUserMods(User $user, Request $request)
    {
        return response()->json(
            [
                'user' => $user->toArray(),
                'mods' => Modification::where('creator', '=', $user->id)->get()->toArray(),
            ]
        );
    }

    public function getModificationsInCategoryApi(Category $category)
    {
        return response()->json($category->getModificationsInCategory());

//        return response()->json(($category->getModificationsInCategory())->toArray());
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
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'development_status' => 'required|integer|in:0,1,2,3,4',
            'size' => 'required|integer|in:0,1,2',
            'replaces' => 'string|nullable|max:100',
            'version' => 'string|nullable|max:20',
            'release_date' => 'date|nullable',
            'font_color' => 'string|nullable',
            'font_color_splash_text' => 'string',
            'color_splash_background' => 'string',
            'transparency_splash_background' => 'numeric',
            'font_color_description' => 'string',
            'color_description_background' => 'string',
            'transparency_description_background' => 'numeric',
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
            ]);
        $modification->release_date = $request->release_date === null ? null
            : \DateTime::createFromFormat('d-m-Y', $request->release_date)->format('Y-m-d');
        $modification->creator = Auth::id();
        $modification->game_id = $request->gameid;
        $modification->category_id = $request->categoryid;

        $studio = $request->development_studio;
        if ($studio !== null) {
            $modification->developmentStudio()->attach($request->development_studio);
        }

        $modification->save();
        return redirect()->route('ModificationView', ['mod' => $modification->id]);
    }

    public function edit(Modification $mod, Request $request)
    {
        $canManage = self::canManageMod($mod);
        if ($canManage === false) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Nie masz uprawnień!',
                ], 403);
            }

            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        $user = Auth::user();

        if ($request->ajax()) {
            return response()->json([
                'mod' => $mod->toArray(),
                'category' => Category::find($mod->category_id)->toArray(),
                'game' => Game::find($mod->game_id)->toArray(),
                'studios' => $user->studios()->get()->toArray(),
                'auth' => Auth::check()
            ]);
        }
        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'mod' => $mod->toArray(),
                'category' => Category::find($mod->category_id)->toArray(),
                'game' => Game::find($mod->game_id)->toArray(),
                'studios' => $user->studios()->get()->toArray(),
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
            'game_id' => $request->game_id,
            'category_id' => $request->category_id,
            'font_color' => $request->font_color,
            'font_color_splash_text' => $request->font_color_splash_text,
            'color_splash_background' => $request->color_splash_background,
            'transparency_splash_background' => $request->transparency_splash_background,
            'font_color_description' => $request->font_color_description,
            'color_description_background' => $request->color_description_background,
            'transparency_description_background' => $request->transparency_description_background,
//                'development_studio' => $request->development_studio,
        ]);

        // these fields should probably not be able to be updated?
//        $mod->creator = Auth::id();
//        $mod->game_id = $request->gameid;
//        $mod->category_id = $request->categoryid;
        $mod->release_date = $request->release_date === '' ? null : \DateTime::createFromFormat('d-m-Y', $request->release_date)->format('Y-m-d');

        $studio = $request->development_studio;
        if ($studio !== null) {
            $mod->developmentStudio()->sync([$request->development_studio]);
        }

        $mod->save();
        $request->session()->flash('info', 'Pomyślnie zaktualizowano modyfikację!');

        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function destroy(Modification $mod, Request $request)
    {
        $canManage = self::canManageMod($mod);
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

    public function getModTitleApi(Modification $mod)
    {
        return $mod->title;
    }
}
