<?php
require_once dirname(__DIR__) . "/controllers/group.php";
print_r($_GET);
$gc = new GroupController();

$gc->create_post($_GET['gn'], $_GET['uid'], "#", $_GET['pt']);

header("location: index.php?gn={$_GET['gn']}");
?>