
<h3>Events</h3>

<?php if ($events === NULL OR count($events) < 1) { ?>

    <p>There are no events.</p>

<?php } else { ?>

    <dl>
        <?php foreach($events as $event) { ?>
            <dt><?php echo $event->date; ?></dt>
            <dd><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'view', 'id' => $event->id )), $event->name); ?></dd>
        <?php } ?>
    </dl>

<?php } ?>

