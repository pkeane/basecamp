{extends file="layout.tpl"}

{block name="content"}
<div id="homeContent">
	<h1>{$request->user->name} flagged projects</h1>
	<table class="projects">
		{foreach item=proj from=$flagged_projects}
		<tr>
			<th>{$proj->name}</th>
			<td>
				<a href="project/{$proj->basecamp_id}">get info</a> |
				<a href="{$basecamp_url}/projects/{$proj->basecamp_id}">view in Basecamp</a>
			</td>
		</tr>
		{/foreach}
	</table>
	<!--
	<h2>recent notes</h2>
	<dl href="home/notes" class="notes" id="my_notes">
	</dl>
	-->
</div>
{/block}
