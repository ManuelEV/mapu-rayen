<!doctype html>
<html>
<head>
    <title>Item</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/template.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Bitter' rel='stylesheet'>
    <style>
        body {
            font-family: 'Bitter';
        }


    </style>
</head>

<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#dashboard_items">Items</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#categories_enterprises">Categories/enterprises</a>
        </li>
    </ul>
</nav>


<div id="app">


    <!--<item-component :ruta="ruta"></item-component>-->


    <div class="container-fluid" style="background: #c69800" id="dashboard_items">
        <br><br><br><br>
        <div class="row">
            <div class="col-sm-3 col-md-6 col-lg-4 col-xl-2">

                <div class="jumbotron" style="background: #0d2a33; color: #ffffff">
                    <!-- ;text-shadow: 2px 2px 4px #000000">-->
                    <h1 style="font-family: 'Anton';font-size: 37px">ALVEARE</h1>
                    <br>
                    <h1><i style="color: white" class="material-icons">group_work</i></h1>
                    <br>
                    <h3>Módulo de inventario</h3>
                </div>

            </div>


            <div class="col-sm-9 col-md-6 col-lg-8 col-xl-10">

                <item-component :ruta="ruta"></item-component>

                <br><br><br><br>

                <br><br>

            </div>


        </div>
    </div>
    <div class="container-fluid" style="background: #965001" id="categories_enterprises">
        <br><br><br><br>
        <div class="row">
            <div class="col" style="color: #f3f4f2">
                <b>ACA VA OTRO COMPONENT, SE SUPONE
                    <br>
                    ¿Enterprise component?</b>
            </div>
            <div class="col">
                <category-component :ruta="ruta"></category-component>
            </div>
        </div>
    </div>

    <!-- <div class="container-fluid" style="background: #DF744A" id="footer">
        <br><br><br><br>
        <div class="row">
            <div class="col" style="color: white;text-shadow: 2px 2px 4px #000000">
                BLA
                <br>
                BLA
            </div>
            <div class="col">

            </div>
        </div>
        <br><br><br><br>
    </div> -->


</div>


<script src="js/app.js"></script>
<script src="js/template.js"></script>

</body>
</html>
