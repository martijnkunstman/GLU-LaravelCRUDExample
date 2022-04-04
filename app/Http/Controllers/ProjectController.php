<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::latest()->paginate(5);

        return view('projects.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            //'image_path' => 'required',
            //'active' => 'required',
        ]);

        //Project::create($request->all());

        $project = new Project;
        if ($request->file()) {
            $project->name = $request->name;
            $project->desc = $request->desc;

            if ($request->active == NULL) {
                $request->merge([
                    'active' => 0,
                ]);
            } 
            else
            {
                $project->active = 1;
            }
            
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('public', $fileName);
            $project->image_name = $request->file->getClientOriginalName();
            $project->image_path = $fileName;
            $project->save();
        }

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            //'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            //'active' => 'required',
        ]);

        if ($request->active == NULL) {
            $request->merge([
                'active' => 0,
            ]);
        }   

        

        $project->name = $request->name;
        $project->desc = $request->desc;
        $project->active = $request->active;
        if ($request->file()) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('public', $fileName);
            $project->image_name = $request->file->getClientOriginalName();
            $project->image_path = $fileName;
          }

          $project->save();

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }
}
