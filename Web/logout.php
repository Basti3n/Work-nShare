<?php
	session_start();
	require "conf.inc.php";
	require "function.php";

	if(isConnected()){
    logout(true);
  }
  else header("Location: index.php");
