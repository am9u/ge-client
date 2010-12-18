<dl>
    <dt>Username</dt>
    <dd><?php echo $user->username; ?></dd>

    <dt>Groups</dt>
    <?php foreach($user->groups as $group) { ?>
        <dd>
            <?php echo $group['name']; ?> 
            <?php echo Form::open(); ?>
                <?php echo Form::hidden('action', 'make_group_admin'); ?>
                <?php echo Form::hidden('user_id', $user->id); ?>
                <?php echo Form::hidden('group_id', $group['id']); ?>
                <div class="input"><?php echo Form::button('save', 'Make Admin', array('type' => 'submit')); ?></div>
            <?php echo Form::close(); ?>
        </dd>
    <?php } ?>
</dl>

<div class="form">
<?php echo Form::open(); ?>
    <?php echo Form::hidden('action', 'add_to_group'); ?>
    <?php echo Form::hidden('user_id', $user->id); ?>

    <div class="form-field">
        <?php 
            /** Returns array in format that can populate select options for HTML::select() */
            function _select_element_arr($arr, $key_name, $value_name)
            {
                $options = array('' => 'Select Group');
                foreach($arr as $option)
                {
                    $options[$option->id] = $option->name;
                }
                return $options;
            }

            $select_venues = _select_element_arr($groups, 'id', 'name');
            echo Form::label('group_id', 'Add to Group'); 
            echo Form::select('group_id', $select_venues, NULL, array('class' => 'input'));
        ?>
    </div>

    <div class="form-field">
        <div class="input"><?php echo Form::button('save', 'Add', array('type' => 'submit')); ?></div>
    </div>

<?php echo Form::close(); ?>
</div>
