<div class="signin-form">
    <div class="container">
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Sign up for Vacation Planer</h2><hr />

            <?php if(isset($error)) { ?>
                <div class="alert alert-danger">
                    <i class="glyphicon glyphicon-remove"></i> &nbsp; <?php echo $error; ?>
                </div>
            <?php } ?>

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Enter Username" value="<?php if(isset($error)) { echo $username; } ?>" />
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password" />
            </div>

            <hr />

            <div class="form-group">
                <button type="submit" class="btn btn-default" name="btn-signup">
                    <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>You already have an account? <a href="?controller=user&action=login">Sign In</a></label>
        </form>
    </div>
</div>