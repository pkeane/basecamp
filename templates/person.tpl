{extends file="layout.tpl"}

{block name="content"}
<div id="homeContent">
	<h1>Person: {$person->firstname} {$person->lastname}</h1>
	<dl class="defList" id="target_puf2">
		<dt>Email</dt>
		<dd>
		{$person->email}
		</dd>
	</dl>

	<h3>Projects</h3>
	<ul>
		{foreach item=project from=$person->projects}
		<li><a href="project/{$project->basecamp_id}">{$project->name}</a></li>
		{/foreach}
	</ul>


</div>
{/block}
