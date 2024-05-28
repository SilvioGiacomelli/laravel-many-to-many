@extends('layouts.admin')
@section('content')
    <h1>Projects</h1>
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
    <form class="d-flex" method='GET' role="search" action="{{ route('admin.projects.index') }}">
        <input class="form-control me-2" name="toSearch" type="search" placeholder="Search Project" aria-label="Search">
        <button class="btn btn-outline-success" type="search">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col"><a
                        href="{{ route('admin.projects.order', ['direction' => $direction, 'column' => 'title']) }}">Title</a>
                </th>
                <th scope="col">Type</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr scope="row">
                    <td>
                        <form action="{{ route('admin.projects.update', $project) }}" method="POST"
                            id="form-projects-{{ $project->id }}">
                            @csrf
                            @method('PUT')
                            <input type="text" value="{{ $project->title }}" name="title">
                        </form>
                    </td>
                    <td>
                        {{ $project->type?->title }}
                    </td>
                    <td>
                        @if ($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->image }}"
                                width="100">
                        @else
                            No image
                        @endif
                    </td>
                    <td>
                        {{-- <button class="btn btn-warning" onclick="submitForm({{ $project->id }})" type="submit">Edit
                        </button> --}}
                        <a href="{{ route('admin.projects.edit', $project->id) }}">
                            <div class="btn btn-warning"><i class="fa-solid fa-pen-nib"></i></div>
                        </a>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <script>
        function submitForm(id) {
            const form = document.getElementById(`form-projects-${id}`);
            form.submit();
        }
    </script> --}}
@endsection
