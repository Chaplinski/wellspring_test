<?php
include_once 'all_includes.php';

$t = new Train();
$t->delete($_GET['id']);

header('Location: http://wellspring.chaplinski.xyz');
exit;

