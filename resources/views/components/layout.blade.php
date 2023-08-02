<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SWR Dash</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Setting</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Incomes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/income">Income</a></li>
                        <li><a class="dropdown-item" href="/expense">Expense</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/income">Show all</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex" role="search" method="get" action="/income">
                <input value="{{request()->get('search')}}" class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    {{ $slot ?? '' }}
</div>


<script async>
setTimeout(() => {

    Livewire.directive('confirm', ({ el, directive, component, cleanup }) => {
        let content =  directive.expression

        // The "directive" object gives you access to the parsed directive.
        // For example, here are its values for: wire:click.prevent="deletePost(1)"
        //
        // directive.raw = wire:click.prevent
        // directive.value = "click"
        // directive.modifiers = ['prevent']
        // directive.expression = "deletePost(1)"

        let onClick = e => {
            if (! confirm(content)) {
                e.preventDefault()
                e.stopPropagation()
            }
        }

        el.addEventListener('click', onClick, { capture: true })

        // Register any cleanup code inside `cleanup()` in the case
        // where a Livewire component is removed from the DOM while
        // the page is still active.
        cleanup(() => {
            el.removeEventListener('click', onClick)
        })
    })
})

</script>


</body>

</html>
