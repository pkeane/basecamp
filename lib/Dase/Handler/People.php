<?php

class Dase_Handler_People extends Dase_Handler
{
	public $resource_map = array(
		'/' => 'list',
		'list' => 'list',
		'{username}' => 'person',
	);

	protected function setup($r)
	{
		$this->user = $r->getUser();
		if ($this->user->isSuperuser($r->superusers)) {
			$this->is_superuser = true;
		} else {
			$this->is_superuser = false;
		}
	}

	public function getList($r) 
	{
		$t = new Dase_Template($r);
		$people_array = array();
		$people = new Dase_DBO_Person($this->db);
		$people->orderBy('lastname');
		$t->assign('people',$people->findAll(1));
		$r->renderResponse($t->fetch('people_list.tpl'));
	}

	public function getPerson($r) 
	{
		$t = new Dase_Template($r);
		$person = new Dase_DBO_Person($this->db);
		$person->username = $r->get('username');
		$person->findOne();
		$person->getProjects();
		$t->assign('person',$person);
		$r->renderResponse($t->fetch('person.tpl'));

	}

}

