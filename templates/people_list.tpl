{extends file="layout.tpl"}

{block name="content"}
<div id="homeContent">
	<h1>People</h1>
	<table class="people">
		{foreach item=person from=$people}
		<tr>
			<th><a href="people/{$person->username}">{$person->firstname} {$person->lastname}</a></th>
			<td>{$person->email}</td>
		</tr>
		{/foreach}
	</table>
</div>
{/block}
