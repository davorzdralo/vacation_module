<div class="container">

    <table class="table table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($vacations as $vacation) { ?>
                <tr>
                    <td><?php echo $vacation->id; ?></td>
                    <td><?php echo $vacation->start; ?></td>
                    <td><?php echo $vacation->end; ?></td>
                    <td><?php echo $vacation->status; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>