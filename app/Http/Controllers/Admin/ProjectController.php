<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

// Form Requests
use App\Http\Requests\StoreProjectRequest;

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
        $validated_data = $request->validated();

        $project = new Project($validated_data);
        $project->title = $validated_data["title"];
        $project->slug = Str::slug($validated_data["title"]);
        $project->content = $validated_data["content"];
        $project->type_id = $validated_data["type_id"];

        $project->save();

        if (isset($validated_data['technologies'])) {
            foreach ($validated_data['technologies'] as $single_technology_id) {
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
    public function update(Request $request, Project $project)
    {
        $projectData = $request->all();
        $slug = Str::slug($projectData['title']);
        $project->update([
            'title' => $projectData['title'],
            'slug' => $slug,
            'content' => $projectData['content'],
            'type_id' => $projectData['type_id'],
        ]);

        if (isset($projectData['technologies'])) {
            $project->technologies()->sync($projectData['technologies']);
        }
        else {
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.show', compact('project'));
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
