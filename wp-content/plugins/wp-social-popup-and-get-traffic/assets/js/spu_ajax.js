var spu_count = 0;
var spu_counter ='';
var isMobile = function() {

        if( navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
        ){
            return true;
        }
        else {
            return false;
        }
}
	function socialPopupTrafic(options) {
		var defaults = { days_no_click : "10" };
		var options = jQuery.extend(defaults, options);
		window.options = options;




		if( window.options.only_login && window.options.if_only_login == 0 ){ return; }

 
		var cook = readCookie('spushow');
		var waitCook = readCookie('spuwait');

		if (cook != 'true') {
			var windowWidth = document.documentElement.clientWidth;
			var windowHeight = document.documentElement.clientHeight;
			var popupHeight = jQuery("#spu-main").height();
			var popupWidth = jQuery("#spu-main").width();
			jQuery("#spu-main").css({
				"position": "fixed",
				"top": (windowHeight / 2 - popupHeight / 2) - 100,
				"left": windowWidth / 2 - popupWidth / 2
			});
			jQuery("#spu-bg").css({
				"height": windowHeight + 30
			});
			jQuery("#spu-bg").css({
				"opacity": options.opacity
			});
			jQuery("#spu-bg").fadeIn("slow");
			jQuery("#spu-main").fadeIn("slow");
            
            if( isMobile() ){
                jQuery("#spu-main").addClass("popup_mobile");    
            }
            
		}
		
		if (options.advancedClose == true) {
			jQuery(document).keyup(function(e) {
				if (e.keyCode == 27) {
					spuFlush(options.days_no_click);
				}
			});
			var ua = navigator.userAgent,
			event = (ua.match(/iPad/i) || ua.match(/iPhone/i)) ? "touchstart" : "click";
			
			jQuery('body').on(event, function (ev) {
				
				spuFlush(options.days_no_click);
			});
			jQuery('#spu-main').click(function(event) {
				event.stopPropagation();
			});
		}
		if( parseInt(options.s_to_close) > 0 )
		{
			spu_count=options.s_to_close;
			spu_counter = setInterval(function(){spu_timer(options)}, 1000);
		}
		return true;
	}

function thanks_msg(options){

	if( options.thanks_msg){
		//I add some delay because twitter is not completing follow event
		setTimeout(function(){
			jQuery('#spu-msg-cont').hide().html(options.thanks_msg).fadeIn();
		}, 500);
	}
	setTimeout(function(){ spuFlush(options.days_no_click)}, 1000 * options.thanks_sec);
}


jQuery(document).ready(function(){

});
function twitterCB(intent_event) {
	thanks_msg(window.options);
	console.log(new Date(), "Sweett, tweet callback: ", intent_event);
	//alert( jQuery("#hd_msg_thanks").val() );
}

function googleCB(a) {
	clearInterval(spu_counter);
	if( "on" == a.state )
	{
	 	setTimeout(function(){thanks_msg(window.options)},2500);
	}

}
function closeGoogle(a){
	if( "confirm" == a.type )
	{
	setTimeout(function(){thanks_msg(window.options)},2500);
	}
}

function spuFlush( days ) {
	days = typeof days !== 'undefined' ? days : 99;

	if( !window.options.type_campaign || window.options.type_campaign == 2 ){

		days = days;

	}else if( window.options.type_campaign ==1 ){

		var date_plugin       = window.options.until_date;
		var date_plugin_array = date_plugin.split('-');
		var until_date        = date_plugin_array[0]+"/"+date_plugin_array[1]+"/"+date_plugin_array[2];
		//--------------------------------
		var d                 = new Date();
		var curr_date         = d.getDate();
		var curr_month        = d.getMonth() + 1; //Months are zero based
		var curr_year         = d.getFullYear();
		//---------------------------------
		var now_date          = curr_year+"/"+ gtp_padLeft(curr_month,2,"0") +"/"+curr_date;

		var day_diff = gtp_mydiff(now_date,until_date,'days');
		if( day_diff == NaN || day_diff == undefined ){
			days = 1;	
		}else{
			days = day_diff;	
		}
		

	}

	createCookie('spushow', 'true', days);
	
	jQuery("#spu-bg").fadeOut("slow");
	jQuery("#spu-main").fadeOut("slow");

}

function createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	} else var expires = "";
	document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}
function spu_timer(defaults)
{
  spu_count=spu_count-1;
  if (spu_count <= 0)
  {
     clearInterval(spu_counter);
     spuFlush(defaults.days_no_click);
     return;
  }

 jQuery("#spu-timer").html(defaults.esperar+" "+spu_count + " " + defaults.segundos);
}


function in_array(needle, haystack) {
    for(var i in haystack) {
        if(haystack[i] == needle) return true;
    }
    return false;
}


// link: http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript#comment12872595_544429
function gtp_mydiff(date1,date2,interval) {
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
    date1 = new Date(date1);
    date2 = new Date(date2);
    var timediff = date2 - date1;
    if (isNaN(timediff)) return NaN;
    switch (interval) {
        case "years": return date2.getFullYear() - date1.getFullYear();
        case "months": return (
            ( date2.getFullYear() * 12 + date2.getMonth() )
            -
            ( date1.getFullYear() * 12 + date1.getMonth() )
        );
        case "weeks"  : return Math.floor(timediff / week);
        case "days"   : return Math.floor(timediff / day); 
        case "hours"  : return Math.floor(timediff / hour); 
        case "minutes": return Math.floor(timediff / minute);
        case "seconds": return Math.floor(timediff / second);
        default: return undefined;
    }
}

function gtp_padLeft(nr, n, str){
    return Array(n-String(nr).length+1).join(str||'0')+nr;
}



// link: http://phpjs.org/functions/in_array/
function in_array(needle, haystack, argStrict) {
  //  discuss at: http://phpjs.org/functions/in_array/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: vlado houba
  // improved by: Jonas Sciangula Street (Joni2Back)
  //    input by: Billy
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //   example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
  //   returns 1: true
  //   example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
  //   returns 2: false
  //   example 3: in_array(1, ['1', '2', '3']);
  //   example 3: in_array(1, ['1', '2', '3'], false);
  //   returns 3: true
  //   returns 3: true
  //   example 4: in_array(1, ['1', '2', '3'], true);
  //   returns 4: false

  var key = '',
    strict = !! argStrict;

  //we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
  //in just one for, in order to improve the performance 
  //deciding wich type of comparation will do before walk array
  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}


