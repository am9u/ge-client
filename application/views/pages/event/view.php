<?php echo Request::instance()->param('group'); ?>

<h2><?php echo $event->name; ?></h2>
<div class="dateline">
    <span class="date">Date: <?php echo $event->date; ?></span><br/>
    <span class="time">Time: <?php echo $event->time; ?></span>
</div>

<h3>Description</h3>
<div class="event-description">
    <?php echo $event->description; ?>
</div>
