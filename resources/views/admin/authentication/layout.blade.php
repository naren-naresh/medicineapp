<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Medicine Plus</title>
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
    <!--Font Awsome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <!--Jquery-->
     <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    {{-- styles --}}
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
           background-color: whitesmoke;
        }
        #container{
            margin-top: 5rem;
            width: 400px;
            border-radius: 7px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }
        #logo{
            width: 200px;
        }
        .error{
            color:red;
        }
    </style>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center mh-100 bg-white" id="container">
        {{-- app logo --}}
    <div class="logo pt-5 pb-3">
        <img src="assets/images/logo.png" alt="logo image" id="logo">
    </div>
        @yield('content')
    </div>
    <!-- Bootstrap JS-->
   <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js')}}"></script>
    <!-- JQuery Validation-->
   <script src="{{ asset("assets/plugins/jqueryvalidation.js")}}"></script>
</body>

</html>
