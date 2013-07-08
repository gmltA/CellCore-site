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

function responseHandler(event)
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
		data: "action=search" + "&search=" + search,
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

function postComment()
{
	var subject = $('.comment.new .subject A:first').attr('href').substr(9);
	var topic = $('#topicId').val();
	var body = $('.comment.new .editor').html().replace(/\<p\>/g, '').replace(/\<\/p\>/g, '<br/>').replace(/\<div\>/g, '<br/>').replace(/\<\/div\>/g, '');
	var newsId = $('article').attr('id');
	$.ajax({
		type: "POST",
		url: "/ajax/?",
		data: "action=post_comment" + "&newsId=" + newsId + "&body=" + encodeURIComponent(body) + "&subject=" + subject + "&topic=" + topic,
		cache: false,
		beforeSend: function()
		{
			$('#progressbar').slideDown();
			$('.comment.new .header').slideUp();
			$('.comment.new .editor').slideUp();
		},
		success: function(response)
		{
			$('#progressbar').slideUp();
			$('.comment.new .header .subject').hide();
			$('.comment.new .header .subject A').attr('href', '');
			$('.comment.new .header .subject B').text('');
			$('#topicId').val(0);
			$('.comment.new .header').slideDown();
			$('.comment.new .editor').html('').slideDown();
			$('#comments_container').html(response);
		}
	});
}

function previewComment()
{
	if ($('.comment.new .editor').attr('contenteditable') == "false")
	{

		$('#preview_caption').show();
		$('#edit_caption').hide();
		$('.comment.new .editor').attr('contenteditable', true);
	}
	else
	{
		$('#preview_caption').hide();
		$('#edit_caption').show();
		$('.comment.new .editor').attr('contenteditable', false);
	}
}

var scrollPosition = 0;

$(document).ready(function(){
	// Response from login iframe
	window.addEventListener("message", responseHandler, false);

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

	$('.comment H3').live({
		click:
		function ()
			{
				if ($(this).parent().parent().hasClass('new'))
					return false;

				$('.comment.new .header .subject A').attr('href', '#' + $(this).parent().parent().attr('id'));
				$('.comment.new .header .subject B').text($(this).text());
				$('.comment.new .header .subject').show();
				$('html, body').animate({scrollTop: $('.comment.new').offset().top}, 200);
				if ($(this).parent().parent().attr('topicId') == 0)
				{
					$('#topicId').val($(this).parent().parent().attr('id').substr(8));
				}
				else
				{
					$('#topicId').val($(this).parent().parent().attr('topicId'));
				}
			}
	});

	$('.comment.new .subject_clear').live({
		click:
		function ()
			{
				$('.comment.new .header .subject').hide();
				$('.comment.new .header .subject A').attr('href', '');
				$('.comment.new .header .subject B').text('');
				$('#topicId').val(0);
			}
	});

	$('.comment.new .editor').live({
		click:
		function ()
			{
				$(this).focus();
			}
	});

	$('#post_comment').live({
		click:
		function ()
			{
				postComment();
			}
	});

	$('#preview_comment').live({
		click:
		function ()
			{
				previewComment();
			}
	});

	$('#slider').nivoSlider({
        effect: 'sliceDown', // Задаётся как: 'fold, fade, sliceDown'
        slices: 35,
        animSpeed: 200,
        pauseTime: 3000,
        startSlide: 0, // Задаётся начало прокрутки  (0 index)
        directionNav: true, // Вперёд/Назад
        directionNavHide: true, // Показывать только при наведении
        controlNav: true, // 1,2,3 ...
        controlNavThumbs: false, // Использование картинок для Control Nav
		controlNavThumbsFromRel: false, // Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', // заменить на..
        controlNavThumbsReplace: '_thumb.jpg', //... это ярлык для Image src
        keyboardNav: false, // использовать стрелки влево и вправо.
        pauseOnHover: true, // при наведении анимация останавливается.
        manualAdvance: false, // Форсированный ручной переход
        captionOpacity: 0.8 // Прозрачность подписи
    });
});

$(window).scroll(function()
{
	if ($(window).scrollTop() > 100)
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
