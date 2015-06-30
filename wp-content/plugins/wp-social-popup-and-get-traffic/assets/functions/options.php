<?php
/**
 * Options Plugin
 * Make configutarion
*/
if ( !class_exists('wp_social_popup_make') ) {

class wp_social_popup_make{

    public $parameter       = array();
    public $options         = array();
    public $components      = array();



    function __construct(){

        if( is_admin() )
            self::configuration_plugin();
        else
            self::parameters();

    }

    function getHeaderPlugin(){
        //code 

        global $wp_social_pupup_header_plugins;
        return array('id'             =>'wp_social_popup_id',
                     'id_menu'        =>'wp_social_popup',
                     'name'           =>'WP Social Popup and Get Traffic',
                     'name_long'      =>'WP Social Popup and Get Traffic',
                     'name_option'    =>'wp_social_popup',
                     'name_plugin_url'=>'wp-social-popup-and-get-traffic',
                     'descripcion'    =>'Show content for likes/tweets/+1s',
                     'version'        =>'4.8.4',
                     'url'            =>'',
                     //'logo'           =>'<i class="fa fa-laptop text-long" style="padding:15px 14px!important;"></i>',
                     'logo'           =>'<img src="'.plugins_url()."/wp-social-popup-and-get-traffic/assets/images/logo.png".'" style="width: 79px;margin-right: 20px;position: relative;top: -14px;opacity: .8;" />',
                      // or image .jpg,png | use class 'text-long' in case of name long
                     'logo_text'      =>'', // alt of image
                     'slogan'         =>'', // powered by <a href="">iLenTheme</a>
                     'url_framework'  =>plugins_url()."/wp-social-popup-and-get-traffic/assets/ilenframework",
                     'theme_imagen'   =>plugins_url()."/wp-social-popup-and-get-traffic/assets/images",
                     //'twitter'        => 'https://twitter.com/intent/tweet?text=View this awesome plugin WP;url=http://bit.ly/1sJi6U2&amp;via=iLenElFuerte',
                     'wp_review'      => 'https://wordpress.org/support/view/plugin-reviews/wp-social-popup-and-get-traffic?filter=5',
                     'wp_support'     => 'http://support.ilentheme.com/forums/forum/plugins/wp-social-popup-and-get-traffic/',
                     'link_donate'    => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KN6G7PNRZKAEU',
                     'type'           =>'plugin',
                     'method'         =>'free',
                     'themeadmin'     =>'fresh',
                     'scripts_admin'  =>array( 'page'        => array('wp_social_popup' => array('date','jquery_ui_reset','tag')), ));
    }

    function getOptionsPlugin(){
        //code 
    global $wp_social_pupup_make_plugins;



    global ${'tabs_plugin_' . $this->parameter['name_option']};
    ${'tabs_plugin_' . $this->parameter['name_option']} = array();
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab01']=array('id'=>'tab01','name'=>'Main Settings','icon'=>'<i class="fa fa-circle-o"></i>','width'=>'200'); 
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab02']=array('id'=>'tab02','name'=>'Social Network','icon'=>'<i class="fa fa-share-alt"></i>','width'=>'200'); 
    ${'tabs_plugin_' . $this->parameter['name_option']}['tab03']=array('id'=>'tab03','name'=>'Advanced','icon'=>'<i class="fa fa-hand-o-up"></i>','width'=>'200'); 

    return array('a'=>array(                'title'      => __('Main Settings',$this->parameter['name_option']),        //title section
                                            'title_large'=> __('Main Settings',$this->parameter['name_option']),//title large section
                                            'description'=> '', //description section
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab01',


                                            'options'    => array(  
                                                                     

                                                                    array(  'title' =>__('Enable / Disable:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Enable / Disable the "WP Social Popup and Get Traffic" plugin.',
                                                                            'type'  =>'checkbox', //type input configuration
                                                                            'value' =>'1', //value default
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_enabled', 
                                                                            'name'  =>$this->parameter['name_option'].'_enabled',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    /*array(  'title' =>__('Credits Url:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Give us some support by enabling the small link on footer.',
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0', //value default
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_credits', 
                                                                            'name'  =>$this->parameter['name_option'].'_credits',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),*/

                                                                    array(  'title' =>__('Show Close Button:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Enable / Disable the close button.',
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'1', //value default
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_show_close_button', 
                                                                            'name'  =>$this->parameter['name_option'].'_show_close_button',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Close Advanced keys:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'If enabled, users can close the popup by pressing the escape key or clicking outside of the popup.',
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0', //value default
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_closed_advanced_keys', 
                                                                            'name'  =>$this->parameter['name_option'].'_closed_advanced_keys',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),
    

                                                                    array(  'title' =>__('Campaign type:',$this->parameter['name_option']),
                                                                            'help'  =>__('<code>Fixed date:</code> To date the popup is displayed, the cache also died on this date plugin which allows you to manage time well. <br />
                                                                                          <code>Days:</code> No termination date, whenever the user clicks on a social button does not return you receive the popup to the days specified for that user.',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>2,
                                                                            'items' =>array(2=>'Days',1=>'Fixed date'),
                                                                            'id'    =>$this->parameter['name_option'].'_'.'type_campaign',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'type_campaign',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Days until popup shows again?:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"When a user closes the popup he won't see it again until all these days pass",
                                                                            'type'  =>'text',
                                                                            'value' =>'100', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_until_popup', 
                                                                            'name'  =>$this->parameter['name_option'].'_until_popup',  
                                                                            'class' =>'class_input_specials class_input_days', //class
                                                                            'style' =>'display:none;',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Date until:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Date end of season and disable popup",
                                                                            'type'  =>'date',
                                                                            'value' =>date("Y-m-d"), //value default
                                                                            'id'    =>$this->parameter['name_option'].'_'.'date_end',
                                                                            'name'  =>$this->parameter['name_option'].'_'.'date_end',
                                                                            'opts'  =>',minDate: 1',
                                                                            'class' =>'class_input_specials class_input_until_date', //class
                                                                            'style' =>'display:none;',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Seconds for popup to appear ?:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"After the page is loaded, popup will be shown after X seconds",
                                                                            'type'  =>'text',
                                                                            'value' =>'1', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_seconds_appear', 
                                                                            'name'  =>$this->parameter['name_option'].'_seconds_appear',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Seconds for popup to close ?:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"After the popup is loaded, popup will be close after X seconds. 0 to disable",
                                                                            'type'  =>'text',
                                                                            'value' =>'0', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_seconds_close', 
                                                                            'name'  =>$this->parameter['name_option'].'_seconds_close',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Display a Thanks Message if someone share:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"After the popup is closed, this message will appear if they click on any social link",
                                                                            'type'  =>'text',
                                                                            'value' =>'Thanks for supporting our site ;)', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_thanks_message', 
                                                                            'name'  =>$this->parameter['name_option'].'_thanks_message',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Title popup:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Title displayed in the popup",
                                                                            'type'  =>'text',
                                                                            'value' =>'Content Blocked', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_title_message', 
                                                                            'name'  =>$this->parameter['name_option'].'_title_message',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Content text popup:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Content text displayed in the popup",
                                                                            'type'  =>'text',
                                                                            'value' =>'To view the content please help us by clicking on one of the social icons, thanks for everything.', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_content_message', 
                                                                            'name'  =>$this->parameter['name_option'].'_content_message',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Seconds for thanks message to show ?:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"After the thanks message is displayed, popup will be close after X seconds.",
                                                                            'type'  =>'text',
                                                                            'value' =>'3', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_thanks_message_seconds', 
                                                                            'name'  =>$this->parameter['name_option'].'_thanks_message_seconds',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    

                                                                    


                                                            )
                                        ),
                            'b'=>array(     'title'      => __('Facebook Fanpage for days',$this->parameter['name_option']),        //title section
                                            'title_large'=> __('Facebook Fanpage for days',$this->parameter['name_option']),//title large section
                                            'description'=> '', //description section
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab02',
                                            'options'    => array(

                                                                    array(  'title' =>__('Enabled Button',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Enable button facebook.',
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0', //value default
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_button_fb', 
                                                                            'name'  =>$this->parameter['name_option'].'_button_fb',  
                                                                            'class' =>'wrap_buttos_fb', //class
                                                                            'after' =>'<div class="wrap_inputs_fb">',
                                                                            'style' =>"style='background:#ECECEC;'",
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Monday (Default)",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_url_default', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_url_default',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Tuesday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_url_tuesday', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_url_tuesday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Wednesday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_url_wednesday', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_url_wednesday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Thursday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_url_thursday', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_url_thursday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Friday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_url_friday', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_url_friday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Saturday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_url_saturday', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_url_saturday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Sunday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_url_sunday', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_url_sunday',  
                                                                            'class' =>'', //class
                                                                            
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Extras LIKE',$this->parameter['name_option']), //title section
                                                                            'help'  =>"If your site already received the LIKE can put other pages or news link for people of alternative LIKE",
                                                                            'type'  =>'divide',
                                                                            'value' =>'', //value default
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook alternative 1:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_alt_1', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_alt_1',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook alternative 2:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_alt_2', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_alt_2',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Facebook alternative 3:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_facebook_alt_3', 
                                                                            'name'  =>$this->parameter['name_option'].'_facebook_alt_3',  
                                                                            'class' =>'', //class
                                                                            'after'=>'</div>',
                                                                            'row'   =>array('a','b')),
                                                                            
                                                                    array(  'title' =>__('Like the post:',$this->parameter['name_option']),  
                                                                            'help'  =>"With this option you showed also the 'like button' post, this would help the user to have an alternative to see the content if you already gave LIKE to your website.",
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0',  
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_like_post', 
                                                                            'name'  =>$this->parameter['name_option'].'_like_post',  
                                                                            'class' =>'', //class
                                                                            'after' =>'',
                                                                            'row'   =>array('a','b')),

                                                )
                                        ),
                            'c'=>array(     'title'      => __('Twitter user for days',$this->parameter['name_option']),  
                                            'title_large'=> __('Twitter user for days',$this->parameter['name_option']), 
                                            'description'=> '', //description section
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab02',
                                            'options'    => array(

                                                                    array(  'title' =>__('Enabled Button',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Enable button twitter.',
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'1', //value default
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_button_tw', 
                                                                            'name'  =>$this->parameter['name_option'].'_button_tw',  
                                                                            'class' =>'wrap_buttos_tw', //class
                                                                            'after' =>'<div class="wrap_inputs_tw">',
                                                                            'style' =>"style='background:#ECECEC;'",
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Twitter Username:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Monday (Default)",
                                                                            'type'  =>'text',
                                                                            'value' =>'iLenElFuerte', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_twitter_url_default', 
                                                                            'name'  =>$this->parameter['name_option'].'_twitter_url_default',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Twitter Username:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Tuesday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_twitter_url_tuesday', 
                                                                            'name'  =>$this->parameter['name_option'].'_twitter_url_tuesday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Twitter Username:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Wednesday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_twitter_url_wednesday', 
                                                                            'name'  =>$this->parameter['name_option'].'_twitter_url_wednesday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Twitter Username:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Thursday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_twitter_url_thursday', 
                                                                            'name'  =>$this->parameter['name_option'].'_twitter_url_thursday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Twitter Username:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Friday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_twitter_url_friday', 
                                                                            'name'  =>$this->parameter['name_option'].'_twitter_url_friday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Twitter Username:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Saturday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_twitter_url_saturday', 
                                                                            'name'  =>$this->parameter['name_option'].'_twitter_url_saturday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Twitter Username:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Sunday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_twitter_url_sunday', 
                                                                            'name'  =>$this->parameter['name_option'].'_twitter_url_sunday',  
                                                                            'class' =>'', //class
                                                                            'after'=>'</div>',
                                                                            'row'   =>array('a','b')),
                                                )
                                        ),
                            
                            'd'=>array(     'title'      => __('Google+ user for days',$this->parameter['name_option']),  
                                            'title_large'=> __('Google+ user for days',$this->parameter['name_option']), 
                                            'description'=> '', //description section
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab02',
                                            'options'    => array(

                                                                    array(  'title' =>__('Enabled Button',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Enable button google+.',
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0', //value default
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_button_go', 
                                                                            'name'  =>$this->parameter['name_option'].'_button_go',  
                                                                            'class' =>'wrap_buttos_go', //class
                                                                            'after' =>'<div class="wrap_inputs_go">',
                                                                            'style' =>"style='background:#ECECEC;'",
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Configuration G+',$this->parameter['name_option']), //title section
                                                                            'help'  =>"",
                                                                            'type'  =>'divide',
                                                                            'value' =>'', //value default
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Type',$this->parameter['name_option']),
                                                                            'help'  =>__('Which of the 2 types, "Button Plus" or "Follow + Button"',$this->parameter['name_option']),
                                                                            'type'  =>'select',
                                                                            'value' =>'button',
                                                                            'items' =>array('button'=>'Button Plus','button_follow'=>'Follow + Button Plus'),
                                                                            'id'    =>$this->parameter['name_option'].'_type_button_gplus',
                                                                            'name'  =>$this->parameter['name_option'].'_type_button_gplus',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),
                                                                            
                                                                            
                                                                    array(  'title' =>__('Button Youtube suscribe',$this->parameter['name_option']),
                                                                            'help'  =>__('Enter the user name of the channel "FarandulaEcuatoriana"',$this->parameter['name_option']),
                                                                            'type'  =>'text',
                                                                            'value' =>'',
                                                                            'id'    =>$this->parameter['name_option'].'_button_youtube_suscribe',
                                                                            'name'  =>$this->parameter['name_option'].'_button_youtube_suscribe',
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Url google+',$this->parameter['name_option']), //title section
                                                                            'help'  =>"",
                                                                            'type'  =>'divide',
                                                                            'value' =>'', //value default
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Google+ URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Monday (Default)",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_google_url_default', 
                                                                            'name'  =>$this->parameter['name_option'].'_google_url_default',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Google+ URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Tuesday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_google_url_tuesday', 
                                                                            'name'  =>$this->parameter['name_option'].'_google_url_tuesday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Google+ URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Wednesday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_google_url_wednesday', 
                                                                            'name'  =>$this->parameter['name_option'].'_google_url_wednesday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Google+ URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Thursday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_google_url_thursday', 
                                                                            'name'  =>$this->parameter['name_option'].'_google_url_thursday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Google+ URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Friday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_google_url_friday', 
                                                                            'name'  =>$this->parameter['name_option'].'_google_url_friday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Google+ URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Saturday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_google_url_saturday', 
                                                                            'name'  =>$this->parameter['name_option'].'_google_url_saturday',  
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Google+ URL:',$this->parameter['name_option']), //title section
                                                                            'help'  =>"Sunday",
                                                                            'type'  =>'text',
                                                                            'value' =>'', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_google_url_sunday', 
                                                                            'name'  =>$this->parameter['name_option'].'_google_url_sunday',  
                                                                            'class' =>'', //class
                                                                            'after'=>'</div>',
                                                                            'row'   =>array('a','b')),

                                                                    

                                                                    
                                                )
                                        ),
                            'e'=>array(     'title'      => __('Other Options',$this->parameter['name_option']),  
                                            'title_large'=> __('Other Options',$this->parameter['name_option']), 
                                            'description'=> '', //description section
                                            'icon'       => 'fa fa-circle-o',
                                            'tab'        => 'tab03',
                                            'options'    => array(

                                                                    array(  'title' =>__('Opacity:',$this->parameter['name_option']),  
                                                                            'help'  =>"Change background opacity. Default is 0.65",
                                                                            'type'  =>'text',
                                                                            'value' =>'0.85', //value default
                                                                            'id'    =>$this->parameter['name_option'].'_opacity', 
                                                                            'name'  =>$this->parameter['name_option'].'_opacity',  
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    /*array(  'title' =>__('Opacity Background Color',$this->parameter['name_option']),
                                                                            'help'  =>'', 
                                                                            'type'  =>'color', 
                                                                            'value' =>'#FFF', // default
                                                                            'id'    =>$this->parameter['name_option'].'_opacity_bg',
                                                                            'name'  =>$this->parameter['name_option'].'_opacity_bg', 
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Border Width Popup:',$this->parameter['name_option']),  
                                                                            'help'  =>"Change border with popup",
                                                                            'type'  =>'range',
                                                                            'value' =>'5',
                                                                            'min'   =>'0',
                                                                            'max'   =>'5',
                                                                            'step'  =>'1',
                                                                            'id'    =>$this->parameter['name_option'].'_border_width', 
                                                                            'name'  =>$this->parameter['name_option'].'_border_width',  
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Border Color Popup:',$this->parameter['name_option']),  
                                                                            'help'  =>'', 
                                                                            'type'  =>'color', 
                                                                            'value' =>'#f2f2f2', // default
                                                                            'id'    =>$this->parameter['name_option'].'_border_bg',
                                                                            'name'  =>$this->parameter['name_option'].'_border_bg', 
                                                                            'class' =>'', 
                                                                            'row'   =>array('a','b')),*/

                                                                    array(  'title' =>__('Mobiles / Tablets:',$this->parameter['name_option']),  
                                                                            'help'  =>"If enabled, popup will show in mobiles, tablets, iphones, etc.",
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0',  
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_enabled_mobiles', 
                                                                            'name'  =>$this->parameter['name_option'].'_enabled_mobiles',  
                                                                            'class' =>'', //class
                                                                            'after' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('Show in:',$this->parameter['name_option']), //title section
                                                                            'help'  =>__('Where to show popup.',$this->parameter['name_option']), //descripcion section
                                                                            'type'  =>'checkbox', 
                                                                            'value' =>array('post','home'),
                                                                            'value_check'=>array('post','home'),
                                                                            'display'   =>'list', // list or horizontal
                                                                            'items' => array(
                                                                                                array('id'=>$this->parameter['name_option'].'_show_in',
                                                                                                      'value'=>'home',
                                                                                                      'text' =>__('Home',$this->parameter['name_option']),
                                                                                                      'help' => '' ),
                                                                                                array('id'=>$this->parameter['name_option'].'_show_in',
                                                                                                      'value'=>'post',
                                                                                                      'text' =>__('Post',$this->parameter['name_option']),
                                                                                                      'help' => '' ),
                                                                                                array('id'=>$this->parameter['name_option'].'_show_in',
                                                                                                      'value'=>'page',
                                                                                                      'text' =>__('Page',$this->parameter['name_option']),
                                                                                                      'help' => '' ),
                                                                                                array('id'=>$this->parameter['name_option'].'_show_in',
                                                                                                      'value'=>'everywhere',
                                                                                                      'text' =>__('Everywhere',$this->parameter['name_option']),
                                                                                                      'help' => '' ),
                                                                                            ),
                                                                             
                                                                            'id'    =>$this->parameter['name_option'].'_show_in', //id
                                                                            'name'  =>$this->parameter['name_option'].'_show_in', //name
                                                                            'class' =>'', //class
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Show only post specific:',$this->parameter['name_option']), //title section
                                                                            'help'  =>'Put separated by "comma" IDs which only want to display the popup only.',
                                                                            'type'  =>'tag',
                                                                            'value' =>'',
                                                                            'id'    =>$this->parameter['name_option'].'_'.'only_in_post', //id
                                                                            'name'  =>$this->parameter['name_option'].'_'.'only_in_post', //name
                                                                            'class' =>'',
                                                                            'placeholder' => 'Write the ID...',
                                                                            'row'   =>array('a','b')),
                                                                    
                                                                    array(  'title' =>__('Only login:',$this->parameter['name_option']),  
                                                                            'help'  =>"If enabled, Only the popup is displayed to users logged",
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0',  
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_only_login', 
                                                                            'name'  =>$this->parameter['name_option'].'_only_login',  
                                                                            'class' =>'', //class
                                                                            'after' =>'',
                                                                            'row'   =>array('a','b')),


                                                                    array(  'title' =>__('Clear Cookie:',$this->parameter['name_option']),  
                                                                            'help'  =>"If you already closed the popup and don't want to wait for 99 days, click this button to see the popup again.",
                                                                            'type'  =>'button',
                                                                            'value' =>'#', // URL
                                                                            'onclick'=>"return clearCookie('spushow');",
                                                                            'text_button'=>'Delete Cookie',
                                                                            'id'    =>$this->parameter['name_option'].'_reset_cookie', 
                                                                            'name'  =>$this->parameter['name_option'].'_reset_cookie',  
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),
                                                                            
                                                                    
                                                                    array(  'title' =>__('Exclude IP:',$this->parameter['name_option']),  
                                                                            'help'  =>"Put the IP do not want the popup appears, Place the IP to exclude separated by a comma ','",
                                                                            'type'  =>'textarea',
                                                                            'value' =>"xx.xxx.xx.xxx,xx.xxx.xxx.xx", // URL
                                                                            'id'    =>$this->parameter['name_option'].'_list_white', 
                                                                            'name'  =>$this->parameter['name_option'].'_list_white',  
                                                                            'class' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    array(  'title' =>__('No load script facebook:',$this->parameter['name_option']),  
                                                                            'help'  =>"If you have problems with the plugin and other social networking plugin can be a simultaneous load script facebook pampering with this option you can disable loading of this script so that it is not duplicated.",
                                                                            'type'  =>'checkbox',
                                                                            'value' =>'0',  
                                                                            'value_check'=>1,
                                                                            'id'    =>$this->parameter['name_option'].'_disabled_script', 
                                                                            'name'  =>$this->parameter['name_option'].'_disabled_script',  
                                                                            'class' =>'', //class
                                                                            'after' =>'',
                                                                            'row'   =>array('a','b')),

                                                                    
                                                )
                                        ),
                            'last_update'=>time(),


            );
        
    }

 

    function parameters(){
        
        //require_once 'assets/functions/options.php';
        //global $wp_social_pupup_header_plugins;

        //$this->parameter = $wp_social_pupup_header_plugins;
        $this->parameter = self::getHeaderPlugin();
    }

    function myoptions_build(){
        
        //require_once 'assets/functions/options.php';
        //global $wp_social_pupup_make_plugins;

        //$this->options = $wp_social_pupup_make_plugins;
        $this->options = self::getOptionsPlugin();

        return $this->options;
        
    }

    function use_components(){
        //code 
        $this->components = array();

    }

    function configuration_plugin(){
        // set parameter 
        self::parameters();

        // my configuration 
        self::myoptions_build();

        // my component to use
        self::use_components();
    }

}
}
?>