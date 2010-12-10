
<?php 
    $form = View::factory('pages/admin/venue/form'); 
    if( ! empty($message)) { $form->bind('message', $message); }
    echo $form;
?>
