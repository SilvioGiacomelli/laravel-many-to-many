@extends('layouts.admin')
@section('content')
    <h1>Types</h1>
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
    <form class="d-flex" role="input" action="{{ route('admin.types.store') }}" method="POST">
        @csrf
        <input class="form-control me-2" name="title" type="input" placeholder="New Type" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Send</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr scope="row">

                    <td>
                        <form action="{{ route('admin.types.update', $type) }}" method="POST"
                            id="form-types-{{ $type->id }}">
                            @csrf
                            @method('PUT')
                            <input type="text" value="{{ $type->title }}" name="title">
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-warning" onclick="submitForm({{ $type->id }})"
                            type="submit">Edit</button>
                        <form action="{{ route('admin.types.destroy', $type->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        function submitForm(id) {
            const form = document.getElementById(`form-types-${id}`);
            form.submit();
        }
    </script>
@endsection
