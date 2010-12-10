<?php if ( ! empty($message)) { ?>
    <div class="message"><?php echo $message; ?></div>
<?php } ?>

<div class="form">

<?php echo Form::open() ?>
    <?php if ( ! empty($venue)) { echo Form::hidden('id', $venue['id']); } ?>

    <div class="form-field">
        <?php 
            echo Form::label('name', 'Name'); 
            echo Form::input('name', (empty($venue)) ? '' : $venue['name'], array('class' => 'input'));
        ?>
    </div>

    <?php echo Form::hidden('adr_is_primary', true); ?>
    <div class="form-field">
        <?php 
            echo Form::label('adr_line_1', 'Address 1'); 
            echo Form::input('adr_line_1', (empty($venue)) ? '' : $venue['line_1'], array('class' => 'input'));
        ?>
    </div>

    <div class="form-field">
        <?php 
            echo Form::label('adr_line_2', 'Address 2'); 
            echo Form::input('adr_line_2', (empty($venue)) ? '' : $venue['line_2'], array('class' => 'input'));
        ?>
    </div>

    <div class="form-field">
        <?php 
            echo Form::label('adr_city', 'City'); 
            echo Form::input('adr_city', (empty($venue)) ? '' : $venue['city'], array('class' => 'input'));
        ?>
    </div>

    <div class="form-field">
        <?php 
            echo Form::label('adr_state_province', 'State/Province'); 
            echo Form::input('adr_state_province', (empty($venue)) ? '' : $venue['state_province'], array('class' => 'input'));
        ?>
    </div>

    <div class="form-field">
        <?php 
            echo Form::label('adr_zip', 'Zip Code'); 
            echo Form::input('adr_zip', (empty($venue)) ? '' : $venue['zip'], array('class' => 'input'));
        ?>
    </div>

    <div class="form-field">
        <?php /*
            echo Form::label('tags', 'Tag'); 
            echo Form::select('tags', $tags); 
        */ ?>
    </div>

    <div class="form-field">
        <div class="input"><?php echo Form::button('save', (empty($venue)) ? 'Create' : 'Edit'.' Venue', array('type' => 'submit')); ?></div>
    </div>
    

<?php echo Form::close() ?>

</div>

