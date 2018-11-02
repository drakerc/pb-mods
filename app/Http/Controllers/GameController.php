<?php

namespace App\Http\Controllers;

use App\File;
use App\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Game::orderBy('created_at', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'game_category_ids' => 'required', //TODO: make it check arrays from FormData?
            'logoFile' => 'required|image|max:1000'
        ]);

        $game = new Game([
           'title' => $request->title,
           'description' => $request->description
        ]);

        $user = $request->user();

        $imageName = Carbon::now()->timestamp . $request->logoFile->getClientOriginalName();


        $imageFile = new File();
        $imageFile->file_path = $request->logoFile->storeAs('game/logo', $imageName, ['disk' => 'public']);
        $imageFile->file_type = $request->logoFile->getMimeType();
        $imageFile->file_size = $request->logoFile->getSize();
        $imageFile->uploader_id = $user->id;

        $imageFile->save();

        $game->logo_id = $imageFile->id;
        $game->save();

        $game_categories = explode(',', $request->game_category_ids);
        foreach ($game_categories as $category)
        {
            $game->categories()->attach($category);
        }

        return response()->json($game);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::with(['posts', 'logo', 'categories', 'files'])->FindOrFail($id);
        return response()->json($game);
//        return response()->json([
//           'game' => $game
//        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchByPhraseInTitleOrDescription(Request $request)
    {
        $phrase = $request->phrase;
        $games = Game::where('title', 'like', '%' . $phrase . '%')
            ->orWhere('description', 'like', '%' . $phrase . '%')
            ->get(['id', 'title']);

        return response()->json($games);
    }

    public function indexWeb()
    {
        return view('game.start');
    }

    public function getGameTitleApi(Game $game)
    {
        return $game->title;
    }

    /**
     * @param Request $request
     * @param [string] $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImages(Request $request, $id) {
        Log::info($request);
        $request->validate([
           'images' => 'required|array|min:1'
        ]);

        $game = Game::findOrFail($id);

        $deleted = [];
        foreach ($request->images as $image_id)
        {
            Log::info($image_id);

            $file = File::findOrFail($image_id);
            Log::info($file);

            if ($file)
            {
                $game->files()->detach($image_id);
                Storage::disk('public')->delete($file->file_path); // TODO: replace with soft-deleting?
            }
            array_push($deleted, $file);
        }

        return response()->json($deleted);
    }

    /**
     * @param Request $request
     * @param [string] $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImages(Request $request, $id)
    {
        $request->validate([
            'images' => 'required|array|min:1'
        ]);

        $game = Game::findOrFail($id);
        $user = $request->user();

        Log::info($request->images);
        foreach ($request->images as $key => $requestFile)
        {
            $file = new File();
            Log::info($key);
            Log::info($requestFile->getClientOriginalName());
            $imageName = Carbon::now()->timestamp . '-' . $game->id . '-' . $key . $requestFile->getClientOriginalName();
            $file->file_path = $requestFile->storeAs('game/files', $imageName, ['disk' => 'public']);
            $file->file_type = $requestFile->getMimeType();
            $file->file_size = $requestFile->getSize();
            $file->uploader_id = $user->id;

            $file->save();
            $game->files()->attach($file->id);
        }
    }
}
