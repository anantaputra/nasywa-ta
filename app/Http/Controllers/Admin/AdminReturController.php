<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Retur;
use Illuminate\Http\Request;

class AdminReturController extends Controller
{
    public function index()
    {
        $retur = Retur::all();

        return view('admin.retur.index', compact('retur'));
    }
}
