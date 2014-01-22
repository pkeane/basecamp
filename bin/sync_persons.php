<?php


include 'config.php';


$bc = $config->get('basecamp');

$url = $bc['url'].'/people.xml';
$res = Dase_Http::get($url,$bc['token'],'X');
$people_xml = $res[1];

$sx = simplexml_load_string($people_xml);

foreach ($sx->person as $person) {
	$p = new Dase_DBO_Person($db);
	$p->basecamp_id = $person->id;
	if (!$p->findOne()) {
		$p->insert();
	}
	$email = 'email-address';
	$username = 'user-name';
	$firstname = 'first-name';
	$lastname = 'last-name';
	$company_id = 'company-id';
	$p->firstname = $person->$firstname;
	$p->lastname = $person->$lastname;
	$p->username = $person->$username;
	$p->company_id = $person->$company_id;
	if ('false' == $person->deleted) {
		$p->deleted = 0;
	} 
	if ('true' == $person->deleted) {
		$p->deleted = 1;
	} 
	if ('false' == $person->administrator) {
		$p->administrator = 0;
	} 
	if ('true' == $person->administrator) {
		$p->administrator = 1;
	} 
	$p->email = $person->$email;
	$p->title = $person->title;
	$p->update();
	print "updated person\n";
}

