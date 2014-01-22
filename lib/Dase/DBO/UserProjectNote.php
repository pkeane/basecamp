<?php

require_once 'Dase/DBO/Autogen/UserProjectNote.php';

class Dase_DBO_UserProjectNote extends Dase_DBO_Autogen_UserProjectNote 
{
	public $project;
	public $user;

	public function getProject()
	{
		$p = new Dase_DBO_Project($this->db);
		$p->basecamp_id = $this->project_basecamp_id;
		$this->project = $p->findOne();
		return $this->project;
	}

	public function getUser()
	{
		$u = new Dase_DBO_User($this->db);
		if ($u->load($this->user_id)) {
			$this->user = $u;
		}
		return $this->user;
	}
}
