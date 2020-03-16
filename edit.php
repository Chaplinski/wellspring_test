<?php

include_once 'all_includes.php';

$t = new Train();
$t->getById($_GET['id']);

echo $t->run_number;

