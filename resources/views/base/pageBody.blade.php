<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Sales</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap for styling -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Vue 2 -->
    <script src="{{asset('/js/vue.js')}}"></script>
    {{--    axios--}}
    <script src="{{asset('/js/axios.min.js')}}"></script>

</head>
<body>
@yield('body')
</body>
</html>
