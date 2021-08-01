<?php

namespace App\Http\Controllers;

use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentrifugoController extends Controller
{
    public function generateToken(Centrifugo $centrifugo): JsonResponse
    {
        return response()->json(['token' => $centrifugo->generateConnectionToken(Auth::user()->id)]);
    }
}
