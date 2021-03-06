<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal modyfikacji</title>
    <script type="text/javascript">
        window.mods_model = "{!! addslashes(isset($model) ? json_encode($model) : []) !!}"
        window.csrf_token = "{{ csrf_token() }}"
        window.user_id = "{{ Auth::id() }}"
    </script>
</head>
<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('info'))
    <p class="alert">{!! Session::get('info') !!} </p>
@endif
<div id="app"></div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>