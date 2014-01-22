<?php


include 'config.php';


$bc = $config->get('basecamp');

$url = $bc['url'].'/companies.xml';
$res = Dase_Http::get($url,$bc['token'],'X');
$companies_xml = $res[1];

$sx = simplexml_load_string($companies_xml);

foreach ($sx->company as $company) {
	$c = new Dase_DBO_Company($db);
	$c->basecamp_id = $company->id;
	if (!$c->findOne()) {
		$c->insert();
	}
	$c->name = $company->name;
	$c->update();
	print "updated company\n";
}