jQuery(document).ready(function($){


	if( ! wp_popup_cache_var.enable ) return;
	if( isMobile() && ! wp_popup_cache_var.enabled_mobiles ) return;
	if( wp_popup_cache_var.only_login && wp_popup_cache_var.if_only_login == 0 ){ return; }

	// specific post
	if( wp_popup_cache_var.only_in_post ){
		var array_only_in_post = wp_popup_cache_var.only_in_post;
		var array_specific_posts = array_only_in_post.split(",");
		if( wp_popup_cache_var.only_in_post && !in_array( wp_popup_cache_var.post_current, array_specific_posts ) ){ return; }
	}

	// exclude ip
	var array_exclude_ip = wp_popup_cache_var.exclude_ip;
	var array_ips = array_exclude_ip.split(",");
	if( wp_popup_cache_var.exclude_ip && in_array( wp_popup_cache_var.ip_machine, array_ips ) ){ return; }


	FB.Event.subscribe('edge.create', function(href) {
		clearInterval(spu_counter);
		thanks_msg(window.options);
	});
	if (typeof twttr !== 'undefined') {
		twttr.ready(function(twttr) {
			clearInterval(spu_counter);
			twttr.events.bind('tweet', twitterCB);
			twttr.events.bind('follow', twitterCB);
		}); 
	}

	if( wp_popup_cache_var.type_campaign == 1 ){

		var date_plugin       = wp_popup_cache_var.date_end;
		var date_plugin_array = date_plugin.split('-');
		var until_date        = date_plugin_array[0]+"/"+date_plugin_array[1]+"/"+date_plugin_array[2];
		//--------------------------------
		var d                 = new Date();
		var curr_date         = d.getDate();
		var curr_month        = d.getMonth() + 1; //Months are zero based
		var curr_year         = d.getFullYear();
		//---------------------------------
		var now_date          = curr_year+"/"+ gtp_padLeft(curr_month,2,"0") +"/"+curr_date;

		var day_diff = gtp_mydiff(now_date,until_date,'days');
		//alert(now_date+" "+date_plugin+" "+day_diff);
		if( day_diff == NaN || day_diff == undefined || day_diff <= 0 ){

			return;
		}

	}



	var lets_popup = false;
	if( wp_popup_cache_var.type_page_current == 'everywhere' ){
		lets_popup = true;
	}else if( wp_popup_cache_var.type_page_current == 'post' ){
		if( !in_array( 'post',wp_popup_cache_var.show_in ) ){
			lets_popup = false;
		}else{
			lets_popup = true;
		}
	}else if( wp_popup_cache_var.type_page_current == 'page' ){
		if( !in_array( 'page',wp_popup_cache_var.show_in ) ){
			lets_popup = false;
		}else{
			lets_popup = true;
		}	
	}else if( wp_popup_cache_var.type_page_current == 'home' ){
		if( !in_array( 'home',wp_popup_cache_var.show_in ) ){
			lets_popup = false;
		}else{
			lets_popup = true;
		}
	}

	if( wp_popup_cache_var.enable && lets_popup ){

		setTimeout( 
			function(){				
				
				var html_pure = "";
				var html_youtube = "";
				var html_google = "";
				var html_twitter="";
				var html_facebook="";

				var date_current = new Date();
				var day = date_current.getDay();

				// google days url
				var button_google = [];
				button_google[1] = wp_popup_cache_var.google_url_default;
				button_google[2] = wp_popup_cache_var.google_url_tuesday;
				button_google[3] = wp_popup_cache_var.google_url_wednesday;
				button_google[4] = wp_popup_cache_var.google_url_thursday;
				button_google[5] = wp_popup_cache_var.google_url_friday;
				button_google[6] = wp_popup_cache_var.google_url_saturday;
				button_google[0] = wp_popup_cache_var.google_url_sunday;

				// twitter days url
				var button_twitter = [];
				button_twitter[1] = wp_popup_cache_var.twitter_url_default;
				button_twitter[2] = wp_popup_cache_var.twitter_url_tuesday;
				button_twitter[3] = wp_popup_cache_var.twitter_url_wednesday;
				button_twitter[4] = wp_popup_cache_var.twitter_url_thursday;
				button_twitter[5] = wp_popup_cache_var.twitter_url_friday;
				button_twitter[6] = wp_popup_cache_var.twitter_url_saturday;
				button_twitter[0] = wp_popup_cache_var.twitter_url_sunday;

				// facebook days url
				var button_facebook = [];
				button_facebook[1] = wp_popup_cache_var.facebook_url_default;
				button_facebook[2] = wp_popup_cache_var.facebook_url_tuesday;
				button_facebook[3] = wp_popup_cache_var.facebook_url_wednesday;
				button_facebook[4] = wp_popup_cache_var.facebook_url_thursday;
				button_facebook[5] = wp_popup_cache_var.facebook_url_friday;
				button_facebook[6] = wp_popup_cache_var.facebook_url_saturday;
				button_facebook[0] = wp_popup_cache_var.facebook_url_sunday;

				var fb_alt_1 = "";
				var fb_alt_2 = "";
				var fb_alt_3 = "";

				var fb_alt_text_1 = "";
				var fb_alt_text_2 = "";
				var fb_alt_text_3 = "";
                var fb_alt_text_4 = "";

				fb_alt_1 = wp_popup_cache_var.facebook_alt_1;
				fb_alt_2 = wp_popup_cache_var.facebook_alt_2;
				fb_alt_3 = wp_popup_cache_var.facebook_alt_3;
				if( fb_alt_1 || fb_alt_2 || fb_alt_3 ){
					if( fb_alt_1 ){
						fb_alt_text_1 = '<div class="spu-button spu-facebook"><div id="fb-root"></div><div class="fb-like" data-href="' +wp_popup_cache_var.facebook_alt_1+ '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
					}
					if( fb_alt_2 ){
						fb_alt_text_2 = '<div class="spu-button spu-facebook"><div id="fb-root"></div><div class="fb-like" data-href="' +wp_popup_cache_var.facebook_alt_2+ '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';	
					}
					if( fb_alt_3 ){
						fb_alt_text_3 = '<div class="spu-button spu-facebook"><div id="fb-root"></div><div class="fb-like" data-href="' +wp_popup_cache_var.facebook_alt_3+ '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';		
					}
					
				}
                
                if( wp_popup_cache_var.button_like_post ){
                    fb_alt_text_4 = '<div class="spu-button spu-facebook"><div id="fb-root"></div><div class="fb-like" data-href="' +wp_popup_cache_var.button_like_post_url+ '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
                }
				


				if( wp_popup_cache_var.button_youtube_suscribe ){

					html_youtube = '<div id="button_youtube" style="display: inline-block;"><div class="g-ytsubscribe" data-channel="'+wp_popup_cache_var.button_youtube_suscribe+'" data-layout="full" data-count="undefined"></div></div>';

				}

				if( wp_popup_cache_var.button_go ){
					if( wp_popup_cache_var.type_button_gplus == 'button' ){
						type_button_google = "g-plusone"; 
					}else{
						type_button_google = "g-plus";
					}

					if( !button_google[day] ){
						if( button_google[1] ){
						  
							html_google = '<div id="spu-google" class="spu-button spu-google" style="display: inline-block;"></div>'; //<div id="spu-google" class="spu-button spu-google" style="display: inline-block;"><div class="'+type_button_google+'" data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="bubble" data-size="medium" data-href="'+button_google[1]+'" width="300" height="69" ></div>';
						}
					}else{
					   
						html_google = '<div id="spu-google" class="spu-button spu-google" style="display: inline-block;"></div>';//<div id="spu-google" class="spu-button spu-google"><div class="'+type_button_google+'" data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="bubble" data-size="medium" data-href="'+button_google[day]+'" width="300" height="69"></div></div>';
					}
				}


				if( wp_popup_cache_var.button_tw ){

					if( !button_twitter[day] ){
						if( button_twitter[1] ){
							html_twitter = '<div class="spu-button spu-twitter"><a href="https://twitter.com/'+button_twitter[1]+'" class="twitter-follow-button" data-show-count="false" >Follow Me</a></div>';
						}
					}else{
						html_twitter = '<div class="spu-button spu-twitter"><a href="https://twitter.com/'+button_twitter[day]+'" class="twitter-follow-button" data-show-count="false" >Follow Me</a></div>';
					}
				}


				if( wp_popup_cache_var.button_fb ){
 
					if( !button_facebook[day] ){
						if( button_facebook[1] ){
							html_facebook = '<div class="spu-button spu-facebook"><div id="fb-root"></div><div class="fb-like" data-href="' +button_facebook[1]+ '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
						}
					}else{
						html_facebook = '<div class="spu-button spu-facebook"><div id="fb-root"></div><div class="fb-like" data-href="' +button_facebook[day]+ '" data-send="false" data-width="450" data-show-faces="true"data-layout="button_count"></div></div>';
					}
				}




				html_pure +='<div id="spu-bg"></div>';
				html_pure +='<div id="spu-main">';
				if( wp_popup_cache_var.show_close_button ){
					html_pure += '<a href="#" onClick="spuFlush('+wp_popup_cache_var.until_popup+');" id="spu-close">✕</a>';					
				}

				html_pure +='<div id="spu-body">';
				html_pure +='<div id="spu-title">'+wp_popup_cache_var.title_message+'</div>';
					html_pure +='<div id="spu-msg-cont">';
						html_pure +='<div id="spu-msg">';
						html_pure +='<p>'+wp_popup_cache_var.content_message+'</p>';
						html_pure +='<br />';
						html_pure +='<div class="main_like_wsp">'+html_facebook+'</div>';
						html_pure +='<div>'+fb_alt_text_1+' '+fb_alt_text_2+' '+fb_alt_text_3+' '+fb_alt_text_4+'</div>';
						html_pure +=html_youtube+' '+html_twitter+' '+html_google;
						html_pure +='</div>';
						html_pure +='<div class="step-clear"></div>';
					html_pure +='</div>';
					html_pure +='<span id="spu-timer"></span>';
				html_pure +='</div>';

				html_pure +='</div>';
				html_pure +="<input type='hidden' name='hd_msg_thanks' id='hd_msg_thanks' value='"+wp_popup_cache_var.thanks_message+"' />";
				html_pure +="<style>#spu-bg{background:#fff}#spu-main{}</style>";

				$('#wp_social_popup_and_get_traffic').html(html_pure);

				socialPopupTrafic({
					// Configure display of popup
					advancedClose: (wp_popup_cache_var.closed_advanced_keys) ? true:false,
					opacity: wp_popup_cache_var.opacity,
					s_to_close: wp_popup_cache_var.seconds_close,
					days_no_click: wp_popup_cache_var.until_popup,
					segundos : 'seconds',
					esperar : 'Wait' ,
					until_date: wp_popup_cache_var.date_end,
          type_campaign:wp_popup_cache_var.type_campaign,
					thanks_msg : wp_popup_cache_var.thanks_message, 
					thanks_sec : wp_popup_cache_var.thanks_message_seconds
				});

				if( html_facebook ){
					FB.XFBML.parse();
				}
				//$('#wp_social_popup_and_get_traffic').find('a.twitter-share-button').each(function(){
				/*$('#wp_social_popup_and_get_traffic').find('a.twitter-follow-button').each(function(){
					
				    var tweet_button = new twttr.TweetButton( $( this ).get( 0 ) );
				    tweet_button.render();
				    alert("entro");
				});*/
				if( html_twitter ){
					twttr.widgets.load();
				}

				if( html_google ){
					 
                     //gapi.plusone.go();
                     //gapi.plusone.render('spu-google');
                     
                     /*$(".g-plus").each(function () {
                        gapi.plusone.render($(this).get(0));
                    });*/
                    
                    /*var gbuttons = $(".g-plus");
                    if (gbuttons.length > 0) {
                        if (typeof (gapi) != 'undefined') {
                            gbuttons.each(function () {
                                //class="'+type_button_google+'" data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="bubble" data-size="medium" data-href="'+button_google[1]+'" width="300" height="69"
                                gapi.plusone.render($(this).get(0), {"size":"medium", "annotation":"none","class":type_button_google,"callback":"googleCB","onendinteraction":"closeGoogle","recommendations":"false","data-href":button_google[1],"href":button_google[1],"width":"300","height":"69"} );
                            });
                        } else {
                            $.getScript('https://apis.google.com/js/plusone.js');
                        }
                    }
                    
                    gapi.plusone.go();*/
                    
                    $(".put_gplus").appendTo("#spu-google");
                    $(".put_gplus").css("display","inline-block")
                     
				}
                
                if( html_youtube  ){
                    
                    $(".put_youtube").appendTo("#button_youtube");
                    $(".put_youtube").css("display","inline-block")
                }
                


			}
			,(parseInt(wp_popup_cache_var.seconds_appear)*1000)
		);
	}
});	