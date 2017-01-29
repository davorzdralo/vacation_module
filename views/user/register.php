<div class="signin-form">
    <div class="container">
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Sign up.</h2><hr />
            <?php
            if(isset($error))
            {

                ?>
                <div class="alert alert-danger">
                    <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                </div>
                <?php

            }
            else if(isset($_GET['joined']))
            {
                ?>
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                </div>
                <?php
            }
            ?>

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Enter Username" value="<?php if(isset($error)){echo $username;}?>" />
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password" />
            </div>

            <div class="clearfix"></div><hr />

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="btn-signup">
                    <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ! <a href="?controller=user&action=login">Sign In</a></label>
        </form>
    </div>
</div>