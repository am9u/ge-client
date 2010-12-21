
<?php if (count($users) < 1) { ?>

    <p>There are no users.</p>

<?php } else { ?>

    <table>
        <thead>
        <tr>
            <th>Username</th>
            <th>Groups</th>
            <th>Roles</th>
            <td colspan="2">&nbsp;</td>
        </tr>
        </thead>
        <?php foreach($users as $user) { ?>
            <tr>
                <td><?php echo $user->username; ?></td>
                <td>
                    <?php /* foreach($user->groups as $group) {} */ ?>
                </td>
                <td></td>
                <td><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'edit', 'id' => $user->id)), 'Edit'); ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>

<h3>Past Events</h3>
<p>List of Past Events goes here.</p>
