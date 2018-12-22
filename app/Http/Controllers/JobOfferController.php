<?php

namespace App\Http\Controllers;

use App\DevelopmentStudio;
use App\JobOffer;
use App\Mail\JobOfferSent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_offers = JobOffer::with(['developmentStudio'])->whereDate('valid_until', '>=', Carbon::now())
            ->orderBy('created_at', 'desc')->limit(10)->get();
        return response()->json($job_offers);
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
            'development_studio_id' => 'required',
            'title' => 'required|min:3|max:64',
            'body' => 'required|min:3',
            'email' => 'required|min:5',
            'valid_until' => 'required|date'
        ]);

        $user = $request->user();
        $development_studio = DevelopmentStudio::findOrFail($request->development_studio_id);
        $result = $development_studio->users()->where('user_id', '=', $user)->get();
        if (sizeof($result) > 0 || $development_studio->owner_id === $user->id) {
            $job_offer = new JobOffer([
                'development_studio_id' => $request->development_studio_id,
                'title' => $request->title,
                'body' => $request->body,
                'email' => $request->email,
                'valid_until' => $request->valid_until
            ]);

            $job_offer->save();
            return response()->json($job_offer, 200);
        }

        return response()->json([
            'message' => 'Not authorized'
        ], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job_offer = JobOffer::with(['developmentStudio'])->findOrFail($id);
        Log::info($job_offer->isValid);
        if ($job_offer->isValid) {
            return response()->json($job_offer);
        }
        return response()->json([
            'message' => 'This offer is no longer available, sorry!'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
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
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Sends email about applying for a job offer
     * @param $id
     * @param Request $request
     */
    public function emailApply(Request $request, $id)
    {
        $job_offer = JobOffer::with('developmentStudio')->findOrFail($id);
        $development_studio = $job_offer->developmentStudio;
        $user = $request->user();
        $result = $development_studio->users()->where('user_id', '=', $user->id)->get();
        Log::info($result);
        if (sizeof($result) > 0) {
            Log::warning('Result is not null');
            return response()->json([
                'message' => 'You cannot send a job offer if you already are in this studio!'
            ], 400);
        }

        Mail::to(env('MAIL_TO_ADDRESS', $job_offer->email))
            // if MAIL_TO_ADDRESS env value is set, all emails will be sent there
            ->send(new JobOfferSent($user, $development_studio, $job_offer, $request->file));

        return response()->json([
            'message' => 'email sent successfully!'
        ]);
    }
}
