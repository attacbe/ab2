<?php
/* 
Plugin Name: WP Social Popup and Get Traffic
Plugin URI: https://wordpress.org/plugins/wp-social-popup-and-get-traffic/
Description: Show content for likes/follow/+1/Youtube
Version: 4.8.4
Author: iLen
Author URI: http://ilentheme.com
*/


if ( !class_exists('wp_social_popup') ):

// Load functions (from CORE)	
require_once 'assets/ilenframework/assets/lib/utils.php';

// Load plugin functions
require_once 'assets/functions/options.php';

/**
 * Initialization class of 'WP Social Popup and Get Traffic' Plugin.
 *
 * @package  WP_Social_Popup_and_Get_Traffic
 * @since	1.0.0
 */
class wp_social_popup extends wp_social_popup_make{
    
    var $is_mobile = null;

	/**
	 * Constructor
	 *
	 * @return  void
	 */
	function __construct(){
	   


		// configuration general
		parent::__construct();

		// only admin
		if( is_admin() ){

			// load script for admin panel
			add_action( 'admin_enqueue_scripts', array( &$this,'ss_wp_social_popup_admin' ) );

		}elseif( ! is_admin() ) { // if front-end (user public)

			global $opt_wp_social_popup, $print_script;

			// loads options plugin
			$opt_wp_social_popup = get_option( $this->parameter['name_option']."_options" );

			// validate if enabled popup
			if( ! $opt_wp_social_popup[$this->parameter['name_option'].'_enabled'] ) return false;


			// validate if current date is in range date
			if( ! self::validate_show_plugin_for_range_date() ) return false;

            // validate if exclude IP
            if( isset($opt_wp_social_popup[$this->parameter['name_option'].'_list_white']) && $opt_wp_social_popup[$this->parameter['name_option'].'_list_white'] ){

                $ip = $_SERVER['REMOTE_ADDR'];
                $list__while = explode( ",",$opt_wp_social_popup[$this->parameter['name_option'].'_list_white'] );

                if( in_array($ip,$list__while) ){
                    return false;
                }
                
            }

			// ajax nonce for count visits in cache (IF CACHE ACTIVE)
			if(  defined( 'WP_CACHE' ) && WP_CACHE && $opt_wp_social_popup[$this->parameter['name_option'].'_enabled'] ){

				// load script need for plugin worked
				self::add_actions_wsp();		    	
				add_action( 'wp_enqueue_scripts',  array( &$this, 'wp_social_popup_cache_enqueue') );
				add_action( 'wp_ajax_nopriv_wp-social-popup', array( &$this, 'print_pop_ajax' ) );
				add_action( 'wp_ajax_wp-social-popup', array( &$this, 'print_pop_ajax' ) );

			}elseif( $opt_wp_social_popup[$this->parameter['name_option'].'_enabled'] ){ // IF NO CACHE ACTIVE and Enabled popup

				// load script need for plugin worked
				self::add_actions_wsp();

				// return if mobile
				$this->is_mobile = self::is_MobileOrTable();


				/*if( $is_mobile && $opt_wp_social_popup[$this->parameter['name_option'].'_enabled_mobiles'] ){
					self::add_actions_wsp();
				}elseif( !$is_mobile ){
					self::add_actions_wsp();
				}*/

			}

		}

	}




