<?php
class User
{
	protected $status;
	protected $id;
	protected $forumId;
	protected $displayName = "Anonimous";
	protected $forumSkin;
	
	public function __construct($username, $sha_pass_hash, $realm = 0)
	{
        $authResponce = $this->ProcessAuth($username, $sha_pass_hash, $realm);
        
		if (!is_array($authResponce))
        {
			$this->status = $authResponce;
        }
        else
        {
            $this->id = $authResponce['id'];
            $this->status = USER_STATUS_LOGGEDIN;
        }

        $data = $this->LoadForumData();

        $this->forumSkin = $data['skin'];
        $this->displayName = $data['members_display_name'];

        if ($this->status != USER_STATUS_LOGGEDIN)
        {
            $this->id = 0;
            $this->status = USER_STATUS_FORUM_DATA;
        }
	}
	
	private function ProcessAuth($username, $sha_pass_hash, $realm)
	{
		global $rDB;
		
        if (!$username || !$sha_pass_hash)
            return USER_STATUS_FAIL;

		$result = $rDB[$realm]->selectRow('SELECT id, username FROM account WHERE username = ?', $username);

		if (is_array($result))
			return $result;
		else
			return USER_STATUS_FAIL;
	}
	
	private function LoadForumData()
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
                    $forumData['members_display_name'] = 'ForumAuth:'.$forumData['members_display_name'];
                }
            }
        }
        
        if (!in_array($forumData['skin'], array_keys($skins))) // Wrong SkinID
        {
            $forumData['skin'] = current(array_keys($skins));
        }
		
		return $forumData;
	}
	
	public function GetID()
	{
		return $this->id;
	}
    
    public function IsLoggedIn()
    {
        return ($this->status == USER_STATUS_LOGGEDIN || $this->status == USER_STATUS_FORUM_DATA);
    }
	
	public function GetDisplayName()
	{
		return $this->displayName;
	}
	
	public function GetSkin()
	{
		return $this->forumSkin;
	}
}
?>