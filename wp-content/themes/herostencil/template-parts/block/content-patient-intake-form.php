<?php 
?>
<?php 
if( get_field('intake_form_script') ) {
wp_enqueue_script( 'patient-intake-function' );
?>
    <form action="" id="accept">
        <label>
            <input type="checkbox"/>
            <span><?php echo get_field('privacy_title'); ?></span>
        </label>
    </form>
    <br class="clear"/>
    <div class="patient_form">
       <?php echo get_field('intake_form_script'); ?>
    </div>
    <div class="clear"></div>
    <img src="<?php echo get_template_directory_uri(); ?>/images/web-pt-logo.png" alt="WebPT"/>
<?php 
}
?>