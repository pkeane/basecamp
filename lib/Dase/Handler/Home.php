<?php

class Dase_Handler_Home extends Dase_Handler
{
	public $resource_map = array(
		'/' => 'home',
		'notes' => 'notes',
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

	public function getNotes($r)
	{
		$notes = new Dase_DBO_UserProjectNote($this->db);
		$notes->user_id = $this->user->id;
		$notes->setLimit(15);
		$notes->orderBy('timestamp DESC');
		$data = array();
		foreach ($notes->findAll(1) as $n) {
			$set = array();
			$set['timestamp'] = $n->timestamp;
			$set['text'] = $n->text;
			$set['id'] = $n->id;
			$set['project_name'] = $n->getProject()->name;
			$set['project_url'] = "project/$n->project_basecamp_id";
			$data[] = $set;
		}
		$r->response_mime_type = 'application/json';
		$r->renderResponse(Dase_Json::get($data));
	}

	public function getHome($r) 
	{
		$t = new Dase_Template($r);
		$flag = new Dase_DBO_UserProjectFlag($this->db);
		$flag->user_id = $this->user->id;
		$flag->orderBy('id DESC');
		$flagged_projects = array();
		foreach ($flag->findAll(1) as $f) {
			$flagged_projects[] = $f->getProject();
		}
		$t->assign('flagged_projects',$flagged_projects);
		$bc = $this->config->get('basecamp');
		$t->assign('basecamp_url',$bc['url']);
		$r->renderResponse($t->fetch('home.tpl'));
	}
}

