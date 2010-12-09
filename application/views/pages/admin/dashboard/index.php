
<h3>Manage</h3>
<ul>

    <li><?php echo HTML::anchor(Request::instance()->uri(array('controller' => 'tag')), 'Tags'); ?></li>
    <li><?php echo HTML::anchor(Request::instance()->uri(array('controller' => 'event')), 'Events'); ?></li>
    <li><?php echo HTML::anchor(Request::instance()->uri(array('controller' => 'venue')), 'Venues'); ?></li>
</ul>
