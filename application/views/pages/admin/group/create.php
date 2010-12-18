<?php if ( ! empty($message)) { ?>
    <div class="message"><?php echo $message; ?></div>
<?php } ?>

<div class="form">
    <?php echo Form::open(); ?>
        <div class="form-field">
            <?php 
                echo Form::label('name', 'Name'); 
                echo Form::input('name', (empty($tag)) ? '' : $tag['name'], array('class' => 'input'));
            ?>
        </div>

        <div class="form-field form-field-textarea">
            <?php 
                echo Form::label('description', 'Description'); 
                echo Form::textarea('description', (empty($group)) ? '' : $group['description'], array(
                    'width'  => '40',
                    'height' => '20',
                    'class'  => 'input' 
                )); 
            ?>
        </div>

        <?php if (count($groups) > 0) { ?>
            <div class="form-field">
                <?php 
                    /** Returns array in format that can populate select options for HTML::select() */
                    function _select_element_arr($arr, $key_name, $value_name)
                    {
                        $options = array('' => 'Create as subgroup of...');
                        foreach($arr as $option)
                        {
                            //$options[$option[$key_name]] = $option[$value_name];
                            //Arr::extract($arr, array($key_name, $value_name));
                            //array_push($options, array($option->id => $option->name));
                            $options[$option->id] = $option->name;
                        }
                        return $options;
                    }

                    $select_venues = _select_element_arr($groups, 'id', 'name');
                    echo Form::label('parent_id', 'Parent Group'); 
                    echo Form::select('parent_id', $select_venues, (empty($group)) ? NULL : $group['parent_id'], array('class' => 'input'));
                ?>
            </div>
        <?php } ?>

        <div class="form-field">
            <div class="input"><?php echo Form::button('save', (empty($group)) ? 'Create' : 'Edit'.' Tag', array('type' => 'submit')); ?></div>
        </div>
    <?php echo Form::close(); ?>
</div>
