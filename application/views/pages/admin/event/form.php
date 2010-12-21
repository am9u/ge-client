<?php if ( ! empty($message)) { ?>
    <div class="message"><?php echo $message; ?></div>
<?php } ?>

<div class="form">

<?php echo Form::open() ?>
    <?php if ( ! empty($event)) { echo Form::hidden('id', $event->id); } ?>
    <?php if ( ! empty($group_id)) { echo Form::hidden('group_id', $group_id); } ?>

    <div class="form-field">
        <?php 
            echo Form::label('datetime', 'DateTime'); 
            echo Form::input('datetime', (empty($event)) ? Date::formatted_time('now', 'Y-m-d H:i:s') : $event->datetime, array('class' => 'input'));
        ?>
    </div>

    <div class="form-field">
        <?php 
            echo Form::label('name', 'Name'); 
            echo Form::input('name', (empty($event)) ? '' : $event->name, array('class' => 'input'));
        ?>
    </div>

    <div class="form-field form-field-textarea">
        <?php 
            echo Form::label('description', 'Description'); 
            echo Form::textarea('description', (empty($event)) ? '' : $event->description, array(
                'width'  => '40',
                'height' => '20',
                'class'  => 'input' 
            )); 
        ?>
    </div>

    <div class="form-field">
        <?php 
            /** Returns array in format that can populate select options for HTML::select() */
            function _select_element_arr($arr, $key_name, $value_name)
            {
                $options = array();
                foreach($arr as $option)
                {
                    $options[$option[$key_name]] = $option[$value_name];
                    //Arr::extract($arr, array($key_name, $value_name));
                }
                return $options;
            }

            $select_venues = _select_element_arr($venues, 'id', 'name');

            echo Form::label('venue_id', 'Venue'); 
            echo Form::select('venue_id', $select_venues, (empty($event)) ? NULL : $event->venue_id, array('class' => 'input'));
        ?>
    </div>

    <? /** SAMPLE TAG FIELDS
    <?php 
        echo Form::hidden('tags[]', 1); 
    ?>
    <div class="form-field">
        <?php 
            echo Form::label('tags', 'Tags'); 
            echo Form::input('tags[]', 'Food', array('class' => 'input'));
         ?>
    </div>
    */?>
    
    <? /*
    Venue ID: <?php echo $venue['id'] ?><br/>
    <?php echo $venue['name'] ?><br/>
    <?php echo $venue['address_1'] ?><br/>
    <?php echo $venue['address_2'] ?><br/>
    <?php echo $venue['city'] ?>, <?php echo $venue['state_province'] ?> <?php /* echo $venue['zip'] */ ?>

    <div class="form-field">
        <div class="input"><?php echo Form::button('save', (empty($event)) ? 'Create' : 'Edit'.' Event', array('type' => 'submit')); ?></div>
    </div>
    

<?php echo Form::close() ?>

</div>

