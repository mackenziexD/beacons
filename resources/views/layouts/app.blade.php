<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <meta property="og:description" content="The Beacons are lit, gondor calls of aid" />
    <meta property="og:site_name" content="BUSA Beacon Fuel Checker" />

    <!-- Styles -->
    <link href="https://bootswatch.com/5/darkly/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
</head>
<style>
.warning {
    background-color: #ffdd008f !important;
}
.danger{
    background-color: #ff3232 !important
}
.pink{
    background-color: #9400ff52 !important;
}
tr.even {
    background-color: #444444;
}
tr.even {
    background-color: #202020;
}
.bootstrap-tagsinput .tag {
    margin-right: 2px;
    color: white !important;
    background-color: #4137ce;
    padding: .2em .6em .3em;
    font-size: 100%;
    font-weight: 700;
    vertical-align: baseline;
    border-radius: .25em;
}
</style>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            @if (auth()->check())
                                <a class="nav-link" href="">{{auth()->user()->name}}</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <script>
        $(document).ready(function() {
            var table = $('#fuel').DataTable( {
                "oLanguage": {
                "sLengthMenu": "Show  _MENU_",
                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Show All"]],
                "order": [[ 3, "asc" ]]
            });

            // find any rows with text "OFFLINE"
            var row = table.rows( function ( idx, data, node ) {
                return data[3] === "OFFLINE" || data[3] === "OFFLINE **[INCURSION]**";
            } );
            row.nodes().to$().prependTo( '#fuel tbody' );
            row.nodes().to$().addClass( 'danger' );

            // every time table is redrawn, check for OFFLINE rows
            table.on( 'draw', function () {
                // find any rows with text "OFFLINE"
                var row = table.rows( function ( idx, data, node ) {
                    return data[3] === "OFFLINE" || data[3] === "OFFLINE **[INCURSION]**";
                } );
                row.nodes().to$().prependTo( '#fuel tbody' );
                row.nodes().to$().addClass( 'danger' );
            } );

        });
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>
