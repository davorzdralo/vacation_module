<a href="?controller=vacation&action=request">Request vacation</a>
<a href="?controller=vacation&action=history">Vacation history</a>
<a href="?controller=user&action=logout">Logout</a>

<div class="container">
    <form id="login-form" method="post" action="index.php?controller=vacation&action=request">

        <div id="error">
            <?php
            if(isset($error))
            {
                ?>
                <div class="alert alert-danger">
                    <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="form-group">
            <input type="date" class="form-control" name="start" placeholder="Start Date" required />
        </div>

        <div class="form-group">
            <input type="date" class="form-control" name="end" placeholder="End Date" required />
        </div>

        <hr />

        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-default">
                <i class="glyphicon glyphicon-plus-sign"></i> &nbsp; Submit Request
            </button>
        </div>

    </form>
</div>