<?php

namespace App\Http\Controllers;

use App\File;
use App\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'logo_file' => 'required|image|max:1000',
            'background_file' => 'required|image',
            'variant' => 'required|string',
            'development_studios' => 'required'
        ]);

        $game = new Game([
            'title' => $request->title,
            'description' => $request->description,
            'variant' => $request->variant
        ]);

        $user = $request->user();

        $image_file_name = Str::uuid()->toString() . $request->logo_file->getClientOriginalName();

        $logo_image_file = new File();
        $logo_image_file->file_path = $request->logo_file->storeAs('game/logo', $image_file_name, ['disk' => 'public']);
        $logo_image_file->file_type = $request->logo_file->getMimeType();
        $logo_image_file->file_size = $request->logo_file->getSize();
        $logo_image_file->uploader_id = $user->id;

        $logo_image_file->save();

        $background_image_name = Str::uuid()->toString() . $request->background_file->getClientOriginalName();

        $background_image_file = new File();
        $background_image_file->file_path = $request->background_file->storeAs('game/background', $background_image_name, ['disk' => 'public']);
        $background_image_file->file_type = $request->background_file->getMimeType();
        $background_image_file->file_size = $request->background_file->getSize();
        $background_image_file->uploader_id = $user->id;

        $background_image_file->save();

        $game->background()->associate($background_image_file);
        $game->logo()->associate($logo_image_file);

        $game->save();

        $game_categories = explode(',', $request->game_category_ids);
        foreach ($game_categories as $category)
        {
            $game->categories()->attach($category);
        }

        $development_studios = explode(',', $request->development_studios);
        foreach ($development_studios as $studio)
        {
            $game->developmentStudio()->attach($studio);
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
        $game = Game::with(['posts', 'logo', 'categories', 'files', 'background', 'developmentStudio'])->FindOrFail($id);
        return response()->json($game);
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

        $request->validate([
           'images' => 'required|array|min:1'
        ]);

        $game = Game::findOrFail($id);

        $deleted = [];
        foreach ($request->images as $image_id)
        {

            $file = File::findOrFail($image_id);

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

        foreach ($request->images as $key => $requestFile)
        {
            $file = new File();

            $imageName = Str::uuid()->toString() . '-' . $game->id . '-' . $key . $requestFile->getClientOriginalName();
            $file->file_path = $requestFile->storeAs('game/files', $imageName, ['disk' => 'public']);
            $file->file_type = $requestFile->getMimeType();
            $file->file_size = $requestFile->getSize();
            $file->uploader_id = $user->id;

            $file->save();
            $game->files()->attach($file->id);
        }
    }
}
