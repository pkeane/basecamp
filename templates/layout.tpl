<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="{$app_root}">
		<meta charset=utf-8 />
		{block name="head-meta"}{/block}
		<title>{block name="title"}LAITS Basecamp Projects{/block}</title>
		<style type="text/css">
			{block name="style"}{/block}
		</style>

		<link rel="stylesheet" type="text/css" href="www/css/style.css">
		{block name="head-links"}{/block}

		<script type="text/javascript" src="www/js/jquery.js"></script>
		<script type="text/javascript" src="www/js/jquery/ui/jquery-ui.js"></script>
		<script type="text/javascript" src="www/js/app.js"></script>
		{block name="head"}{/block}

	</head>
	<body>
		<div id="container">
			<!--
			<div id="laitsHeader">
				<a href="http://www.laits.utexas.edu"><img alt="LAITS Wordmark" src="www/images/laits.jpg"/></a>
			</div>
			-->

			<div id="topper">
				<h1><a href="home">LAITS Basecamp Projects</a></h1>
				<h3 id="topMenu">
					<a href="home">Home</a> |
					<a href="person/{$request->user->eid}">My Profile</a> |
					<a href="login/{$request->user->eid}" class="delete">logout {$request->user->eid}</a> 
				</h3>

				<!--
				<h4 id="login">
					{if $is_superuser}Superuser{/if} {$request->user->name} ({$request->user->eid}) is logged in 
					<a href="login/{$request->user->eid}" class="delete">[logout]</a>
				</h4>
				-->
				<div class="spacer"></div>
			</div>

			<div id="sidebar">

				<ul class="menu">
					<li class="border"></li>
					<li>
					<h2>Projects</h2>	
					</li>
					<li class="border"></li>
					<li>
					<a href="project/list" class="main">Project List</a>
					</li>
					<li>
					<a href="people/list" class="main">People</a>
					</li>
					{if $request->user->projects}
					<li><h2>My Projects</h2></li>
					{foreach item=q from=$request->user->projects}
					<li><a href="quiz/{$q->id}">{$q->title}</a></li>
					{/foreach}
					{/if}
					<li class="border"></li>
				</ul>
			</div> 

			<div id="content">
				{if $msg}<h3 class="msg">{$msg}</h3>{/if}
				{block name="content"}default content{/block}
			</div>

		</div>
		<div class="spacer"></div>
		<div id="footer">
			<a href="http://www.laits.utexas.edu/its/"><img src="www/images/footer.jpg" title="LAITS" class="logo" alt="LAITS"></a> 
		</div>
	</body>
</html>
