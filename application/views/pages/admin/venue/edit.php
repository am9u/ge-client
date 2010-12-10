<ul>
    <li><?php echo HTML::anchor(Route::get('default')->uri(array('controller' => 'venue', 'action' => 'view', 'id' => $venue['id'])), 'Preview'); ?></li>
</ul>

<?php 
    $form = View::factory('pages/admin/venue/form'); 
    if( ! empty($message)) { $form->bind('message', $message); }
    $form->bind('venue', $venue);
    echo $form;
?>
