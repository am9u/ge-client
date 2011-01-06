<div id="event_header">
    <h2><?php echo $event->name; ?></h2>
    <p><?php echo $event->venue->name; ?></p>
    <p><?php echo Date::formatted_time($this->datetime, 'l, F j, Y'); ?></p>
    <?php /* <p><?php echo $event->subtitle; ?></p> */ ?>
</div>

<?php /*
<div class="dateline">
    <span class="date">Date: <?php echo $event->date; ?></span><br/>
    <span class="time">Time: <?php echo $event->time; ?></span>
</div>
*/ ?>

<h3>Highlights</h3>
<div class="event-highlights">
    <p><strong><?php echo $event->name; ?></strong></p>
    <p><?php echo $event->venue->name; ?></p>
    <p><?php echo Date::formatted_time($this->datetime, 'l, F j, Y'); ?></p>

    <?php echo $event->description; ?>
</div>
