<ul>
    <li><?php echo HTML::anchor(Route::get('default')->uri(array('controller' => 'event', 'action' => 'view', 'id' => $event->id)), 'Preview'); ?></li>
</ul>

<?php 
    $form = View::factory('pages/admin/event/form'); 
    if( ! empty($message)) { $form->bind('message', $message); }
    if( ! empty($group_id)) { $form->bind('group_id', $group_id); }
    $form->bind('event', $event);
    $form->bind('venues', $venues);
    echo $form;
?>
