
<?php 
    $form = View::factory('pages/admin/event/form'); 
    if( ! empty($message)) { $form->bind('message', $message); }
    if( ! empty($group_id)) { $form->bind('group_id', $group_id); }
    $form->bind('venues', $venues);
    echo $form;
?>
