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

		$comments = $DB->select('SELECT id AS ARRAY_KEY, id, authorId, subjectId, date, body FROM ?_news_comments WHERE newsId = ?d ORDER BY id ASC', $newsEntryId);

		if (!$comments)
		{
			return false;
		}
		
		foreach ($comments as $key => $comment)
		{
			$comments[$key]['authorName'] = User::getNameById($comment['authorId']);
			//if ($comment['subjectId'])
				//$comments[$key]['subjectName'] = User::getNameById($comment['subjectId']);
		}
		return $comments;
	}

	public function postComment($newsEntryId, $body, $subject = 0)
	{
		global $user;
		global $DB;
		
		$DB->query('INSERT INTO ?_news_comments SET newsId = ?d, authorId = ?d, subjectId = ?d, date = now(), body = ?', $newsEntryId, $user->getID(), $subject, $body);
	}
}
