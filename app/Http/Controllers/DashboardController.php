<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $data = History::orderBy('id','desc')
            ->paginate(10);
        return view('dashboard', [
            'title' => 'dashboard',
            'data' => $data
        ]);
    }
}
