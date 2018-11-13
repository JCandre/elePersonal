<li><p class="navbar-text">Need or already have an account?</p></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login/Register</b> <span class="caret"></span></a>
    <ul id="login-dp" class="dropdown-menu">
        <li>
            <div class="row">
                <div class="col-md-12">
                    Login
                    <form class="form" role="form" method="post" action="core/functions/loginProc.php"
                          accept-charset="UTF-8" id="login-nav">
                        <div class="form-group">
                            <label class="sr-only" for="InputUsername">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="InputPassword">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <div class="help-block text-right"><a href="Recover.php?mode=username">Forget the username
                                    ?</a></div>
                            <div class="help-block text-right"><a href="Recover.php?mode=password">Forget the password
                                    ?</a></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        </div>
                    </form>
                </div>
                <div class="bottom text-center">
                    New to <strong>elePersonal?</strong> <a href="Register.php"><b>Register</b></a>
                </div>
            </div>
        </li>
    </ul>
</li>