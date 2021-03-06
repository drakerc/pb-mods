<?php

namespace App\Http\Controllers;

use App\DevelopmentStudio;
use App\User;
use Carbon\Carbon;
use DB;
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
        $studios = DB::table('development_studios');

        $filters = json_decode($request->filters, true);

        if ($filters !== null) {
            foreach ($filters as $key => $value) {
                if ($value !== null) {
                    $studios->where($key, $value);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(
                [
                    'studios' => $studios->paginate(5),
                    'auth' => Auth::check()
                ]);
        }
        return response()->json(
            [
                'message' => 'Invalid request.'
            ], 400);
    }

    /**
     * Returns the details of a selected development studio
     * @param DevelopmentStudio $studio
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function details(DevelopmentStudio $studio, Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'studio' => $studio->toArray(),
            ]);
        }
        return false;
    }

    /**
     * Returns mods developed by a selected development studio
     * @param DevelopmentStudio $studio
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function mods(DevelopmentStudio $studio, Request $request)
    {
        $mods = $studio->modifications()->paginate(10);

        if ($request->ajax()) {
            return response()->json(
                [
                    'studio' => $studio->toArray(),
                    'mods' => $mods,
                ]);
        }
        return false;
    }

    /**
     * Returns games developed by a selected development studio
     * @param DevelopmentStudio $studio
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function games(DevelopmentStudio $studio, Request $request)
    {
        $games = $studio->games()->paginate(10);

        if ($request->ajax()) {
            return response()->json(
                [
                    'studio' => $studio->toArray(),
                    'games' => $games,
                ]);
        }
        return false;
    }

    /**
     * Used to create a new development studio. If request is POST, it creates a new studio with POST parameters:
     * name, address, description, website, email, commercial, specialization.
     * If it's GET, it returns the auth info.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function create(Request $request)
    {
        if ($request->method() === 'GET') {
            return response()->json([
                'auth' => Auth::check()
            ]);
        }
        if ($request->method() !== 'POST') {
            return response()->json([
                    'status' => false,
                    'message' => 'Tylko POST albo GET.'
                ], 405
            );
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

        $user = $request->user();
        $developmentStudio->users()->attach($user);

        return redirect()->route('DevStudiosDetails', ['studio' => $developmentStudio->id]);
    }

    /**
     * Used to edit a selected development studio. If request is PUT, it edits the studio with PUT parameters:
     * name, address, description, website, email, commercial, specialization.
     * You can supply a newOwner parameter that changes the studio's owner's ID
     * If it's GET, it returns the auth info and studio details.
     * @param DevelopmentStudio $studio
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function edit(DevelopmentStudio $studio, Request $request)
    {
        if (Auth::id() !== $studio->owner_id) {
            return response()->json([
                    'message' => 'Nie masz uprawnień.'
                ], 403
            );
        }

        if ($request->method() === 'GET') {
            return response()->json([
                'studio' => $studio->toArray(),
                'auth' => Auth::check()
            ]);
        }
        if ($request->method() !== 'PUT') {
            return 'Error. This request can be either PUT or GET!';
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

        return response()->json([
            'status' => true,
            'id' => $studio->id,
        ]);
    }

    /**
     * Returns development studios of selected user
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userStudios(User $user, Request $request)
    {
        return response()->json([
            'studios' => $user->studios()->get()->toArray(),
            'auth' => Auth::check()
        ]);
    }

    /**
     * Hard-deletes a selected development studio
     * @param DevelopmentStudio $studio
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DevelopmentStudio $studio, Request $request)
    {
        if (Auth::id() !== $studio->owner_id) {
            return response()->json([
                'message' => 'Nie masz uprawnień.'
            ], 403
            );
        }

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

    /**
     * Adds a selected user to selected dev studio's members list
     * @param DevelopmentStudio $studio
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMember(DevelopmentStudio $studio, Request $request)
    {
        if (Auth::id() !== $studio->owner_id) {
            return response()->json([
                    'message' => 'Nie masz uprawnień.'
                ], 403
            );
        }

        $studio->users()->attach(User::findOrFail($request->user));
        return response()->json($studio->users()->get());
    }

    /**
     * Removes selected user from selected studio's members list
     * @param DevelopmentStudio $studio
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMember(DevelopmentStudio $studio, Request $request)
    {
        if (Auth::id() !== $studio->owner_id) {
            return response()->json([
                    'message' => 'Nie masz uprawnień.'
                ], 403
            );
        }

        $request->validate([
           'user_id' => 'required|integer'
        ]);

        $studio->users()->detach($request->user_id);
        return response()->json($studio->users()->get());
    }

    /**
     * Find Development Studio by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function findById(Request $request, $id)
    {
        return response()->json(DevelopmentStudio::with(['games.logo', 'users', 'modifications:id,title,description', 'jobOffers' => function($query) {
            $query->whereDate('valid_until', '>=', Carbon::now());
        }])->findOrFail($id));
    }

    public function myStudios(Request $request)
    {
        $user = $request->user();
        return response()->json($user->studios()->get());
    }

    private function validation(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'string|max:500',
            'description' => 'string|max:1000',
            'website' => 'required|url',
            'email' => 'required|email',
            'commercial' => 'boolean|required',
            'specialization' => 'integer|required|in:0,1,2'
        ]);
    }
}
