
<h3>Upcoming Events</h3>

<?php if (count($events) < 1) { ?>

    <p>There are no upcoming events.</p>

<?php } else { ?>

    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Name</th>
            <th>Description</th>
            <td colspan="2">&nbsp;</td>
        </tr>
        </thead>
        <?php foreach($events as $event) { ?>
            <tr>
                <td><?php echo $event['date']; ?></td>
                <td><?php echo $event['time']; ?></td>
                <td><?php echo $event['name']; ?></td>
                <td><?php echo $event['description']; ?></td>
                <td><?php echo HTML::anchor(Route::get('default')->uri(array('controller' => 'event', 'action' => 'view', 'id' => $event['id'])), 'Preview'); ?></td>
                <td><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'edit', 'id' => $event['id'])), 'Edit'); ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<h3>Past Events</h3>
<p>List of Past Events goes here.</p>
