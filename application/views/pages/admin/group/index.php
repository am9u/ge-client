<ul>
    <li><?php echo HTML::anchor(Request::instance()->uri(array('action' => 'create')) ,'Create Group');?></li>
</ul>

<?php if(count($groups) > 0) { ?>
    <dl>
    <?php foreach($groups as $group) { ?>
        <dt><?php echo $group->name; ?></dt>
        <dd><?php echo $group->description; ?></dd>
    <?php } ?>
    </dl>
<?php } else { ?>
    <p>There are no groups in the database.</p>
<?php } ?>
