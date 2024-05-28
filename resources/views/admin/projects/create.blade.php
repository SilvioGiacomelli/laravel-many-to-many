@extends('layouts.admin')
@section('content')
    <h1>Create Project</h1>
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
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image"
                placeholder='insert a link for your image'>
        </div>
        {{-- <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type">
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">
                        {{ $type->title }}
                    </option>
                @endforeach
            </select>
        </div> --}}
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
