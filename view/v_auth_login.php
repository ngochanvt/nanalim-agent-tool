<?php //echo md5('uyen12345678');?>
<div class="container login-form login-page">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="<?=$glb_config['baseurl']?>action/a_auth.php" method="POST">
                        <div class="form-group row">
                            <label for="email_address" class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                                <input type="text" id="email_address" class="form-control" name="username" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4 text-right">
                            <button type="submit" name="login" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>