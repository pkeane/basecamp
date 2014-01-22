<?php


include 'config.php';


$bc = $config->get('basecamp');

$url = $bc['url'].'/projects.xml';
$res = Dase_Http::get($url,$bc['token'],'X');
$projects_xml = $res[1];

$sx = simplexml_load_string($projects_xml);

$i = 0;
foreach ($sx->project as $project) {
	$i++;
	$p = new Dase_DBO_Project($db);
	$p->basecamp_id = $project->id;
	if (!$p->findOne()) {
		$p->insert();
	}

	$p->name = $project->name;
	$p->company_id = $project->company->id;
	$p->company_name = $p->getCompany()->name;
	$p->status = $project->status;
	$p->overview = $project->announcement;
	$p->update();

	if (0 == $i%3) {
		sleep(3);
	}
	//get project people
	$people_url = $bc['url'].'/projects/'.$p->basecamp_id.'/people.xml';
	$res = Dase_Http::get($people_url,$bc['token'],'X');
	$people_xml = $res[1];
	$psx = simplexml_load_string($people_xml);
	$num = 0;
	foreach ($psx->person as $person) {
		$num++;
		$pp = new Dase_DBO_ProjectPerson($db);
		$pp->project_basecamp_id = $project->id;
		$username = 'user-name';
		$pp->person_username = $person->$username;
		if (!$pp->findOne()) {
			$pp->insert();
		}
	}
	print "updated project $p->name with $num people\n";
}

