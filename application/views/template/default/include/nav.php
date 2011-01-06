<?php
    $request = Request::instance();
?>

<div id="nav">
    <ul>
        <?php /** Homepage */ ?>
        <li><?php echo HTML::anchor(Route::get('default')->uri(), 'Home'); ?></li>

        <?php /** Events */ ?>
        <li><?php echo HTML::anchor($request->uri(array('controller' => 'event', 'action' => 'index', 'id' => NULL)), 'Events'); ?></li>

        <?php /** User Account */ ?>
        <li><?php echo HTML::anchor($request->uri(array('controller' => 'account', 'action' => 'index', 'id' => NULL)), 'My Account'); ?></li>
    </ul>
</div>