	/**
	 * If ajax set variables globales js
	 *
	 * @return  void
	 */
	function wp_social_popup_cache_enqueue() {

		global $post,$opt_wp_social_popup;

		// if not cache active, return false;
		if( !defined( 'WP_CACHE' ) || !WP_CACHE ){
			return;
		}

		// set file spu_ajax.js in browser
		wp_enqueue_script( 'wp-social-popup-cache', plugin_dir_url( __FILE__ ) . 'assets/js/spu_ajax.js' , array( 'jquery' ), $this->parameter['version'] , true );

		// set/get variable javascript only for ajax setup (Only if any plugin cache active)
		wp_localize_script( 'wp-social-popup-cache', 'wp_popup_cache_var', array(   'admin_ajax_url' => admin_url( 'admin-ajax.php' ), 
			'enable'                  =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_enabled'])?$opt_wp_social_popup[$this->parameter['name_option'].'_enabled']:'', 
			'show_close_button'       =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_show_close_button'])?$opt_wp_social_popup[$this->parameter['name_option'].'_show_close_button']:'',
			'closed_advanced_keys'    =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_closed_advanced_keys'])?$opt_wp_social_popup[$this->parameter['name_option'].'_closed_advanced_keys']:'',
			'until_popup'             =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_until_popup'])?$opt_wp_social_popup[$this->parameter['name_option'].'_until_popup']:'',
			'seconds_appear'          =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_seconds_appear'])?$opt_wp_social_popup[$this->parameter['name_option'].'_seconds_appear']:'',
			'seconds_close'           =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_seconds_close'])?$opt_wp_social_popup[$this->parameter['name_option'].'_seconds_close']:'',
			'thanks_message'          =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_thanks_message'])?$opt_wp_social_popup[$this->parameter['name_option'].'_thanks_message']:'',
			'title_message'           =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_title_message'])?$opt_wp_social_popup[$this->parameter['name_option'].'_title_message']:'',
			'content_message'         =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_content_message'])?$opt_wp_social_popup[$this->parameter['name_option'].'_content_message']:'',
			'thanks_message_seconds'  =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_thanks_message_seconds'])?$opt_wp_social_popup[$this->parameter['name_option'].'_thanks_message_seconds']:'',
			
			'button_fb'               =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_button_fb'])?$opt_wp_social_popup[$this->parameter['name_option'].'_button_fb']:'',
			'facebook_url_default'    =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_default'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_default']:'',
			'facebook_url_tuesday'    =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_tuesday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_tuesday']:'',
			'facebook_url_wednesday'  =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_wednesday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_wednesday']:'',
			'facebook_url_thursday'   =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_thursday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_thursday']:'',
			'facebook_url_friday'     =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_friday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_friday']:'',
			'facebook_url_saturday'   =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_saturday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_saturday']:'',
			'facebook_url_sunday'     =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_sunday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_url_sunday']:'',
			'facebook_alt_1'          =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_alt_1'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_alt_1']:'',
			'facebook_alt_2'          =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_alt_2'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_alt_2']:'',
			'facebook_alt_3'          =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_facebook_alt_3'])?$opt_wp_social_popup[$this->parameter['name_option'].'_facebook_alt_3']:'',
			
