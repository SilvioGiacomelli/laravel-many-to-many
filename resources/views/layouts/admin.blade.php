<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js'])
    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Laravel Boolfolio</title>
</head>

<body>
    @include('admin.partials.header')
    <div class="main-wrapper">
        <aside>
            <nav>
                <ul>
                    <li>
                        <i class="fa-solid fa-diagram-project"></i><a
                            href="{{ route('admin.projects.index') }}">Projects</a>
                        <ul class="dropdown">
                            <li id="new-project"><a href="{{ route('admin.projects.create') }}"><i
                                        class="fa-solid fa-plus"></i>New
                                    Project</a></li>
                        </ul>
                    </li>
                    <li>
                        <i class="fa-solid fa-hurricane"></i><a href="{{ route('admin.types.index') }}">Types</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-microchip"></i><a
                            href="{{ route('admin.technologies.index') }}">Technologies</a>
                    </li>
                </ul>
        </aside>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>

</html>
