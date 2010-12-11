<?php
if (!class_exists('XML_Unserializer')) {
	set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/PEAR/');
	require_once('XML/Serializer.php');
}
$statuses = json_decode(file_get_contents('http://graph.facebook.com/deeeki/feed'));

if (!$statuses) {
	exit;
}
foreach ($statuses->data as $status) {
	if (isset($status->application)) {
		continue;
	}

	$items[] = array(
		'title'       => $status->message,
		'link'        => 'http://www.facebook.com/deeeki/posts/' . array_pop(explode('_', $status->id)),
		'description' => $status->message,
		'pubDate'     => $datetime = date('D, d M Y H:i:s T', strtotime($status->created_time)),
	);
}

$options = array(
	'indent' => '  ',
	'linebreak' => "\n",
	'typeHints' => false,
	'addDecl' => true,
	'encoding' => 'UTF-8',
	'rootName' => 'rdf:RDF',
	'rootAttributes' => array('version' => '0.91'),
	'defaultTagName' => 'item',
);

$data['channel'] = array(
	'title' => 'deeeki\'s Facebook statuses',
	'link'  => 'http://www.facebook.com/deeeki',
	'items' => $items,
);

$serializer = new XML_Serializer($options);

if ($serializer->serialize($data)) {
	header('Content-type: text/xml');
	echo $serializer->getSerializedData();
}

