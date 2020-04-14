

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

<div class="container">
    <h3 class="text-center" style="color:gray;">Create An Account</h3>
    <hr class="custom_hr">
    <?php echo form_open('sign-up','class="form-horizontal text-center"');?>

    <div style="padding-left:10rem; padding-right:10rem;">
        <div class="control-group <?php echo (form_error('su_username')) ? 'error' : ''; ?>">
            <label class="control-label">Username :</label>
            <div class="controls">
                <?php echo form_input(array(
                    'id' => 'su_username',
                    'name' => 'su_username',
                    'value' => set_value('su_username')
                ));?>

                <?php if (form_error('su_username') || isset($su_username_err)) : ?>
                    <span class="help-inline">
                        <?php echo form_error('su_username'); ?>
                        <?php if (isset($su_username_err)) : ?>
                            <span class="field_error"><?php echo $su_username_err; ?></span>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="control-group <?php echo (form_error('su_password')) ? 'error' : ''; ?>">
            <label class="control-label">Password :</label>
            <div class="controls">
                <?php echo form_password(array(
                    'id' => 'su_password',
                    'name' => 'su_password',
                    'value' => set_value('su_password')
                ));?>

                <?php if (form_error('su_password')) : ?>
                    <span class="help-inline">
                        <?php echo form_error('su_password'); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <?php echo form_submit(array(
                    'type' => 'submit',
                    'class' => 'btn btn-warning',
                    'value' => 'Create Account'
                ));?>

                <?php echo anchor(
                    'sign-in',
                    'Sign In',
                    'class="btn btn-info btn-small"'
                );?>
            </div>
        </div>

    </div>
    <?php echo form_close();?>
    <hr class="custom_hr">
</div>