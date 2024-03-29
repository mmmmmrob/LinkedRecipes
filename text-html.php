<?php
$preferred_languages = sort_accept_values($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
$preferred_languages[] = null;
$complete_graph->set_namespace_mapping('recipe', 'http://linkedrecipes.org/schema');
$title = $complete_graph->get_first_literal($requested_uri, RDFS_LABEL, null, $preferred_languages );
$description = $complete_graph->get_first_literal($requested_uri, RDFS_COMMENT, null, $preferred_languages );
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo htmlentities($title); ?></title>
		<link href="/css/site.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="container">
			<div class="header">
				<h1><?php echo htmlentities($title) ?></h1>
			</div>
			<div class="content">
				<p><?php echo htmlentities($description) ?></p>
				<?php
				if ($is_ontology_request) { require_once 'ontology_content.php'; }
				?>
			</div>
			<div class="footer">
				<p>
					<a rel="license" href="http://creativecommons.org/licenses/by-nd/3.0/"><img alt="Creative Commons Licence" style="border-width:0" src="http://i.creativecommons.org/l/by-nd/3.0/88x31.png"></a><br>
					<span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Linked Recipes</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nd/3.0/">Creative Commons Attribution-NoDerivs 3.0 Unported License</a>.
				</p>
			</div>
		</div>
	</body>
</html>
