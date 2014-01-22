<?php

require_once 'Dase/DBO/Autogen/Company.php';

class Dase_DBO_Company extends Dase_DBO_Autogen_Company 
{
	public $projects = array();

	public function getProjects($status = 'active')
	{
		$proj = new Dase_DBO_Project($this->db);
		$proj->company_id = $this->basecamp_id;
		$proj->status = $status;
		$proj->orderBy('name');
		$this->projects = $proj->findAll();
		return $this->projects;
	}
}
