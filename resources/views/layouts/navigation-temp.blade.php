    <div class="navbar-backdrop">
        <div class="navbar">
            <div class="navbar-left">
                <a class="navbar-toggle"><i class="fa fa-bars"></i></a>
                <!--<a href="index.html" class="logo"><img src="img/logo.png" alt="Gameforest - Game Theme HTML"></a>-->
                {{ env('APP_NAME', 'PrOjEcT') }}
            </div>
            <div class="nav navbar-right">
                <ul>
                    <li class="hidden-xs-down"><a href="login.html">Login</a></li>
                    <li class="hidden-xs-down"><a href="register.html">Register</a></li>
                    <li><a data-toggle="search"><i class="fa fa-search"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
