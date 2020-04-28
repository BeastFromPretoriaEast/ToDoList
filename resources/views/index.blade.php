<!DOCTYPE html>
<html lang="en-us" ng-app="myApp">
<head>
    <title>Learn and Understand AngularJS</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta charset="UTF-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- load bootstrap and fontawesome via CDN -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <style>
        .mr-1 {
            margin-right: 3px;
        }
        .navbar {
            margin-bottom: 5px;
        }
    </style>

    <!-- load angular via CDN -->
    <script src="//code.angularjs.org/1.3.0-rc.1/angular.min.js"></script>
    <script src="//code.angularjs.org/1.3.0-rc.1/angular-route.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</head>
<body>

<header>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Welcome <span class="text-info" id="userLoggedInName">{{ Auth::user()->name }}</span></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <a class="btn btn-default navbar-btn" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </nav>
</header>

<div class="container">

    <div ng-controller="mainController">
        <div style="height: 45px; display: inline-block;">
            <img src="{{ asset('images/person.jpg') }}" class="img-circle img-responsive mr-1" alt="Profile Picture" style="height: 45px; margin-top: 10px; margin-right: 10px;">
        </div>

        <div style="height: 45px; display: inline-block;">
            <h1 class="d-inline-block">
                To do list
            </h1>
        </div>

        <div class="pull-right" style="height: 45px; display: inline-block; margin-top: 22px;">
            <a href="#/profile" class="btn btn-default btn-outline-primary"><i class="glyphicon glyphicon-user mr-1"></i> Profile Settings</a>
        </div>

        <hr>

        <div ng-view></div>

    </div>

</div>


</body>
</html>
