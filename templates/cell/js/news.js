function isLocalStorageAvailable()
{
	try {
		return 'localStorage' in window && window['localStorage'] !== null;
	} catch (e) {
		return false;
	}
}

Array.prototype.in_array = function(p_val)
{
	for(var i = 0, l = this.length; i < l; i++)
	{
		if (this[i] == p_val)
		{
			return true;
		}
	}
	return false;
}

function updateViewsCount()
{
	$.ajax({
		url: '/ajax/?',
		type: "POST",
		data: "newsEntryID=" + $('article').attr('id'),
		cache: false,
		beforeSend: function()
		{
		},
		success: function(response)
		{
			var views = parseInt($('#views').text());
			$('#views').text(String(views+1));
		},
		error:function (xhr, ajaxOptions, thrownError)
		{
		}
	});
}

var page = 1;

function nextPage()
{
	event.preventDefault();
	if ($('#loader').is(':visible'))
	{
		page = page + 1;
		$.ajax({
			type: "POST",
			url: "/ajax/?",
			data: 'point=' + page,
			beforeSend: function()
			{
				$('#loader > A').addClass('bar');
			},
			success: function(responce)
			{
				$('#loader > A').removeClass('bar');
				if (responce == 'empty')
				{
					$('#loader').slideUp('fast');
				}
				else
				{
					$(".right_column").append(responce);
					$('#loader > A').attr('href', '/news/page/' + (page+1));
				}
			}
		});
	}
}

$(function()
{
	if (isLocalStorageAvailable() && $('article').attr('id') != 0)
	{
		var articleList = localStorage.getItem('Cell.visitedArticles');
		if (!articleList)
		{
			updateViewsCount();
			localStorage.setItem('Cell.visitedArticles', $('article').attr('id'));
		}
		else if (!articleList.split(/[,]/).in_array($('article').attr('id')))
		{
			updateViewsCount();
			localStorage.setItem('Cell.visitedArticles', articleList+','+$('article').attr('id'));
		}
	}
	
	$(window).scroll(function () {
		if (($(window).scrollTop()) == ($(document).height() - $(window).height()))
		{
			nextPage();
        };
    });  
});