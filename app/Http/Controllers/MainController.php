<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function messenger(Request $request): View
    {
        return view('messenger', ['user' => User::findOrFail($request->route('id'))]);
    }
}
