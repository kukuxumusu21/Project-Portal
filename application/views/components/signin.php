

<style>

.custom_hr {
    margin: 25px 0;
    height: 1px;
    border: 0;
    background: black;
    background: -webkit-gradient(linear, 0 0, 100% 0, from(white), to(white), color-stop(50%, black));
}
</style>
<br><br><br>

<div class="container text-center">
    <h3 style="color:gray;">SIGN IN - PORTAL</h3>
</div>

<hr class="custom_hr">
<div class="container">
    <div style="padding-left:10rem; padding-right:10rem;">
    <?php echo form_open('c1fa236fb935cab74c8dbfabe3ffd06f','class="form-horizontal text-center"');?>
        <div class="control-group <?php echo form_error('si_username') ? 'error' : ''; ?>">
            <label class="control-label">Username :</label>
            <div class="controls">
                <?php echo form_input(array(
                    'id' => 'si_username',
                    'name' => 'si_username',
                    'value' => set_value('si_username')
                ));?>

                <?php if (form_error('si_username') || isset($si_username_err)) : ?>
                    <span class="help-inline">
                        <?php echo form_error('si_username'); ?>
                        <?php if (isset($si_username_err)) : ?>
                            <span class="field_error"><?php echo $si_username_err; ?></span>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="control-group <?php echo form_error('si_password') ? 'error' : ''; ?>">
            <label class="control-label">Password :</label>
            <div class="controls">
                <?php echo form_password(array(
                    'id' => 'si_password',
                    'name' => 'si_password',
                    'value' => set_value('si_password')
                ));?>
                <?php if (form_error('si_password')) : ?>
                    <span class="help-inline"><?php echo form_error('si_password'); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="control-group form-horizontal">
            <div class="controls">
                <?php echo form_submit(array(
                    'type' => 'submit',
                    'class' => 'btn btn-info',
                    'value' => 'Sign In'
                ));?>

                <?php echo anchor(
                    'sign-up',
                    'Sign Up',
                    'class="btn btn-small btn-warning"'
                );?>
            </div>
        </div>
    <?php echo form_close();?>
    </div>

</div>

    <hr class="custom_hr">

