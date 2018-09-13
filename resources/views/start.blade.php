<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mods n stuff</title>
    <script type="text/javascript">
        window.mods_model = "{!! addslashes(json_encode($model)) !!}"
        window.csrf_token = "{{ csrf_token() }}"
    </script>
</head>
<body>
<div id="app"></div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>