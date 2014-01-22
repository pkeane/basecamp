{extends file="layout.tpl"}

{block name="content"}
<div id="homeContent">
	<a class="control" href="{$basecamp_url}/projects/{$project->basecamp_id}">view in Basecamp &gt;&gt;</a>
	<h1>Project: {$project->name} ({$project->company->name})</h1>
	<a href="#" class="toggle" id="toggle_puf">edit/update</a>
	|
	{if $is_flagged}
	<a class="delete" href="project/{$project->basecamp_id}/flag/{$request->user->id}">remove flag</a>
	{else}
	<a class="put" href="project/{$project->basecamp_id}/flag/{$request->user->id}">flag this project</a>
	{/if}
	<div id="target_puf" class="hide">
		<form method="post" action="project/{$project->basecamp_id}">
			<p>
			<label for="producer}">Producer</label>
			<input type="text" class="long" name="producer" value="{$project->producer}">
			<label for="faculty_member}">Faculty Member</label>
			<input type="text" class="long" name="faculty_member" value="{$project->faculty_member}">
			<label for="project_manager}">Project Manager</label>
			<input type="text" class="long" name="project_manager" value="{$project->project_manager}">
			<label for="tech_lead}">Tech Lead</label>
			<input type="text" class="long" name="tech_lead" value="{$project->tech_lead}">
			<label for="project_dirname}">Project Directory</label>
			<input type="text" class="long" name="project_dirname" value="{$project->project_dirname}">
			<label for="www_dirname}">WWW Directory</label>
			<input type="text" class="long" name="www_dirname" value="{$project->www_dirname}">
			<label for="dase_collection">DASe Collection</label>
			<input type="text" class="long" name="dase_collection" value="{$project->dase_collection}">
			<label for="website_url">Website URL</label>
			<input type="text" class="long" name="website_url" value="{$project->website_url}">
			<label for="notes}">Notes</label>
			<textarea name="notes">{$project->notes}</textarea>
			</p>
			<input type="submit" value="update">
		</form>
	</div>
	<dl class="defList" id="target_puf2">
		<dt>Producer</dt>
		<dd>
		{if $project->producer}
		{$project->producer}
		{else}
		undefined
		{/if}
		</dd>

		<dt>Faculty Member</dt>
		<dd>
		{if $project->faculty_member}
		{$project->faculty_member}
		{else}
		undefined
		{/if}
		</dd>

		<dt>Project Manager</dt>
		<dd>
		{if $project->project_manager}
		{$project->project_manager}
		{else}
		undefined
		{/if}
		</dd>

		<dt>Tech Lead</dt>
		<dd>
		{if $project->tech_lead}
		{$project->tech_lead}
		{else}
		undefined
		{/if}
		</dd>

		<dt>Project Directory</dt>
		<dd>
		{if $project->project_dirname}
		{$project->project_dirname}
		{else}
		undefined
		{/if}
		</dd>

		<dt>WWW Directory</dt>
		<dd>
		{if $project->www_dirname}
		{$project->www_dirname}
		{else}
		undefined
		{/if}
		</dd>

		<dt>DASe Collection</dt>
		<dd>
		{if $project->dase_collection}
		{$project->dase_collection}
		{else}
		undefined
		{/if}
		</dd>

		<dt>Website URL</dt>
		<dd>
		{if $project->website_url}
		<a href="{$project->website_url}">{$project->website_url}</a>
		{else}
		undefined
		{/if}
		</dd>

		<dt>Notes</dt>
		<dd>
		{if $project->notes}
		{$project->notes}
		{else}
		undefined
		{/if}
		</dd>
	</dl>

	<div class="spacer"></div>
	<h3>Overview</h3>
	<p>{$project->overview}</p>
	<div class="spacer"></div>
	<h3>People</h3>
	<dl>
		{foreach item=person from=$project->persons}
		<dt><a href="people/{$person->username}">{$person->firstname} {$person->lastname}</a></dt>
		<dd>{$person->email}</dd>
		{/foreach}
	</dl>
	<div class="spacer"></div>

	<h3>Project Notes</h3>
	<div class="hide" id="project_notes_form">
		<form id="project_notes_form" class="note" method="post" action="project/{$project->basecamp_id}/note">
			<input type="hidden" name="is_public" value="1">
			<p>
			<textarea name="text">{$project_notes}</textarea>
			</p>
			<p>
			<input type="submit" value="update">
			</p>
		</form>
	</div>

	<div id="project_notes">
		<div class="text"><pre>{$project_notes}</pre></div>
		{if $project_notes_info}
		<div class="info">last edit: {$project_notes_info}</div>
		{/if}
		{if $is_flagged}
		<!-- user can edit project note ONLY if they have flagged project -->
		<a href="" class="modify">edit</a>
		{/if}
	</div>

	<!--
	<h3>my notes</h3>
	<form id="my_notes_form" class="note" method="post" action="project/{$project->basecamp_id}/notes">
		<p>
		<textarea name="text"></textarea>
		</p>
		<p>
		<input type="submit" value="add">
		</p>
	</form>

	<dl href="project/{$project->basecamp_id}/notes" class="notes" id="my_notes">
	</dl>
	-->

</div>
{/block}
