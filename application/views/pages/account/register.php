<?php if ( ! empty($message)) { ?>
    <div class="message"><?php echo $message; ?></div>
<?php } ?>

<div class="form">
    <?php echo Form::open(); ?>
        <div class="form-field">
            <?php
                echo Form::label('username', 'Username'); 
                echo Form::input('username', (empty($user)) ? '' : $user['username'], array('class' => 'input'));
            ?>
        </div>
        <div class="form-field">
            <?php
                echo Form::label('email', 'Email'); 
                echo Form::input('email', (empty($user)) ? '' : $user['email'], array('class' => 'input'));
            ?>
        </div>
        <div class="form-field">
            <?php
                echo Form::label('password', 'Password'); 
                echo Form::password('password', '', array('class' => 'input'));
            ?>
        </div>
        <div class="form-field">
            <?php
                echo Form::label('verify_password', 'Verify Password'); 
                echo Form::password('verify_password', '', array('class' => 'input'));
            ?>
        </div>
        
        <p><input name="Register" type="submit" value="Sign Up"></p>

    <?php echo Form::close() ?>
</div>
