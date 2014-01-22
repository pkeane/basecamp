<?php

require_once 'Dase/DBO/Autogen/Project.php';

class Dase_DBO_Project extends Dase_DBO_Autogen_Project 
{
	public $company;
	public $persons = array();

	public function getCompany()
	{
		$c = new Dase_DBO_Company($this->db);
		$c->basecamp_id = $this->company_id;
		$this->company= $c->findOne();
		return $this->company;
	}

	public function getPersons()
	{
		$set = array();
		$pps = new Dase_DBO_ProjectPerson($this->db);
		$pps->project_basecamp_id = $this->basecamp_id;
		foreach ($pps->findAll(1) as $pp) {
			$set[] = $pp->getPerson();
		}
		$this->persons = $set;
		return $this->persons;
	}

}