			'button_tw'               =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_button_tw'])?$opt_wp_social_popup[$this->parameter['name_option'].'_button_tw']:'',
			'twitter_url_default'     =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_default'])?$opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_default']:'',
			'twitter_url_tuesday'     =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_tuesday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_tuesday']:'',
			'twitter_url_wednesday'   =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_wednesday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_wednesday']:'',
			'twitter_url_thursday'    =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_thursday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_thursday']:'',
			'twitter_url_friday'      =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_friday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_friday']:'',
			'twitter_url_saturday'    =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_saturday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_saturday']:'',
			'twitter_url_sunday'      =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_sunday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_sunday']:'',
			
			
			'button_go'               =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_button_go'])?$opt_wp_social_popup[$this->parameter['name_option'].'_button_go']:'',
			'google_url_default'      =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_google_url_default'])?$opt_wp_social_popup[$this->parameter['name_option'].'_google_url_default']:'',
			'google_url_tuesday'      =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_google_url_tuesday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_google_url_tuesday']:'',
			'google_url_wednesday'    =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_google_url_wednesday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_google_url_wednesday']:'',
			'google_url_thursday'     =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_google_url_thursday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_google_url_thursday']:'',
			'google_url_friday'       =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_google_url_friday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_google_url_friday']:'',
			'google_url_saturday'     =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_google_url_saturday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_google_url_saturday']:'',
			'google_url_sunday'       =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_google_url_sunday'])?$opt_wp_social_popup[$this->parameter['name_option'].'_google_url_sunday']:'',
			'type_button_gplus'       =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_type_button_gplus'])?$opt_wp_social_popup[$this->parameter['name_option'].'_type_button_gplus']:'',
			'button_youtube_suscribe' =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_button_youtube_suscribe'])?$opt_wp_social_popup[$this->parameter['name_option'].'_button_youtube_suscribe']:'',
			
			'opacity'                 =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_opacity'])?$opt_wp_social_popup[$this->parameter['name_option'].'_opacity']:'',
			'enabled_mobiles'         =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_enabled_mobiles'])?$opt_wp_social_popup[$this->parameter['name_option'].'_enabled_mobiles']:'',
			'show_in'                 =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_show_in'])?$opt_wp_social_popup[$this->parameter['name_option'].'_show_in']:'',
			'type_page_current'       => self::TypePost(),
			'type_campaign'           =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_type_campaign'])?$opt_wp_social_popup[$this->parameter['name_option'].'_type_campaign']:'',
			'date_end'                =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_date_end'])?$opt_wp_social_popup[$this->parameter['name_option'].'_date_end']:'',
			'only_login'              =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_only_login'])?$opt_wp_social_popup[$this->parameter['name_option'].'_only_login']:'',
			'if_only_login'           =>is_user_logged_in()?1:0,
            'button_like_post'        =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_like_post'])?$opt_wp_social_popup[$this->parameter['name_option'].'_like_post']:'',
            'button_like_post_url'    =>get_permalink(),
            'ip_machine'			  =>$_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']),
            'exclude_ip'			  =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_list_white'])?$opt_wp_social_popup[$this->parameter['name_option'].'_list_white']:'',
            'only_in_post'			  =>isset($opt_wp_social_popup[$this->parameter['name_option'].'_only_in_post'])?$opt_wp_social_popup[$this->parameter['name_option'].'_only_in_post']:'',
            'post_current'			  =>isset($post) && $post?$post->ID:'',
		) );


	}



	/**
	 * Get if home or user in type post
	 *
	 * @return  string
	 */
	function TypePost(){

		if( is_home() ){ return 'home'; }
		elseif( in_array( $type = get_post_type() , array('post','page') ) ){ return $type; }
		else { return ''; }

	}
 



 
	/**
	 * Validate if print script
	 *
	 * @return  void
	 */
	function print_scripts(){

		global $opt_wp_social_popup,$print_script;
 
		// validate popup only login
		//if(  isset($opt_wp_social_popup[$this->parameter['name_option'].'_only_login']) && $opt_wp_social_popup[$this->parameter['name_option'].'_only_login'] && !is_user_logged_in()  ){ return false; }

		// validate if plugin cache is active
		/*if( defined( 'WP_CACHE' ) && WP_CACHE ){
			add_action('wp_enqueue_scripts', array( &$this,'ss_wp_social_popup') );
		}else{*/

		// get array when show popup
		$array_show_in = $opt_wp_social_popup[$this->parameter['name_option'].'_show_in'];
		$print_script = false;

		/**
		* Validate page to show
		* set @var $print_script = true if accoding
		*/
        
        
		if( in_array( 'everywhere', $array_show_in ) ){
            $print_script = true;
		} 

		if( in_array( 'home' , $array_show_in ) && $print_script == false ){
			if( is_home() || is_front_page() ){
				$print_script = true;
			}
		} 

		if( in_array( 'post' , $array_show_in ) && $print_script == false ){
			if( is_single() ){
				$print_script = true;
			}
		}

		if( in_array( 'page' , $array_show_in ) && $print_script == false ){
			if( is_page() ){
				$print_script = true;
			}
		}


		// If $print_script is TRUE then loads script to show popup
		//if( $print_script == true ) {
			add_action('wp_enqueue_scripts', array( &$this,'ss_wp_social_popup'), 20 );
		//}
	//}

	}


	

	/**
	 * Load scripts and styles
	 *
	 * @return  void
	 */
	function ss_wp_social_popup(){

		global $opt_wp_social_popup;


		// verify if specific post
		if( self::only_specific_post() == false ) return false;

		// load script networking
		//wp_enqueue_script('wsp-fb', 'http://connect.facebook.net/en_US/all.js#version=v2.0', array('jquery'),$this->parameter['version'],FALSE);
		if( isset($opt_wp_social_popup[$this->parameter['name_option'].'_disabled_script']) && $opt_wp_social_popup[$this->parameter['name_option'].'_disabled_script'] == 1 ){
			null;
		}else{
			wp_enqueue_script('wsp-fb', 'http://connect.facebook.net/en_US/all.js#xfbml=1', array('jquery'),$this->parameter['version'],FALSE);
		}

		wp_enqueue_script('wsp-tw', 'http://platform.twitter.com/widgets.js', array('jquery'),$this->parameter['version'],FALSE);
		wp_enqueue_script('wsp-social', plugins_url( 'assets/js/spu.js' , __FILE__ ),array('jquery'),$this->parameter['version'],TRUE);

		// Load style of popup
		wp_enqueue_style('wsp-css', plugins_url( 'assets/css/spu.css' , __FILE__ ),'all',$this->parameter['version']);

		/**
		*	Load script google plus if no active plugin CACHE
		*	If the cache plugin is active on google script is loaded using javascript in spu_ajax.js file
		*/
		if(  ! defined( 'WP_CACHE' ) || ! WP_CACHE ){
			wp_enqueue_script('wsp-go', 'https://apis.google.com/js/plusone.js', array('jquery'),$this->parameter['version'],FALSE);
		}

		// If RTL load style for browser RTL
		if( is_rtl() ){
			wp_enqueue_style('wsp-css-rtl', plugins_url( 'assets/css/spu-rtl.css' , __FILE__ ),'all',$this->parameter['version']);
		}
	}




	/**
	 * Load scripts and styles in footer
	 *
	 * @return  void
	 */
	function print_scripts_footer(){

		global $opt_wp_social_popup,$print_script;

		// verify if specific post
		if( self::only_specific_post() == false ) return false;

		// Validate if login and not login
		if(  isset($opt_wp_social_popup[$this->parameter['name_option'].'_only_login']) && $opt_wp_social_popup[$this->parameter['name_option'].'_only_login'] && !is_user_logged_in()  ){ return false; }

		// This no shows
		$credit = isset($opt_wp_social_popup[$this->parameter['name_option'].'_credits'])?$opt_wp_social_popup[$this->parameter['name_option'].'_credits']:'';

		/**
		*	Load the script in the footer to run the popup
		*/
		if( $print_script ){
		?>							
<script type="text/javascript">
jQuery(document).ready(function($){
setTimeout( 
	function(){				
		socialPopupTrafic({
		// Configure display of popup
		advancedClose: <?php echo ($opt_wp_social_popup[$this->parameter['name_option'].'_closed_advanced_keys']?'true':'false'); ?>,
		opacity: "<?php echo $opt_wp_social_popup[$this->parameter['name_option'].'_opacity']; ?>",
		s_to_close: "<?php echo $opt_wp_social_popup[$this->parameter['name_option'].'_seconds_close']; ?>",
		days_no_click: "<?php echo $opt_wp_social_popup[$this->parameter['name_option'].'_until_popup']; ?>",
		until_date: "<?php echo isset($opt_wp_social_popup[$this->parameter['name_option'].'_date_end'])?$opt_wp_social_popup[$this->parameter['name_option'].'_date_end']:null; ?>",
		type_campaign: "<?php echo isset($opt_wp_social_popup[$this->parameter['name_option'].'_type_campaign'])?$opt_wp_social_popup[$this->parameter['name_option'].'_type_campaign']:2; ?>",
		segundos : "<?php echo 'seconds'; ?>",
		esperar : "<?php echo 'Wait'; ?>",
		thanks_msg : "<?php echo $opt_wp_social_popup[$this->parameter['name_option'].'_thanks_message'];  ?>",
		thanks_sec : "<?php echo $opt_wp_social_popup[$this->parameter['name_option'].'_thanks_message_seconds']; ?>"
		})
	}
	,<?php echo (int)$opt_wp_social_popup[$this->parameter['name_option'].'_seconds_appear'] * 1000 ;?>
);
});	
		</script>
		<?php
		}
	}



	/**
	 * Load styles in footer
	 * This apparently fixes some problems with some websites that facebook like button is not displayed,
	 * but this code is still in testing.
	 *
	 * @return  void
	 */
	function print_pop_fix_css_button_like(){
	   global $opt_wp_social_popup; 
       ?>
<style>
/*.fb_iframe_widget span
iframe.fb_iframe_widget_lift,
.fb_iframe_widget iframe  {
    width:80px !important; 
    height:20px !important;
    position:relative;
}*/
</style>
	<?php }





	/**
	 * Load styles and script for admin
	 *
	 * @return  void
	 */
	function ss_wp_social_popup_admin(){
		wp_enqueue_script( 'wp_social_popup_js', plugins_url('assets/js/plugin.js',__FILE__), array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'wp_social_popup_css_admin', plugins_url('assets/css/admin.css',__FILE__),'all',$this->parameter['version']);
	}


 
	/**
	 * Print popup html markup in footer
	 *
	 * @return  html
	 */
	function print_pop(){

		global $opt_wp_social_popup,$print_script;


		if( self::only_specific_post() == false ) return false;

		// Validate if login and not login
		if(  isset($opt_wp_social_popup[$this->parameter['name_option'].'_only_login']) && $opt_wp_social_popup[$this->parameter['name_option'].'_only_login'] && !is_user_logged_in()  ){ return false; }

		// This no shows
		$credit = isset($opt_wp_social_popup[$this->parameter['name_option'].'_credits'])?$opt_wp_social_popup[$this->parameter['name_option'].'_credits']:'';

		// if TRUE print script popup
		if( $print_script ){

			$socials = array();

			// get number of day
			$suf_day = self::getItembyDay();

			// reset array variable
			$social_button_set = "";
			$socials["youtube"] = "";
			$socials["google"] = "";
			$socials["twitter"] = "";
			$socials["facebook"] = "";
				

			/**
			*	Build social buttons
			*/
			//--YOUTUBE
			if( isset( $opt_wp_social_popup[$this->parameter['name_option']."_button_youtube_suscribe"] ) && $opt_wp_social_popup[$this->parameter['name_option']."_button_youtube_suscribe"] ){
				$socials["youtube"] ='<div class="g-ytsubscribe" data-channel="'.$opt_wp_social_popup[$this->parameter['name_option']."_button_youtube_suscribe"].'" data-layout="full" data-count="undefined"></div>';
			}
				
			//--GOOGLE
			if( $opt_wp_social_popup[$this->parameter['name_option']."_button_go"] == '1' ){
				$type_g = $opt_wp_social_popup[$this->parameter['name_option']."_type_button_gplus"] == "button"?"g-plusone":"g-plus";
				if( ! $social_button_set = $opt_wp_social_popup[$this->parameter['name_option']."_google_url_{$suf_day}"] ){
					if( $social_button_set = $opt_wp_social_popup[$this->parameter['name_option']."_google_url_default"] ){
						$socials["google"] ='<div class="spu-button spu-google"><div class="'.$type_g.'" data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="bubble" data-size="medium" data-href="' . $social_button_set . '" width="300" height="69"></div></div>'; 
					}else{
						$socials["google"] = "";
					}
				}else{
					$socials["google"] ='<div class="spu-button spu-google"><div class="'.$type_g.'" data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="bubble" data-size="medium" data-href="' . $social_button_set . '" width="300" height="69"></div></div>'; 
				}
			}

			//--TWITTER
			$social_button_set = "";
			if( $opt_wp_social_popup[$this->parameter['name_option']."_button_tw"] == '1' )
				if( ! $social_button_set = $opt_wp_social_popup[$this->parameter['name_option']."_twitter_url_{$suf_day}"] )
					if( $social_button_set = $opt_wp_social_popup[$this->parameter['name_option']."_twitter_url_default"] )
						$socials["twitter"] ='<div class="spu-button spu-twitter"><a href="https://twitter.com/' . $opt_wp_social_popup[$this->parameter['name_option'].'_twitter_url_default'] . '" class="twitter-follow-button" data-show-count="false" >Follow Me</a></div>'; 
					else
						$socials["twitter"] = "";
				else
					$socials["twitter"] ='<div class="spu-button spu-twitter"><a href="https://twitter.com/' . $social_button_set . '" class="twitter-follow-button" data-show-count="false" >Follow Me</a></div>'; 

			//--FACEBOOK
			$social_button_set = "";
			if( $opt_wp_social_popup[$this->parameter['name_option']."_button_fb"] == '1' ){
				if( ! $social_button_set = $opt_wp_social_popup[$this->parameter['name_option']."_facebook_url_{$suf_day}"] ){
					if( $social_button_set = $opt_wp_social_popup[$this->parameter['name_option']."_facebook_url_default"] ){
						$socials["facebook"] = '<div class="spu-button spu-facebook"><div class="fb-like" data-href="' . $social_button_set . '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>'; 
					}else{
						$socials["facebook"] = "";
					}
				}else{
					$socials["facebook"] = '<div class="spu-button spu-facebook"><div class="fb-like" data-href="' . $social_button_set . '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>'; 
				}
			}


			// Set variable facebook
			$alt_fb1 = isset($opt_wp_social_popup[$this->parameter['name_option']."_facebook_alt_1"])?$opt_wp_social_popup[$this->parameter['name_option']."_facebook_alt_1"]:"";
			$alt_fb2 = isset($opt_wp_social_popup[$this->parameter['name_option']."_facebook_alt_2"])?$opt_wp_social_popup[$this->parameter['name_option']."_facebook_alt_2"]:"";
			$alt_fb3 = isset($opt_wp_social_popup[$this->parameter['name_option']."_facebook_alt_3"])?$opt_wp_social_popup[$this->parameter['name_option']."_facebook_alt_3"]:"";

			// Set number of button facebook (Max 4)
			$all_alt_like = "";
			if( $alt_fb1 || $alt_fb2 || $alt_fb3 ){
					
					if( $alt_fb1 ){
							$alt_fb1_text = '<div class="spu-button spu-facebook"><div class="fb-like" data-href="' . $alt_fb1 . '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
					}
					if( $alt_fb2 ){
							$alt_fb2_text = '<div class="spu-button spu-facebook"><div class="fb-like" data-href="' . $alt_fb2 . '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
					}
					if( $alt_fb3 ){
							$alt_fb3_text = '<div class="spu-button spu-facebook"><div class="fb-like" data-href="' . $alt_fb3 . '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
					}

					$all_alt_like = $alt_fb1_text.$alt_fb2_text.$alt_fb3_text;
			}
            
            // show the LIKE post
            if( isset($opt_wp_social_popup[$this->parameter['name_option']."_button_fb"]) && $opt_wp_social_popup[$this->parameter['name_option']."_like_post"] == 1 ){
                
                $all_alt_like = $all_alt_like.'<div class="spu-button spu-facebook"><div class="fb-like" data-href="' . get_permalink() . '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
                
            }


			// Print final popup
            $class_mobile = ($this->is_mobile)?"popup_mobile":"";
			echo '<div id="spu-bg"></div><div id="spu-main"  class="'.$class_mobile.'">';
					echo $opt_wp_social_popup[$this->parameter['name_option'].'_show_close_button'] ? '<a href="#" onClick="spuFlush('. $opt_wp_social_popup[$this->parameter['name_option'].'_until_popup'] .');" id="spu-close">✕</a>' : '';
					echo '<div id="spu-body">';
					echo "<div id='spu-title'>".$opt_wp_social_popup[$this->parameter['name_option'].'_title_message']."</div>
							<div id='spu-msg-cont'>
									 <div id='spu-msg'>
									 <p>".$opt_wp_social_popup[$this->parameter['name_option'].'_content_message']."</p>
									 <br />
															 <div class='main_like_wsp'>{$socials["facebook"]}</div>
															 <div>$all_alt_like</div>
									 {$socials["youtube"]} {$socials["twitter"]} {$socials["google"]}
									 </div>
									<div class='step-clear'></div>
							</div>";
					echo '<span id="spu-timer"></span>';
			echo ( $credit ) ? '<div id="spu-bottom"><span style="font-size:10px;float: right;margin-top: -6px;">Social Popup by <a href="http://www.ilentheme.com">iLen</a></span></div>':'';
					echo "</div>";
			echo '</div>';
			echo "<input type='hidden' name='hd_msg_thanks' id='hd_msg_thanks' value='".$opt_wp_social_popup[$this->parameter['name_option'].'_thanks_message']."' />";
			echo "<style>#spu-bg{background:#fff;}#spu-main{ display:none; }</style>";
		}
	}




 
	/**
	 * Print popup html markup in footer AJAX
	 *
	 * @return  html
	 */
	function print_pop_ajax(){ 

		global $opt_wp_social_popup;

		/**
		* ONLY FOR AJAX
		* 	For buttons of google when having activated any cache plugin has some errors, 
		*	to correct this part was created.
		*/
		$type_g = $opt_wp_social_popup[$this->parameter['name_option']."_type_button_gplus"] == "button"?"g-plusone":"g-plus";
		$social_button_set = $opt_wp_social_popup[$this->parameter['name_option']."_google_url_default"];
		echo ' <!-- Inserta esta etiqueta en la sección "head" o justo antes de la etiqueta "body" de cierre. -->
				<script src="https://apis.google.com/js/platform.js" async defer>
					{lang: "es", parsetags: "explicit"}
				</script>';
		echo '<div style="display:none" class="put_gplus"><div class="'.$type_g.' " data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="bubble" data-size="medium" data-href="'.$social_button_set.'" width="300" height="69"></div></div>';
		echo '<div class="put_youtube" style="display:none"><div class="g-ytsubscribe" data-channel="'.$opt_wp_social_popup[$this->parameter['name_option']."_button_youtube_suscribe"].'" data-layout="full" data-count="undefined"></div></div>';
		echo "<div id='wp_social_popup_and_get_traffic'></div>";

	}





	/**
	 * Get number and text week
	 *
	 * @return  array
	 */
	function getItembyDay(){	
		
		// array day week
		$dayNames = array(
				1=>'default',
				2=>'tuesday', 
				3=>'wednesday', 
				4=>'thursday', 
				5=>'friday', 
				6=>'saturday', 
				7=>'sunday', 
		 );

		// Numeric representation of the day of the week
		$daynum = date("N", time());

		return $dayNames[ $daynum ];
	}






	/**
	 * Get if mobile or tablet
	 *
	 * @return boolean
	 */
	function is_MobileOrTable(){
		
		// Load library
		require_once "assets/ilenframework/assets/lib/Mobile_Detect.php";

		// Execute
		$detect = new Mobile_Detect;

		// validate
		if( $detect->isMobile() || $detect->isTablet() ){
			return true;
		}else{
			return false;
		}

	}





	/**
	 * Load FROND-END action to show popup plugin
	 *
	 * @return void
	 */
	function add_actions_wsp(){

		if(  ! defined( 'WP_CACHE' ) || ! WP_CACHE ){

			add_action( 'wp_head', array( &$this,'add_fb_script'),12);

            if( empty($_COOKIE['spushow']) || !$_COOKIE['spushow'] ){

    			add_action( 'wp_footer', array( &$this,'print_scripts_footer'),13);
    			add_action( 'wp_footer',array(&$this,'print_pop' ),14 );
            }

		}else{
		  
			add_action( 'wp_footer',array(&$this,'print_pop_ajax' ) );
		}
		
		// Load script in footer page
		add_action('template_redirect', array(&$this,'print_scripts'), 12 );
		add_action( 'wp_footer',array(&$this,'print_pop_fix_css_button_like' ),50 );
		
	}




	/**
	 * Validates days in case the user lifted type 'campaign'
	 *
	 * @return boolena
	 */
	function validate_show_plugin_for_range_date(){

		global $opt_wp_social_popup,$if_utils;
		
		$diff = null;

		/**
		* Validates if type 'campaign' to send 'TRUE' if appropriate in the rago days 
		* and 'FALSE' if already passed date.
		*/
		if( isset($opt_wp_social_popup[$this->parameter['name_option'].'_type_campaign']) && $opt_wp_social_popup[$this->parameter['name_option'].'_type_campaign'] == 1 ){ 

			// Get current date	
			$date_now = date("Y-m-d");

			// Gets the deadline choosen by the user
			$date_until = $opt_wp_social_popup[$this->parameter['name_option'].'_date_end'];

			
			$diff = $if_utils->IF_dateDifference($date_now,$date_until);

		}

		if( $diff && $diff <= 0 ){
			return false;
		}else{
			return true;
		}

	}

	/**
	 * Facebook add the script in the header of the website
	 *
	 * @return html
	 */
	function add_fb_script(){

		/*echo '
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3";
fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>';*/

	}


	/**
	 * Checks whether specific post only show in these and not to show elsewhere.
	 *
	 * @return boolean
	 */
	function only_specific_post(){

		global $opt_wp_social_popup,$post;

		$only_post = array();

		// validate if tags exclude custom
		if( isset($post) && $post && isset($opt_wp_social_popup[$this->parameter['name_option'].'_only_in_post']) && $opt_wp_social_popup[$this->parameter['name_option'].'_only_in_post'] ){

			//  verify
			$only_post = explode(",",$opt_wp_social_popup[$this->parameter['name_option'].'_only_in_post']);

			if( in_array( $post->ID, $only_post  ) ){
				return true;
			}else{
				return false;
			}

		}else{
			return true;
		}
	}




} // end class
endif; // end if


global $IF_CONFIG;
unset($IF_CONFIG);
$IF_CONFIG = null;
$IF_CONFIG = new wp_social_popup;
require_once "assets/ilenframework/core.php";
?>