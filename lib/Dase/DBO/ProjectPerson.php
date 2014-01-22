<?php

require_once 'Dase/DBO/Autogen/ProjectPerson.php';

class Dase_DBO_ProjectPerson extends Dase_DBO_Autogen_ProjectPerson 
{
	public $person;
	public $project;

	public function getPerson()
	{
		$p = new Dase_DBO_Person($this->db);
		$p->username = $this->person_username;
		$this->person = $p->findOne();
		return $this->person;
	}

	public function getProject()
	{
		$p = new Dase_DBO_Project($this->db);
		$p->basecamp_id = $this->project_basecamp_id;
		$this->project = $p->findOne();
		return $this->project;
	}


}
