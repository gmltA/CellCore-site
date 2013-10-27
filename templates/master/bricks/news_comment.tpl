<section class="comment{if $comment.topicId != 0} reply{/if}" id="comment_{$comment.id}" topicId="{$comment.topicId}">
	<noindex>
	<div class="header">
		<h3>{$comment.authorName}</h3>
		{if $comment.subjectId != 0}
			<span class="subject">to {assign var=subjId value=$comment.subjectId}<a href="#comment_{$subjId}"><b>{$newsEntry.comments.$subjId.authorName}</b></a></span>
		{/if}
		<date>{$comment.date}</date>
	</div>
	</noindex>
	<div class="body">
		{$comment.body}
	</div>
</section>