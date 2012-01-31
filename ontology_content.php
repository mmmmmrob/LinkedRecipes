<?php
define('RECIPE', 'http://linkedrecipes.org/schema/');

$preferred_namespace_prefix = $complete_graph->get_first_literal($requested_uri, VANN_PREFERRED_NAMESPACE_PREFIX );
$preferred_namespace_uri = $complete_graph->get_first_resource($requested_uri, VANN_PREFERRED_NAMESPACE_URI );

echo "<p class=\"preferred_namespace\">This ontology has a preferred prefix of <span class=\"preferred_prefix\">${preferred_namespace_prefix}</span> and is based at the URI <a href=\"${preferred_namespace_uri}\">${preferred_namespace_uri}</a></p>";

$defines = $complete_graph->get_resource_triple_values($requested_uri, OV_DEFINES);
$properties = array(RDF_TYPE, RDFS_LABEL, RDFS_COMMENT);

$groups = array(
	"Classes" => RDFS_CLASS,
	"Properties" => RDF_PROPERTY,
	"Seasons" => RECIPE.'Season'
);
foreach ($groups as $group_label => $group_type) {
	echo "<h2>${group_label}</h2>\n";
	echo "<ol>\n";
	foreach ($defines as $defined) {
		$anchor = end(explode("/", $defined));
		echo "\t<li class=\"datatype\">";
		echo "<a name=\"${anchor}\"></a>";
		$label = $complete_graph->get_first_literal($defined, RDFS_LABEL, null, $preferred_language);
		if ($label)  { echo "<div class=\"datatype_label\">${label}</div>"; }
		echo "<div class=\"property\"><span class=\"property_label\">URI: </span><a href=\"${defined}\">${defined}</a></div>";
		foreach ($properties as $property) {
			$values = $complete_graph->get_subject_property_values($defined, $property);
			$property_label = $complete_graph->get_first_literal($property, RDFS_LABEL, null, $preferred_language);
			if (empty($values)) { continue; }
			echo "<div class=\"property\"><span class=\"property_label\">${property_label}: </span>";
			$values_html = array();
			foreach ($values as $value) {
				if ($value['type'] == 'uri') {
					$value_label = $complete_graph->get_label($value['value'], false, true);
					$values_html[] = "<a href=\"${value['value']}\"><span class=\"property_value\">${value_label}</span></a>";
				} else {
					$values_html[] = "<span class=\"property_value\">${value['value']}</span>";
				}
			}
			echo implode(', ', $values_html);
			echo "</div>";
		}
		echo "</li>\n";
	}
	echo "</ol>\n";
}