{extends file="layout.tpl"}

{block name="content"}
<div id="homeContent">
	<div class="control">
		<form method="get" action="project/list">
			sorted by:
			<select name="sort_by">
				<option value="company_name">select:</option>
				<option value="company_name" {if $sort_by == 'company_name'}selected{/if}>Department</option>
				<option value="dase_collection" {if $sort_by == 'dase_collection'}selected{/if}>DASe Collection</option>
				<option value="faculty_member" {if $sort_by == 'faculty_member'}selected{/if}>Faculty Member</option>
				<option value="producer" {if $sort_by == 'producer'}selected{/if}>Producer</option>
				<option value="project_dirname" {if $sort_by == 'project_dirname'}selected{/if}>Project Directory</option>
				<option value="project_manager" {if $sort_by == 'project_manager'}selected{/if}>Project Manager</option>
				<option value="status" {if $sort_by == 'status'}selected{/if}>Status</option>
				<option value="tech_lead" {if $sort_by == 'tech_lead'}selected{/if}>Tech Lead</option>
				<option value="website_url" {if $sort_by == 'website_url'}selected{/if}>Website URL</option>
				<option value="www_dirname" {if $sort_by == 'www_dirname'}selected{/if}>WWW Directory</option>
			</select>
			<input type="submit" value="go">
			<div class="wee">
				<input type="checkbox" name="include_archived" value="1">
				include archived projects
			</div>
		</form>
	</div>
	<h1>Project List</h1>
	<table class="projects">
		{foreach item=projects key=sorter from=$project_array}
		<tr>
			<th>{$sorter}</th>
			<td>
				<ul>
					{foreach item=project from=$projects}
					<li><a href="project/{$project->basecamp_id}">{$project->name}</a></li>
					{/foreach}
				</ul>
			</td>
		</tr>
		{/foreach}
	</table>
</div>
{/block}
