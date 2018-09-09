<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modification;

class modificationController extends Controller
{
    public function getModificationApi(Modification $modification)
    {
        return response()->json($modification->toArray());
    }

    public function getModificationWeb(Modification $modification)
    {
        return view('start', ['model' => $modification->toArray()]);
    }
}
