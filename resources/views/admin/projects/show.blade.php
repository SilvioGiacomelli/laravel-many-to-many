@extends('layouts.admin')
@section('content')
    <h1>{{ $project->title }}</h1>
    <div class="card" style="width: 18rem;">
        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->image }}">
        <div class="card-body">
            @if ($project->technologies)
                <p>Technlogies:
                    @foreach ($project->technologies as $technology)
                        <span class="badge bg-warning">{{ $technology->title }}</span>
                    @endforeach
                </p>
            @endif
            {{-- <p class="card-text">{{ $project->type->title }}</p> --}}
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    @endsection
