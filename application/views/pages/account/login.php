<?php if ( ! empty($message)) { ?>
    <div class="message"><?php echo $message; ?></div>
<?php } ?>

<div class="form">
    <?php echo Form::open(); ?>

        <?php
            if (isset($_GET['continue']) OR isset($_POST['continue'])) 
            {
                echo Form::hidden('redirect_url', $_REQUEST['continue']);
            }
        ?>
        <div class="form-field">
            <?php
                echo Form::label('username', 'Username'); 
                echo Form::input('username', (empty($user)) ? '' : $user['username'], array('class' => 'input'));
            ?>
        </div>

        <div class="form-field">
            <?php
                echo Form::label('password', 'Password'); 
                echo Form::password('password', '', array('class' => 'input'));
            ?>
        </div>
        
        <p><input name="Login" type="submit" value="Login"></p>

    <?php echo Form::close() ?>
</div>

<div id="register">
    <p>Want to join? <?php echo HTML::anchor(Request::instance()->uri(array('action' => 'register')), 'Sign up here'); ?>.</p>
</div>
