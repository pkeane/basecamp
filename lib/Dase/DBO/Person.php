<?php

require_once 'Dase/DBO/Autogen/Person.php';

class Dase_DBO_Person extends Dase_DBO_Autogen_Person 
{
	public $projects = array();

	public function getProjects()
	{
		$set = array();
		$pps = new Dase_DBO_ProjectPerson($this->db);
		$pps->person_username = $this->username;
		foreach ($pps->findAll(1) as $pp) {
			$project = $pp->getProject();
			$set[$project->name] = $project;
		}
		ksort($set);
		$this->projects = $set;
		return $this->projects;
	}

}
