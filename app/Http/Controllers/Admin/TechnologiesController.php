<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Technology;
use App\Functions\Helper as Help;

class TechnologiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technologies = Technology::all();
        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exists = Technology::where('title', $request->title)->first();
        if ($exists) {
            return redirect()->route('admin.technologies.index')->with('error', 'Technology already exists');
        } else {
            $technology = new Technology();
            $technology->title = $request->title;
            $technology->slug = Help::generateSlug($technology->title, Technology::class);
            $technology->save();
            return redirect()->route('admin.technologies.index')->with('success', 'Technology created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        $data = $request->validate(
            [
                'title' => 'required|string',
            ],
            [
                'title.required' => 'Title is required',
                'title.string' => 'Title must be a string',
            ]
        );
        $exists = Technology::where('title', $request->title)->first();
        if ($exists) {
            return redirect()->route('admin.technologies.index')->with('error', 'Technology already exists');
        } else {
            $data['slug'] = Help::generateSlug($technology->title, Technology::class);
            $technology->update($data);
            return redirect()->route('admin.technologies.index')->with('success', 'Technology modified');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $technology = Technology::find($id);
        if ($technology) {
            $technology->delete();
            return redirect()->route('admin.technologies.index')->with('success', 'Technology deleted successfully');
        } else {
            return redirect()->route('admin.technologies.index')->with('error', 'Technology not found');
        }
    }
}
