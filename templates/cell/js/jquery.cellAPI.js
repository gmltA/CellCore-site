function openLogin()
{
	event.preventDefault();
	if ($('.embed_login').html() == '')
	{
		$('.embed_login').html('<iframe src="http://lk1.riverrise.net/loginframe/" id="loginbox" frameborder="0"/>');
	}

	$('#loginbox').stop().fadeIn("fast").animate({'marginLeft' : '0px'}, "slow", "easeInOutCubic");
	$('#blackout').stop().fadeIn("fast");
	$('#login_errors').stop().fadeIn("fast");
	$(window).resize();
}

function closeLogin()
{
	$('#loginbox').stop().fadeOut("slow").animate({'marginLeft' : '-500px'}, "fast", "easeInOutCubic");
	$('#blackout').stop().fadeOut("fast");
	$('#login_errors').stop().fadeOut("fast");
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
		$("#login_errors").html(event.data);
		$("#login_errors").stop().animate({opacity: 1.0}, "fast");
		setTimeout(function()
		{
			$("#login_errors").stop().animate({opacity: 0.0}, "slow");
		}, 5000);
	}
}

function processSearch()
{
	var search = encodeURIComponent($("#search").val()).replace('%20', '+');
	$.ajax({
		type: "POST",
		url: "/ajax/?",
		data: {"search": search},
		cache: false,
		success: function(response){
			if (response != '')
			{
				$('.search_dropdown').html(response);
				$('.search_dropdown').slideDown('fast');
				$('.all_search_results > A').attr('href', '/search/' + search);
			}
			else if ($('.search_dropdown').is(':visible') && response == '')
			{
				$('.search_dropdown').slideUp('fast');
			}
		}
	});
}

var scrollPosition = 0;

$(document).ready(function(){
	// Responce from login iframe
	window.addEventListener("message", responceHandler, false);

	$("#search").keyup(function(key){
		if (key.keyCode == '13')
		{
			$('#search_form').submit();
			return false;
		}
		processSearch();
		return true;
	});

	$('#search').focus(function() {
		if ($("#search").val() != '')
			processSearch();
		return true;
	});

	$(document).click(function(event) {
		var target = $(event.target);
		if (target.closest('.search_wrapper').length != 1 && target.closest('.search_dropdown').length != 1)
			$('.search_dropdown').slideUp('fast');
	});

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

	$(".scroll_manager").live({
		mouseover:
		function ()
			{
				$(this).stop().animate({opacity: 1}, "fast");
			},
		mouseout:
		function ()
			{
				$(this).stop().animate({opacity: 0.3}, "fast");
			}
	});

	$("#blackout").live({
		click:
		function ()
			{
				closeLogin();
			}
	});

	$(window).resize(function(){
		$('.login_errors_box').css({
			position: 'fixed',
			left: ($(window).width() - $('.login_errors_box').outerWidth())/2,
			top: ($(window).height() - $('.login_errors_box').outerHeight())/4
		});
	});

	$(".scroll_manager").animate({opacity: 0.0}, "fast").hide();
	$(function()
	{
		$('.scroll_manager').click(function()
		{
			if (scrollPosition == 0)
			{
				scrollPosition = $(window).scrollTop();
				$('html, body').stop().animate({scrollTop:$("body").offset().top}, 200);
				$('.scroll_manager #to_top').hide();
				$('.scroll_manager #to_bottom').show();
			}
			else
			{
				$('html, body').stop().animate({scrollTop:scrollPosition}, 200);
				$('.scroll_manager #to_top').show();
				$('.scroll_manager #to_bottom').hide();
				scrollPosition = 0;
			}
		})
	});
});

$(window).scroll(function()
{
	if ($(window).scrollTop() > 560)
	{
		if ($(".scroll_manager").css('display') == 'none')
			$(".scroll_manager").show().animate({opacity: 0.3}, "fast");
	}
	else
	{
		if (scrollPosition == 0)
			$(".scroll_manager").animate({opacity: 0.0}, "fast").hide();
	}
});
