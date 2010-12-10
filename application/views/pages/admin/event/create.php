
<?php 
    $form = View::factory('pages/admin/event/form'); 
    if( ! empty($message)) { $form->bind('message', $message); }
    $form->bind('venues', $venues);
    echo $form;
?>
