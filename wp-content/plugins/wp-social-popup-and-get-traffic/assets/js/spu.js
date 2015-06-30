var spu_count = 0;
var spu_counter ='';

	function socialPopupTrafic(options) {
		var defaults = { days_no_click : "10" };
		var options = jQuery.extend(defaults, options);
		window.options = options;
		
		var cook = readCookie('spushow');
		var waitCook = readCookie('spuwait');
        

		if (cook != 'true' && cook!=true) {

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
    
    var ok = name + "=" + value + expires + "; path=/";
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
