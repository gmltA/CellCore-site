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

$(function()
{
	if (isLocalStorageAvailable())
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
});