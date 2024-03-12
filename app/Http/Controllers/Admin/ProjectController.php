<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

// Form Requests
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
// Helpers
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();

        $coverImgPath = null;
        if (isset($validatedData['cover_img'])) {
            $coverImgPath = Storage::disk('public')->put('images', $validatedData['cover_img']);
        }

        $project = new Project($validatedData);
        $project->title = $validatedData["title"];
        $project->slug = Str::slug($validatedData["title"]);
        $project->content = $validatedData["content"];
        $project->type_id = $validatedData["type_id"];
        $project->cover_img = $coverImgPath;

        $project->save();

        if (isset($validatedData['technologies'])) {
            foreach ($validatedData['technologies'] as $single_technology_id) {
                // attach this technology_id to this project
                $project->technologies()->attach($single_technology_id);
            }
        }
        ;

        return redirect()->route('admin.projects.show', ['project' => $project->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'technologies', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $project = Project::where("id", $id)->firstOrFail();

        $coverImgPath = $project->cover_img;
        if (isset($validatedData['cover_img'])) {
            if ($project->cover_img != null) {
                Storage::disk('public')->delete($project->cover_img);
            }

            $coverImgPath = Storage::disk('public')->put('images', $validatedData['cover_img']);
        }
        else if (isset($validatedData['delete_cover_img'])) {
            Storage::disk('public')->delete($project->cover_img);

            $coverImgPath = null;
        }
        $project->title = $validatedData["title"];
        $project->slug = Str::slug($validatedData["title"]);
        $project->content = $validatedData["content"];
        $project->type_id = $validatedData["type_id"];
        $project->cover_img = $coverImgPath;

        $project->save();

        if (isset($validatedData['technologies'])) {
            $project->technologies()->sync($validatedData['technologies']);
        } else {
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.show', ['project' => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }
}
