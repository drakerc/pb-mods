<?php

namespace App\Http\Controllers;

use App\DevelopmentStudio;
use App\Modification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevelopmentStudioController extends Controller
{
    /**
     * Returns all development studios paginated by 10 results.
     * Use 'filters' request param to narrow the search results
     * For example if filters['specialization'] = 1, it will only find studios with a Mods specialization
     *
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $studios = DevelopmentStudio::where('1 = 1');

        $filters = $request->get('filters');

        if ($filters !== null) {
            foreach ($filters as $key => $value) {
                $studios->where($key, $value);
            }
        }

        if ($request->ajax()) {
            return response()->json(
                [
                    'studios' => $studios->paginate(10),
                    'auth' => Auth::check()
                ]);
        }
        return false;
    }

    public function details(DevelopmentStudio $studio, Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'studio' => $studio->toArray(),
                'auth' => Auth::check()
            ]);
        }
        return false;
    }

    public function mods(DevelopmentStudio $studio, Request $request)
    {
        $mods = $studio->modifications()->paginate(10);

        if ($request->ajax()) {
            return response()->json(
                [
                    'studio' => $studio->toArray(),
                    'mods' => $mods,
                    'auth' => Auth::check()
                ]);
        }
        return false;
    }

    public function games(DevelopmentStudio $studio, Request $request)
    {
        $games = $studio->games()->paginate(10);

        if ($request->ajax()) {
            return response()->json(
                [
                    'studio' => $studio->toArray(),
                    'games' => $games,
                    'auth' => Auth::check()
                ]);
        }
        return false;
    }

    public function create(Request $request)
    {
//        if (Auth::id() === null) {
//            $request->session()->flash('info', 'Musisz być zalogowany by stworzyć studio!');
//            return redirect()->route('DevStudiosIndex');
//        }

        if ($request->ajax()) {
            return response()->json([
                'auth' => Auth::check()
            ]);
        }

        $validation = $this->validation($request); // $validation var is not yet used

        $developmentStudio = new DevelopmentStudio([
            'name' => $request->post('name'),
            'address' => $request->post('address'),
            'description' => $request->post('description'),
            'website' => $request->post('website'),
            'email' => $request->post('email'),
            'commercial' => $request->post('commercial'),
            'specialization' => $request->post('specialization'),
        ]);

        $ownerId = $request->post('otherOwner') === 'true' ? null : Auth::id();
        $developmentStudio->owner_id = $ownerId;
        $developmentStudio->save();

        return redirect()->route('DevStudiosDetails', ['studio' => $developmentStudio->id]);
    }

    public function edit(DevelopmentStudio $studio, Request $request)
    {
//        if (Auth::id() !== $studio->owner_id) { //TODO: or admin, or one of the dev studio members
//            $request->session()->flash('info', 'Nie masz uprawnień');
//            return redirect()->route('DevStudiosDetails', ['studio' => $studio->id]);
//        }

        if ($request->ajax()) {
            return response()->json([
                'studio' => $studio->toArray(),
                'auth' => Auth::check()
            ]);
        }

        $validation = $this->validation($request); // $validation var is not yet used

        $studio->update([
            'name' => $request->post('name'),
            'address' => $request->post('address'),
            'description' => $request->post('description'),
            'website' => $request->post('website'),
            'email' => $request->post('email'),
            'commercial' => $request->post('commercial'),
            'specialization' => $request->post('specialization'),
        ]);

        $newOwner = $request->post('newOwner');
        if ($newOwner !== '' && $newOwner !== null && (int)$newOwner !== Auth::id()) {
            $studio->author_id = $newOwner;
        }

        $studio->save();

        return redirect()->route('DevStudiosDetails', ['studio' => $studio->id]);
    }

    public function destroy(DevelopmentStudio $studio, Request $request)
    {
//        if (Auth::id() !== $studio->owner_id) { //TODO: or admin
//            $request->session()->flash('info', 'Nie masz uprawnień');
//            return redirect()->route('DevStudiosDetails', ['studio' => $studio->id]);
//        }

        if (!$request->ajax()) {
            return false; // should never happen, if it does, show a warning
        }

        if ($studio->delete()) {
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }

    public function addMember(DevelopmentStudio $studio, User $user, Request $request)
    {
//        if (Auth::id() !== $studio->owner_id) { //TODO: or admin
//            return response()->json([
//                'status' => false
//            ]);
//        }
        $studio->authors()->attach($user->id);
        return response()->json([
            'status' => true
        ]);
    }

    public function deleteMember(DevelopmentStudio $studio, User $user, Request $request)
    {
//        if (Auth::id() !== $studio->owner_id || Auth::id() !== $user->id) { //TODO: or admin
//            return response()->json([
//                'status' => false
//            ]);
//        }
        $studio->authors()->detach($user->id);
        return response()->json([
            'status' => true
        ]);
    }

    private function validation(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'string|max:500',
            'description' => 'string|max:1000',
            'website' => 'url',
            'email' => 'email',
            'commercial' => 'boolean|required',
            'specialization' => 'integer|required|in:0,1,2'
        ]);
    }
}
