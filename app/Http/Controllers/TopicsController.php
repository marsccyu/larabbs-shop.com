<?php

namespace App\Http\Controllers;

use App\Models\Topics;
use App\Models\User;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $topics = $user->topics()->get();

        return $topics;
    }
}
