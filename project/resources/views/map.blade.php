<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #osm_map {
            position: absolute;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>

<div id="app">
    <div id="osm_map"></div>
</div>

<script src="{{ asset('js/app.js') }}" ></script>

<script type="text/javascript">
    window.my_map.display();
</script>

</body>
</html>