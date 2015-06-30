jQuery(document).ready(function( $ ){

    
    $('#wp_social_popup_button_fb').change(function() {
        if($(this).is(":checked")) {
            $( ".wrap_inputs_fb" ).fadeIn( "slow", function() {
                $(this).css("display","block");
            });
            $(this).parent().parent().parent().addClass("active_fb");
        }else{
            $( ".wrap_inputs_fb" ).fadeOut( 300, function() {
                //$(this).css("display","none");
            });
            $(this).parent().parent().parent().removeClass("active_fb");
        }
    });

    $('#wp_social_popup_button_tw').change(function() {
        if($(this).is(":checked")) {
            $( ".wrap_inputs_tw" ).fadeIn( "slow", function() {
                $(this).css("display","block");
            });
            $(this).parent().parent().parent().addClass("active_tw");
        }else{
            $( ".wrap_inputs_tw" ).fadeOut( 300, function() {
                //$(this).css("display","none");
            });
            $(this).parent().parent().parent().removeClass("active_tw");
        }
    });

    $('#wp_social_popup_button_go').change(function() {
        if($(this).is(":checked")) {
            $( ".wrap_inputs_go" ).fadeIn( "slow", function() {
                $(this).css("display","block");
            });
            $(this).parent().parent().parent().addClass("active_go");
        }else{
            $( ".wrap_inputs_go" ).fadeOut( 300, function() {
                //$(this).css("display","none");
            });
            $(this).parent().parent().parent().removeClass("active_go");
        }
    });

    $('#wp_social_popup_type_campaign').change(function() {
        if($(this).val()==1) {
            $(".class_input_until_date").css("display","block");
            $(".class_input_days").css("display","none");
        }else if($(this).val()==2  ){
            $(".class_input_days").css("display","block");
            $(".class_input_until_date").css("display","none");
        }
    });



// validate init options
if($('#wp_social_popup_button_fb').is(":checked")) {
    $( ".wrap_inputs_fb" ).fadeIn( "slow", function() {
        $(this).css("display","block");
    });
    $('#wp_social_popup_button_fb').parent().parent().parent().addClass("active_fb");
}else{
    $( ".wrap_inputs_fb" ).fadeOut( 300, function() {
        //$(this).css("display","none");
    });
    $('#wp_social_popup_button_fb').parent().parent().parent().removeClass("active_fb");
}


if($('#wp_social_popup_button_tw').is(":checked")) {
    $( ".wrap_inputs_tw" ).fadeIn( "slow", function() {
        $(this).css("display","block");
    });
    $('#wp_social_popup_button_tw').parent().parent().parent().addClass("active_tw");
}else{
    $( ".wrap_inputs_tw" ).fadeOut( 300, function() {
        //$(this).css("display","none");
    });
    $('#wp_social_popup_button_tw').parent().parent().parent().removeClass("active_tw");
}


if($('#wp_social_popup_button_go').is(":checked")) {
    $( ".wrap_inputs_go" ).fadeIn( "slow", function() {
        $(this).css("display","block");
    });
    $('#wp_social_popup_button_go').parent().parent().parent().addClass("active_go");
}else{
    $( ".wrap_inputs_go" ).fadeOut( 300, function() {
        //$(this).css("display","none");
    });
    $('#wp_social_popup_button_go').parent().parent().parent().removeClass("active_go");
}

if($('#wp_social_popup_type_campaign').val() == 1 ) {
    $(".class_input_until_date").css("display","block");
    $(".class_input_days").css("display","none");
}else{
    $(".class_input_days").css("display","block");
    $(".class_input_until_date").css("display","none");
}
 

});

 
function clearCookie(name, domain, path){
    var domain = domain || document.domain;
    var path = path || "/";
    document.cookie = name + "=; expires=" + +new Date + ";  path=/";
    alert('Cookies deleted!');
    return false;
}