<?php
    $request = Request::instance();
?>

<div id="nav_admin">
    <h3>Manage</h3>
    <ul>
        <?php /** Events */ ?>
        <li><?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'event')), 'Events'); ?>

            <?php if ($request->controller === 'event') { ?>
                <ul>
                    <li><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'create')), 'Create a New Event'); ?></li>
                </ul>
            <?php } ?>

        </li>

        <?php /** Venues */ ?>
        <li><?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'venue')), 'Venues'); ?>
        
            <?php if ($request->controller === 'venue') { ?>
                <ul>
                    <li><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'create')), 'Create a New Venue'); ?></li>
                </ul>
            <?php } ?>
        </li>

        <?php /** Tags */ ?>
        <li><?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'tag')), 'Tags'); ?>
        
            <?php if ($request->controller === 'tag') { ?>
                <ul>
                    <li><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'create')), 'Create a New Tag'); ?></li>
                </ul>
            <?php } ?>
        </li>

        <?php /** Dashboard */ ?>
        <?php if ($request->controller !== 'dashboard') { ?>
            <li><?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'dashboard')), 'Back to Admin Dashboard'); ?></li>
        <?php } ?>
    </ul>
</div>
