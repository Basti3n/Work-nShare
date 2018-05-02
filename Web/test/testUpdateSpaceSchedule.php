<?php
session_start();
require "../function.php";
require "../object/spaces.php";



    $db=connectDb();
    $spaceMng = new SpaceMng($db);
    $spaceMng->updateSpaceSchedule('01basti' ,  '[{"debut":"5","fin":"20","jour":"Lundi"},{"debut":"18","fin":"24","jour":"Mardi"},{"debut":"01","fin":"05","jour":"Mercredi"},{"debut":"09","fin":"12","jour":"Jeudi"},{"debut":"09","fin":"20","jour":"Vendredi"},{"debut":"11","fin":"23","jour":"Samedi"},{"debut":"14","fin":"20","jour":"Dimanche"}]');
