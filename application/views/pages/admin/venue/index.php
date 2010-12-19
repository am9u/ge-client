
<?php if (count($venues) < 1) { ?>

    <p>There are no venues.</p>

<?php } else { ?>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>City</th>
            <th>State</th>
            <td colspan="2">&nbsp;</td>
        </tr>
        </thead>
        <?php foreach($venues as $venue) { ?>
            <tr>
                <td><?php echo $venue['name']; ?></td>
                <td><?php echo $venue['city']; ?></td>
                <td><?php echo $venue['state_province']; ?></td>
                <td><?php echo HTML::anchor(Route::get('default')->uri(array('controller' => 'venue', 'action' => 'view', 'id' => $venue['id'])), 'Preview'); ?></td>
                <td><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'edit', 'id' => $venue['id'])), 'Edit'); ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

