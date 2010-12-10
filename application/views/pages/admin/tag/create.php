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

        <div class="form-field">
            <div class="input"><?php echo Form::button('save', (empty($event)) ? 'Create' : 'Edit'.' Tag', array('type' => 'submit')); ?></div>
        </div>
    <?php echo Form::close(); ?>
</div>
