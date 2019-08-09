/* Intake form */
jQuery( document ).ready(function() {
    jQuery('#ppi-form').find('input').attr('disabled', 'true');
    if(jQuery('#accept input[type="checkbox"]').prop("checked") == true){
        jQuery('#ppi-form').find('input').removeAttr("disabled");           
        jQuery('#ppi-form').find('select').removeAttr("disabled");          
        jQuery('#ppi-form').css('opacity','1.0');
    }
    else if(jQuery('#accept input[type="checkbox"]').prop("checked") == false){
        jQuery('#ppi-form').find('input').attr('disabled', 'true');
        jQuery('#ppi-form').find('select').attr('disabled', 'true');        
        jQuery('#ppi-form').css('opacity','0.5');           
    }
    jQuery('#accept input[type="checkbox"]').click(function(){
        if(jQuery(this).prop("checked") == true){
            jQuery('#ppi-form').find('input').removeAttr("disabled");           
            jQuery('#ppi-form').find('select').removeAttr("disabled");  
            jQuery('#ppi-form').css('opacity','1.0');
        }
        else if(jQuery(this).prop("checked") == false){
            jQuery('#ppi-form').find('input').attr('disabled', 'true');
            jQuery('#ppi-form').find('select').attr('disabled', 'true');        
            jQuery('#ppi-form').css('opacity','0.5');           
        }
    });
});