<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Functions\Helper as Help;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Technology;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (isset($_GET['toSearch'])) {
            $projects = Project::where('title', 'like', '%' . $_GET['toSearch'] . '%')->get();
        } else {
            $projects = Project::all();
        }

        $direction = 'desc';

        return view('admin.projects.index', compact('projects', 'direction'));
    }

    public function order($direction, $column)
    {
        $direction = $direction === 'desc' ? 'asc' : 'desc';
        $projects = Project::orderBy($column, $direction)->get();
        return view('admin.projects.index', compact('projects', 'direction'));
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
    public function store(Request $request)
    {
        // Validazione dei dati in ingresso
        $validatedData = $request->validate(
            [
                'title' => 'required|string',
                'image' => 'sometimes|image',
                'technologies' => 'array',
                'technologies.*' => 'exists:technologies,id',
                //scrivo exists:technologies,id perchè sto validando un array di tecnologie
            ],
            [
                'title.required' => 'Title is required',
                'title.string' => 'Title must be a string',
                'image.image' => 'Uploaded file must be an image',
                'type.required' => 'Type is required',
                'type.exists' => 'Selected type is invalid',
                'technologies.array' => 'Technologies must be an array',
                'technologies.*.exists' => 'Selected technology is invalid',
                //scrivo technologies.* perchè sto validando un array di tecnologie
            ]
        );

        // Verifica se un progetto con lo stesso titolo esiste già
        $exists = Project::where('title', $request->title)->first();
        if ($exists) {
            return redirect()->route('admin.projects.index')->with('error', 'Project already exists');
        }

        // Inizializzazione dell'array dei dati
        $data = $validatedData;

        // Gestione dell'upload dell'immagine se presente
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads');
            $data['image'] = $path;
        }

        // Creazione del nuovo progetto
        $project = new Project();
        $project->title = $request->title;
        $project->type_id = $request->type;
        $project->slug = Help::generateSlug($project->title, Project::class);
        $project->image = $data['image'] ?? null;
        $project->save();

        // Associa le tecnologie selezionate al progetto
        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created');
    }


    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project = Project::find($project->id);
        if ($project) {
            return view('admin.projects.show', compact('project'));
        } else {
            return redirect()->route('admin.projects.index')->with('error', 'Project not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Validazione dei dati in ingresso
        $validatedData = $request->validate(
            [
                'title' => 'required|string',
                'image' => 'sometimes|image',
                'technologies' => 'array',
                'technologies.*' => 'exists:technologies,id',
            ],
            [
                'title.required' => 'Title is required',
                'title.string' => 'Title must be a string',
                'image.image' => 'Uploaded file must be an image',
                'type.required' => 'Type is required',
                'type.exists' => 'Selected type is invalid',
                'technologies.array' => 'Technologies must be an array',
                'technologies.*.exists' => 'Selected technology is invalid',
            ]
        );

        // Verifica se un altro progetto con lo stesso titolo esiste già
        $exists = Project::where('title', $request->title)->where('id', '!=', $project->id)->first(); //!= vuole dire diverso da
        if ($exists) {
            return redirect()->route('admin.projects.index')->with('error', 'Project already exists');
        }

        // Inizializzazione dell'array dei dati
        $data = $validatedData;

        // Gestione dell'upload dell'immagine se presente
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads');
            $data['image'] = $path;
        }

        // Generazione dello slug
        $data['slug'] = Help::generateSlug($request->title, Project::class);

        // Aggiornamento dei dati del progetto
        $project->update($data);


        // Associa le tecnologie selezionate al progetto
        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        } else {
            $project->technologies()->sync([]); // Rimuove tutte le associazioni se nessuna tecnologia è selezionata
        }


        return redirect()->route('admin.projects.index')->with('success', 'Project modified');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
        if ($project) {
            $project->delete();
            return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
        } else {
            return redirect()->route('admin.projects.index')->with('error', 'Project not found');
        }
    }
}
