<?php

namespace App\Http\Controllers;

use App\Modification;
use App\ModificationRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModificationRatingController extends Controller
{
    public function create(Modification $mod, Request $request)
    {
        $canManage = ModificationController::canManageMod($mod);
        if ($canManage === true) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Nie możesz ocenić swojej modyfikacji!',
                ], 403);
            }

            $request->session()->flash('info', 'Nie możesz ocenić swojej modyfikacji');
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

        $validation = $this->validation($request); // $validation var is not yet used

        $rating = new ModificationRating([
            'title' => $request->post('title'),
            'description' => $request->post('description'),
            'rating' => $request->post('rating'),
            'rating_usability' => $request->post('rating_usability'),
            'rating_fun' => $request->post('rating_fun'),
            'rating_quality' => $request->post('rating_quality'),
        ]);

        $rating->author_id = Auth::id();
        $rating->modification()->associate($mod);
        $rating->save();
        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function edit(Modification $mod, ModificationRating $rating, Request $request)
    {
        if (Auth::id() !== $rating->author_id) { //TODO: or admin
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Nie masz uprawnień!',
                ], 403);
            }

            $request->session()->flash('info', 'Nie masz uprawnień');
            return redirect()->route('ModificationView', ['mod' => $mod->id]);
        }

        if ($request->ajax()) {
            return response()->json([
                'mod' => $mod->toArray(),
                'rating' => $rating->toArray(),
                'auth' => Auth::check()
            ]);
        }

        if ($request->method() === 'GET') {
            return view('start', ['model' => [
                'mod' => $mod->toArray(),
                'rating' => $rating->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ]]);
        }

        $validation = $this->validation($request); // $validation var is not yet used

        $rating->update([
            'title' => $request->post('title'),
            'author_id' => Auth::id(),
            'description' => $request->post('description'),
            'rating' => $request->post('rating'),
            'rating_usability' => $request->post('rating_usability'),
            'rating_fun' => $request->post('rating_fun'),
            'rating_quality' => $request->post('rating_quality'),
        ]);

        $rating->save();
        return redirect()->route('ModificationView', ['mod' => $mod->id]);
    }

    public function destroy(Modification $mod, ModificationRating $rating, Request $request)
    {
        if (Auth::id() !== $rating->author_id) { //TODO: or admin
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

        if ($rating->delete()) {
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
            'rating' => 'required|integer|in:1,2,3,4,5',
            'rating_usability' => 'nullable|integer|in:1,2,3,4,5',
            'rating_fun' => 'nullable|integer|in:1,2,3,4,5',
            'rating_quality' => 'nullable|integer|in:1,2,3,4,5',
        ]);
    }
}
