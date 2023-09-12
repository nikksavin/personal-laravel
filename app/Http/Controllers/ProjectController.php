<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

// We will use Form Request to validate incoming requests from our store and update method
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;


class ProjectController extends Controller
{
    public function index(){

        return view('project.show', [
            'projects' => Project::all()
        ]);

    }
}
