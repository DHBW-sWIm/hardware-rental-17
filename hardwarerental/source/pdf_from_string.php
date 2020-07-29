<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/locallib.php');

header('Content-Type: application/pdf');

$id = optional_param('id', 0, PARAM_INT);
//data_read: hardwarerental_pdf
$result = $DB->get_record('hardwarerental_pdf',array('id'=>$id));

echo $result->pdf;