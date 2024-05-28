@extends('layouts.admin')
@section('content')
    <h1>Edit Project</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $project->title }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image"
                placeholder='insert a link for your image'>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type">
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @if ($project->type_id == $type->id) selected @endif>
                        {{ $type->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Technologies</label>
            @foreach ($technologies as $technology)
                <div class="form-check checkboxes">
                    <input class="form-check-input" type="checkbox" value="{{ $technology->id }}"
                        id="tech{{ $technology->id }}" name="technologies[]">
                    <label class="form-check-label" for="tech{{ $technology->id }}">
                        {{ $technology->title }}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
