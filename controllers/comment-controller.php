<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/_app/core/init.php';

if (!isset($_POST['addComment']))
{
    $User->addNewComment();
}