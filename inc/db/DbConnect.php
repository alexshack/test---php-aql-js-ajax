<?php

class MyDB {

  	public $db;
  	function __construct() {
    	$db_host = 'localhost';
		
		$db_user = 'millenium_test';
		$db_name = 'millenium_test';
		$db_password = '3cXTIKnjoUz7hsJn';

		$this->db = mysqli_connect($db_host, $db_user, $db_password, $db_name);

		if (!$this->db) {
    		die('<p style="color:red">'.mysqli_connect_errno().' - '.mysqli_connect_error().'</p>');
		}
	
		$this->db->query("SET NAMES utf8");
		return $this;
  	}
}
