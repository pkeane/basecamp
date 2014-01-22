<?php

class Dase_Handler_Project extends Dase_Handler
{
	public $resource_map = array(
		'list' => 'list',
		'{id}' => 'project',
		'{id}/notes' => 'notes',
		'{id}/note' => 'note',
		'{id}/note/{note_id}' => 'note',
		'{id}/flag/{user_id}' => 'flag',
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

	public function postToNotes($r)
	{
		$text = trim($r->getBody());
		$note = new Dase_DBO_UserProjectNote($this->db);
		$note->user_id = $this->user->id;
		$note->project_basecamp_id = $r->get('id');
		if ($r->get('is_public')) {
			$note->is_public = $r->get('is_public');
		}
		$note->project_basecamp_id = $r->get('id');
		$note->text = $text;
		$note->insert();
		$r->renderOk();
	}

	public function postToNote($r)
	{
		$text = $r->get('text');
		$note = new Dase_DBO_UserProjectNote($this->db);
		$note->user_id = $this->user->id;
		$note->project_basecamp_id = $r->get('id');
		if ($r->get('is_public')) {
			$note->is_public = $r->get('is_public');
		}
		$note->project_basecamp_id = $r->get('id');
		$note->text = $text;
		$note->insert();
		$r->renderRedirect("project/".$r->get('id'));
	}

	public function getNotes($r)
	{
		$notes = new Dase_DBO_UserProjectNote($this->db);
		$notes->user_id = $this->user->id;
		$notes->project_basecamp_id = $r->get('id');
		$notes->orderBy('timestamp DESC');
		$data = array();
		foreach ($notes->findAll(1) as $n) {
			$set = array();
			$set['timestamp'] = $n->timestamp;
			$set['text'] = $n->text;
			$set['id'] = $n->id;
			$set['project_basecamp_id'] = $n->project_basecamp_id;
			$data[] = $set;
		}
		$r->response_mime_type = 'application/json';
		$r->renderResponse(Dase_Json::get($data));
	}

	public function deleteNote($r)
	{
		$note = new Dase_DBO_UserProjectNote($this->db);
		$note->load($r->get('note_id'));
		if ($this->user->id == $note->user_id) {
			$note->delete();
		}
		$r->renderOk();
	}

	public function putFlag($r) 
	{
		$flag = new Dase_DBO_UserProjectFlag($this->db);
		$flag->user_id = $this->user->id;
		$flag->project_basecamp_id = $r->get('id');
		if (!$flag->findOne()) {
			$flag->insert();
		}
		$r->renderOk();
	}

	public function deleteFlag($r) 
	{
		$flag = new Dase_DBO_UserProjectFlag($this->db);
		$flag->user_id = $this->user->id;
		$flag->project_basecamp_id = $r->get('id');
		if ($flag->findOne()) {
			$flag->delete();
		}
		$r->renderOk();
	}

	public function getProject($r) 
	{
		$t = new Dase_Template($r);

		$upn = new Dase_DBO_UserProjectNote($this->db);
		$upn->project_basecamp_id = $r->get('id');
		$upn->orderBy('timestamp DESC');
		$upn->findOne();
		$t->assign('project_notes',$upn->text);
		$notes_person = $upn->getUser();
		if ($notes_person) {
			$t->assign('project_notes_info',$notes_person->eid.' '.$upn->timestamp);
		}

		$proj = new Dase_DBO_Project($this->db);
		$proj->basecamp_id = $r->get('id');
		$proj->findOne();
		$proj->getCompany();
		$proj->getPersons(1);
		$flag = new Dase_DBO_UserProjectFlag($this->db);
		$flag->user_id = $this->user->id;
		$flag->project_basecamp_id = $proj->basecamp_id;
		if ($flag->findOne()) {
			$t->assign('is_flagged',1);
		}
		$t->assign('project',$proj);
		$bc = $this->config->get('basecamp');
		$t->assign('basecamp_url',$bc['url']);
		$r->renderResponse($t->fetch('project.tpl'));


	}

	public function postToProject($r)
	{
		$proj = new Dase_DBO_Project($this->db);
		$proj->basecamp_id = $r->get('id');
		if ($proj->findOne()) {
			$proj->producer = $r->get('producer');
			$proj->faculty_member = $r->get('faculty_member');
			$proj->project_manager = $r->get('project_manager');
			$proj->tech_lead = $r->get('tech_lead');
			$proj->project_dirname = $r->get('project_dirname');
			$proj->www_dirname = $r->get('www_dirname');
			$proj->website_url = $r->get('website_url');
			$proj->dase_collection = $r->get('dase_collection');
			$proj->notes = $r->get('notes');
			$proj->update();
		}
		$r->renderRedirect("project/$proj->basecamp_id");
	}

	public function getList($r) 
	{
		$t = new Dase_Template($r);

		$sort_by = $r->get('sort_by');
		if (!$sort_by) {
			$sort_by = 'company_name';
		}
		$project_array = array();
		$projects = new Dase_DBO_Project($this->db);
		$projects->orderBy('name');
		if ($r->get('include_archived')) {
			//pass
		} else {
			$projects->status = 'active';
		}
		foreach($projects->findAll(1) as $p) {
			$sorter = $p->$sort_by;
			if ($sorter) {
				if (!isset($project_array[$sorter])) {
					$project_array[$sorter] = array();
				}
				$project_array[$sorter][] = $p;
			}
		}
		ksort($project_array);
		$t->assign('sort_by',$sort_by);
		$t->assign('project_array',$project_array);
		$r->renderResponse($t->fetch('project_list.tpl'));
	}

	public function getListCurrent($r) 
	{
		$t = new Dase_Template($r);
		$bc = $this->config->get('basecamp');
		$res = Dase_Http::get($bc['url'].'/projects.xml',$bc['user'],$bc['pass']);
		$xml = $res[1];
		$sx = simplexml_load_string($xml);
		$companies = array();
		$archive = array();
		foreach ($sx->project as $project) {
			$status = (string) $project->status;
			if ('active' == $status) {
				$comp = (string) $project->company->name;
				if (!isset($companies[$comp])) {
					$companies[$comp] = array();
				}
				$companies[$comp][(string) $project->id] = (string) $project->name;
			} else {
				$comp = (string) $project->company->name;
				if (!isset($archive[$comp])) {
					$archive[$comp] = array();
				}
				$archive[$comp][(string) $project->id] = (string) $project->name;
			}
		}
		ksort($companies);
		foreach ($companies as $k => $v) {
			asort($companies[$k]);
		}
		ksort($archive);
		foreach ($archive as $k => $v) {
			asort($archive[$k]);
		}
		$t->assign('basecamp_url',$bc['url']);
		$t->assign('archive',$archive);
		$t->assign('companies',$companies);
		$r->renderResponse($t->fetch('project_list.tpl'));
	}
}

