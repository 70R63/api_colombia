<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Laravel base -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>Colombia Digital</title>

    </head>



    <body class="main-body ">
        
        <!-- Main Content-->
        <div class="main-content side-content pt-0">
            <div class="container-fluid p-4">
                
                <div class="inner-body">
                    <!-- Page Content -->
                    @yield('content')
                    <!-- End Page Content -->
                </div>
            </div>
        </div>
        <!-- End Main Content-->

    </body>
       
</html>
