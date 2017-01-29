<a href="?controller=vacation&action=request">Approve vacation</a>
<a href="?controller=user&action=logout">Logout</a>


<div class="container">

    <table class="table table-striped">

        <thead>
        <tr>
            <th>ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>User</th>
            <th>Status</th>
            <th colspan="2">Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($vacations as $vacation) { ?>
            <tr>
                <td><?php echo $vacation->id; ?></td>
                <td><?php echo $vacation->start; ?></td>
                <td><?php echo $vacation->end; ?></td>
                <td><?php echo $vacation->user->username; ?></td>
                <td><?php echo $vacation->status; ?></td>
                <td><a href="?controller=vacation&action=approve&button=approved&id=<?php echo $vacation->id; ?>">approve</a></td>
                <td><a href="?controller=vacation&action=approve&button=denied&id=<?php echo $vacation->id; ?>">deny</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>