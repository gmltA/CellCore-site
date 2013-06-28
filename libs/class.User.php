<?php
class User
{
	protected $status;
	protected $id;
	protected $forumId;
	protected $displayName = "Anonymous";
	protected $forumSkin;

	public function __construct($username, $sha_pass_hash, $realm = 0)
	{
		$authResponce = $this->processAuth($username, $sha_pass_hash, $realm);

		if (!is_array($authResponce))
		{
			$this->status = $authResponce;
		}
		else
		{
			$this->id = $authResponce['id'];
			$this->displayName = $authResponce['username'];
			$this->status = USER_STATUS_LOGGEDIN;
		}

		$data = $this->loadForumData();
		if (!$data)
		{
			global $skins;
			$this->forumSkin = current(array_keys($skins));

			return;
		}

		$this->forumSkin = $data['skin'];
		if ($data['members_display_name'])
			$this->displayName = $data['members_display_name'];

		if ($this->status != USER_STATUS_LOGGEDIN)
		{
			$this->id = 0;
			$this->status = USER_STATUS_FORUM_DATA;
		}
	}

	private function processAuth($username, $sha_pass_hash, $realm)
	{
		global $rDB;

		if (!$username || !$sha_pass_hash || $username == "" || $sha_pass_hash == "")
			return USER_STATUS_FAIL;

		$result = $rDB[$realm]->selectRow('SELECT id, username FROM account WHERE username = ?', $username);

		if (is_array($result))
			return $result;
		else
			return USER_STATUS_FAIL;
	}

	private function loadForumData()
	{
		global $fDB;
		global $skins;

		if (isset($this->id))
		{
			$forumData = $fDB->selectRow('SELECT members_display_name, skin FROM ?_members WHERE member_id = ?d', $this->id);
		}

		if (!isset($this->id) || !$forumData) // Try to get info by forum member ID
		{
			if (isset($_COOKIE['member_id']))
			{
				$this->forumId = $_COOKIE['member_id'];
				$forumData = $fDB->selectRow('SELECT members_display_name, skin FROM ?_members WHERE member_id = ?d', $this->forumId);
				if ($forumData)
				{
					$forumData['members_display_name'] = $forumData['members_display_name'];
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		if (!in_array($forumData['skin'], array_keys($skins))) // Wrong SkinID
		{
			$forumData['skin'] = current(array_keys($skins));
		}

		return $forumData;
	}

	public function getID()
	{
		return $this->id;
	}

	public function isLoggedIn()
	{
		return $this->status == USER_STATUS_LOGGEDIN;
	}

	public function getDisplayName()
	{
		return $this->displayName;
	}

	public function getSkin()
	{
		return $this->forumSkin;
	}

	public static function getNameById($userId)
	{
		global $rDB;
		//@todo: deal with RealmID
		$result = $rDB[0]->selectRow('SELECT display_name, login FROM accounts_extra WHERE id = ?d', $userId);

		return ($result['display_name'] != '') ? $result['display_name'] : $result['login'];
	}
}
