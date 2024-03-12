<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Project;
class MainController extends Controller
{

    public function dashboard()
    {
        $projects = Project::all();
        return view('admin.dashboard', compact('projects'));
    }

}
