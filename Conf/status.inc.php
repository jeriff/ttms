<?php
//$database=  include 'database.inc.php';
$menu=  include 'menu.inc.php';
$task=  include 'task.inc.php';
$permission=  include 'permission.inc.php';
$server=  include 'server.inc.php';
$project=  include 'project.inc.php';
$document=  include 'document.inc.php';
$question=  include 'question.inc.php';
return array(
    'menu' =>$menu,
    'task' =>$task,
    'permission' => $permission,
    'server' => $server,
    'project' => $project,
    'document' => $document,
    'ec_question'=>$question
);
?>
