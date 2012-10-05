<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>
{primary}
{forms_inputs}
<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
