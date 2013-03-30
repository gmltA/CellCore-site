function openLogin()
{
	event.preventDefault();
	if ($('.embed_login').html() == '')
	{
		$('.embed_login').html('<iframe src="http://lk1.riverrise.net/loginframe/" id="loginbox" frameborder="0"/>');
	}

	$('#loginbox').stop().fadeIn("fast").animate({'marginLeft' : '0px'}, "slow", "easeInOutCubic");
	$('#blackout').stop().fadeIn("fast");
}

function closeLogin()
{
	$('#loginbox').stop().fadeOut("slow").animate({'marginLeft' : '-500px'}, "fast", "easeInOutCubic");
	$('#blackout').stop().fadeOut("fast");
}

function responceHandler(event)
{
	if (event.data == 'success')
	{
		closeLogin();
		$('.embed_login').html('');
		location.reload();
	}
	else
	{
		alert(event.data);
	}
}



$(document).ready(function(){
	// Responce from login iframe
	window.addEventListener("message",
        responceHandler,
        false);
	$(".nbutton").hover(
		function ()
			{
				if (!$(this).hasClass("active"))
				{
					$(this).stop().animate({"margin-left": "10px"}, "fast");

					if ($(this).hasClass("main"))
						$('#hex_main').stop().animate({"opacity": "1"}, "fast");
					else if ($(this).hasClass("news"))
						$('#hex_news').stop().animate({"opacity": "1"}, "fast");
					else if ($(this).hasClass("stats"))
						$('#hex_stats').stop().animate({"opacity": "1"}, "fast");
					else if ($(this).hasClass("rules"))
						$('#hex_rules').stop().animate({"opacity": "1"}, "fast");
					else if ($(this).hasClass("tools"))
						$('#hex_tools').stop().animate({"opacity": "1"}, "fast");
				}
			},
		function ()
			{
				if (!$(this).hasClass("active"))
				{
					$(this).stop().animate({"margin-left": "0px"}, "fast");

					if ($(this).hasClass("main"))
						$('#hex_main').stop().animate({"opacity": "0"}, "fast");
					else if ($(this).hasClass("news"))
						$('#hex_news').stop().animate({"opacity": "0"}, "fast");
					else if ($(this).hasClass("stats"))
						$('#hex_stats').stop().animate({"opacity": "0"}, "fast");
					else if ($(this).hasClass("rules"))
						$('#hex_rules').stop().animate({"opacity": "0"}, "fast");
					else if ($(this).hasClass("tools"))
						$('#hex_tools').stop().animate({"opacity": "0"}, "fast");
				}
			});

	$(".lighter_fast").live({
		mouseover:
		function ()
			{
				$(this).stop().animate({opacity: 1}, "fast");
			},
		mouseout:
		function ()
			{
				$(this).stop().animate({opacity: 0.7}, "fast");
			}
	});

	$("#blackout").live({
		click:
		function ()
			{
				closeLogin();
			}
	});
});
