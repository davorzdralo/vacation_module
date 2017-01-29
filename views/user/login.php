<div class="signin-form">
    <div class="container">
        <form id="login-form" class="form-signin" method="post"
              action="index.php?controller=user&action=loginSubmit">

            <h2 class="form-signin-heading">Log in to Vacation Planer</h2><hr />

            <div id="error">
                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-remove"></i> &nbsp; <?php echo $error; ?>
                    </div>
                <?php } ?>
            </div>

            <div id="registered">
                <?php if(isset($registered)) { ?>
                    <div class="alert alert-success">
                        <i class="glyphicon glyphicon-ok"></i> &nbsp; <?php echo $registered; ?>
                    </div>
                    <?php } ?>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Your Username" required />
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Your Password" />
            </div>

            <hr />

            <div class="form-group">
                <button type="submit" class="btn btn-default">
                    <i class="glyphicon glyphicon-log-in"></i> &nbsp; SIGN IN
                </button>
            </div>
            <br />
            <label>Don't have account yet? <a href="?controller=user&action=register">Sign Up</a></label>
        </form>
    </div>
</div>