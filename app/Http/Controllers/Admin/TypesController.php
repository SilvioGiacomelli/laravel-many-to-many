<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Functions\Helper as Help;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
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
        $exists = Type::where('title', $request->title)->first();
        if ($exists) {
            return redirect()->route('admin.types.index')->with('error', 'Type already exists');
        } else {
            $type = new Type();
            $type->title = $request->title;

            $type->slug = Help::generateSlug($type->title, Type::class);
            $type->save();
            return redirect()->route('admin.types.index')->with('success', 'Type created');
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
    public function update(Request $request, Type $type)
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
        $exists = Type::where('title', $request->title)->first();
        if ($exists) {
            return redirect()->route('admin.types.index')->with('error', 'Type already exists');
        } else {
            $data['slug'] = Help::generateSlug($type->title, Type::class);
            $type->update($data);
            return redirect()->route('admin.types.index')->with('success', 'Type modified');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = Type::find($id);
        if ($type) {
            $type->delete();
            return redirect()->route('admin.types.index')->with('success', 'Type deleted successfully');
        } else {
            return redirect()->route('admin.types.index')->with('error', 'Type not found');
        }
    }
}
