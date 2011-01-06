<div id="event_header">
    <h2><?php echo $event->name; ?></h2>
    <p><?php echo $event->venue->name; ?></p>
    <p><?php echo Date::formatted_time($event->datetime, 'l, F j, Y'); ?></p>
    <?php /* <p><?php echo $event->subtitle; ?></p> */ ?>
</div>

<?php /*
<div class="dateline">
    <span class="date">Date: <?php echo $event->date; ?></span><br/>
    <span class="time">Time: <?php echo $event->time; ?></span>
</div>
*/ ?>

<div id="tabs-content">
    <ul>
        <li><a href="#content-tabs-highlight">Highlights</a></li>
        <li><a href="#content-tabs-menu">The Menu</a></li>
    </ul>

    <div id="content-tabs-highlight">
        <p><strong><?php echo $event->name; ?></strong></p>
        <p><?php echo $event->venue->name; ?></p>
        <p><?php echo Date::formatted_time($event->datetime, 'l, F j, Y'); ?></p>
        <p>
            <?php echo $event->venue->address->line_1; ?><br/>
            <?php echo $event->venue->address->city; ?>, <?php echo $event->venue->address->state_province; ?> <?php echo $event->venue->address->zip; ?><br/>
        </p>
        <?php echo $event->description; ?>
    </div>

    <div id="content-tabs-menu">
        <p><?php echo $event->menu; ?></p>
    </div>
</div>

<script>
$(function() {
    $('#tabs-content').tabs();
});
</script>
