<?php

require_once 'Dase/DBO/Autogen/UserProjectFlag.php';

class Dase_DBO_UserProjectFlag extends Dase_DBO_Autogen_UserProjectFlag 
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

}
