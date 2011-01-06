<p>You are logged in.</p>

<?php if (in_array('admin', $user->roles)) { ?>
    <p><?php echo HTML::anchor(Route::get('admin')->uri(), 'Admin Dashboard'); ?>
<?php } ?>

<?php 
    if (count($user->groups) > 0) 
    { 
        foreach($user->groups as $group)
        {
            if (in_array('group_admin', $group['roles'])) {
?>
                <p><?php echo HTML::anchor(Route::get('group_admin')->uri(array('group' => str_replace(' ', '-', $group['name']))), $group['name'].' Admin Dashboard'); ?></p>
<?php
            }
        }
    }
?>

<p><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'logout')), 'Click Here to Logout'); ?></p>
