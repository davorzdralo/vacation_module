<div class="container">

    <div class="panel panel-default">
        <div class="panel-body">
            Remaining vacation days: <?php echo $remainingDays; ?>
        </div>
    </div>


    <form id="login-form" method="post" action="index.php?controller=vacation&action=request">

        <div class="row">
            <div class="form-group col-md-6">
                <label for="start">Start date</label>
                <input type="date" class="form-control" id="start" name="start" required>
            </div>

            <div class="form-group col-md-6">
                <label for="end">End date</label>
                <input type="date" class="form-control" id="end" name="end" required>
            </div>
        </div>

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

        <hr />

        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-default pull-right">
                <i class="glyphicon glyphicon-plus-sign"></i> &nbsp; Submit Request
            </button>
        </div>

    </form>
</div>