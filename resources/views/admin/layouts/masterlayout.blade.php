<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Medicine Plus</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        /* Toggle Styles */
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .nav-pills>li>a {
            border-radius: 0;
        }

        #wrapper {
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
            overflow: hidden;
        }

        #wrapper.toggled {
            padding-left: 250px;
            overflow: hidden;
        }

        #sidebar-wrapper {
            z-index: 1000;
            position: absolute;
            left: 250px;
            width:0;
            height: 100%;
            margin-left: -250px;
            overflow-y: auto;
            background: #000;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
        #wrapper.toggled #sidebar-wrapper {
            width: 250px;
        }

        #page-content-wrapper {
            position: absolute;
            padding: 15px;
            width: 100%;
            overflow-x: hidden;
        }

        #wrapper.toggled #page-content-wrapper {
            position: relative;
            margin-right: 0px;
        }

        .fixed-brand {
            width: auto;
        }

        /* Sidebar Styles */

        .sidebar-nav {
            position: absolute;
            top: 0;
            width: 200px;
            margin: 0;
            padding: 0;
            list-style: none;
            margin-top: 2px;
        }

        .sidebar-nav li {
            text-indent: 15px;
            line-height: 40px;
        }

        .sidebar-nav li a {
            display: block;
            text-decoration: none;
            color: #999999;
            font-size: 14px;
        }

        .sidebar-nav li a:hover {
            text-decoration: none;
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
            border-left: red 2px solid;
        }

        .sidebar-nav li a:active,
        .sidebar-nav li a:focus {
            text-decoration: none;
        }

        .sidebar-nav>.sidebar-brand {
            height: 65px;
            font-size: 18px;
            line-height: 60px;
        }

        .sidebar-nav>.sidebar-brand a {
            color: #999999;
        }

        .sidebar-nav>.sidebar-brand a:hover {
            color: #fff;
            background: none;
        }

        .no-margin {
            margin: 0;
        }

        @media(min-width:768px) {
            #wrapper {
                padding-left: 250px;
            }

            #menu-toggle {
                display: none !important;
            }

            .fixed-brand {
                width: 250px;
            }

            #wrapper.toggled {
                padding-left: 0;
            }

            #sidebar-wrapper {
                width: 250px;
            }

            #wrapper.toggled #sidebar-wrapper {
                width: 250px;
            }

            #wrapper.toggled-2 #sidebar-wrapper {
                width: 50px;
            }

            #wrapper.toggled-2 #sidebar-wrapper:hover {
                width: 250px;
            }

            #page-content-wrapper {
                padding: 20px;
                position: relative;
                -webkit-transition: all 0.5s ease;
                -moz-transition: all 0.5s ease;
                -o-transition: all 0.5s ease;
                transition: all 0.5s ease;
            }

            #wrapper.toggled #page-content-wrapper {
                position: relative;
                margin-right: 0;
                padding-left: 250px;
            }

            #wrapper.toggled-2 #page-content-wrapper {
                position: relative;
                margin-right: 0;
                margin-left: -230px;
                -webkit-transition: all 0.5s ease;
                -moz-transition: all 0.5s ease;
                -o-transition: all 0.5s ease;
                transition: all 0.5s ease;
                width: auto;
            }
        }

        @media(max-width:768px) {
            #menu-toggle-2 {
                display: none;
            }
        }
        .main{
            display:flex;
        }
    </style>
</head>

<body>
    @include('admin.layouts.header')
    <div class="row m-0 main">
        <!-- /#sidebar-wrapper -->
        @include('admin.layouts.sidebar')
        <!-- Page Content -->
        <div id="page-content-wrapper" class="col-10">
            <div class="container-fluid">
                @yield('pagecontent')
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>
    <script src="{{ asset('assets/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        $("#menu-toggle-2").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled-2");
            $('#menu ul').hide();
        });

        function initMenu() {
            $('#menu ul').hide();
            $('#menu ul').children('.current').parent().show();
            //$('#menu ul:first').show();
            $('#menu li a').click(
                function() {
                    var checkElement = $(this).next();
                    if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                        return false;
                    }
                    if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                        $('#menu ul:visible').slideUp('normal');
                        checkElement.slideDown('normal');
                        return false;
                    }
                }
            );
        }
        $(document).ready(function() {
            initMenu();
        });
    </script>
</body>

</html>
