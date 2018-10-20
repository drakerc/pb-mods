<?php

namespace App\Http\Controllers;

use App\Modification;
use App\ModificationNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModificationNewsController extends Controller
{
    public function create(Modification $mod, Request $request)
    {
//        if (Auth::id() !== $mod->creator) { //TODO: or one of the dev studio members
//            $request->session()->flash('info', 'Nie masz uprawnień.');
//            return redirect()->route('ModificationView', ['mod' => $mod->id]);
//        }

        if ($request->ajax()) {
            return response()->json([
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $validation = $this->validation($request); // $validation var is not yet used

        $news = new ModificationNews([
            'title' => $request->post('title'),
            'description' => $request->post('description'),
        ]);

        $news->author_id = Auth::id();
        $news->modification()->associate($mod);
        $news->save();
        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function edit(Modification $mod, ModificationNews $news, Request $request)
    {
//        if (Auth::id() !== $rating->author_id) { //TODO: or admin or dev team member
//            $request->session()->flash('info', 'Nie masz uprawnień');
//            return redirect()->route('ModificationView', ['mod' => $mod->id]);
//        }

        if ($request->ajax()) {
            return response()->json([
                'news' => $news->toArray(),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'news' => $news->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $validation = $this->validation($request); // $validation var is not yet used

        $news->update([
            'title' => $request->post('title'),
            'description' => $request->post('description'),
        ]);

        $news->save();
        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function destroy(Modification $mod, ModificationNews $news, Request $request)
    {
        if (Auth::id() !== $news->author_id) { //TODO: or admin
            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        if (!$request->ajax()) {
            return false; // should never happen, if it does, show a warning
        }

        if ($news->delete()) {
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
}
