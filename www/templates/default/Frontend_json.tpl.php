<?php
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
$url = str_replace("format=json", "format=xml", $url);
require_once("xml2json.php");
$data = file_get_contents($url);
$jsonContents = xml2json::transformXmlStringToJson($data);
echo $jsonContents;