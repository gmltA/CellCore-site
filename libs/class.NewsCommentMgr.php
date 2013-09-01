<?php

class NewsCommentManager
{
    protected static $instance;

    private function __construct()
	{
	}

    private function __clone()
	{
	}

    private function __wakeup()
	{
	}

    public static function getInstance()
	{
        if (is_null(self::$instance))
		{
            self::$instance = new NewsCommentManager();
        }

        return self::$instance;
    }

	public function loadComments($newsEntryId)
	{
		global $DB;

		$firstLevel = $DB->select('SELECT id AS ARRAY_KEY, id, authorId, topicId, subjectId, date, body FROM ?_news_comments WHERE newsId = ?d AND topicId = 0 ORDER BY id ASC', $newsEntryId);

		if (!$firstLevel)
		{
			return false;
		}

		$comments = array();
		$id = array();

		foreach ($firstLevel as $key => $comment)
		{
			$firstLevel[$key]['authorName'] = User::getNameById($comment['authorId']);
			$id[] = $comment['id'];

			$secondLevel = $DB->select('SELECT id AS ARRAY_KEY, id, authorId, topicId, subjectId, date, body '
										. 'FROM ?_news_comments '
										. 'WHERE newsId = ?d AND topicId = ?d '
										. 'ORDER BY id ASC', $newsEntryId, $comment['id']);

			$comments[] = $firstLevel[$key];
			foreach($secondLevel as $k2 => $com)
			{
				$com['authorName'] = User::getNameById($com['authorId']);
				$id[] = $com['id'];
				$comments[] = $com;
			}
		}
		$comments = array_combine($id, $comments);
		return $comments;
	}

	public function postComment($newsEntryId, $body, $subject = 0, $topic = 0)
	{
		global $user;
		global $DB;

		$body = trim($body, '<br/>');
		$body = trim($body, '&nbsp;');

		if (empty($body))
			return;

		$body = preg_replace('/((\<br\>)|(\<br\/\>)|(\<br \/\>))+/m', '<br/>', $body);
		$body = strip_tags($body, '<br><br/><br />');

		$DB->query('INSERT INTO ?_news_comments SET '
					. 'newsId = ?d, '
					. 'authorId = ?d, '
					. 'subjectId = ?d, '
					. 'topicId = ?d, '
					. 'date = now(), '
					. 'ip = ?, '
					. 'body = ?', $newsEntryId, $user->getID(), $subject, $topic, $user->getCurrentIP(), $body);
	}
}
