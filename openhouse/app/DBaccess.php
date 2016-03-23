<?php
	echo 'this is DBaccess.php';
	class dbpdo{
		private $dbusername = "root";
		private $dbpassword = "Yang123";
		private $dbhost = "localhost";
		//private $dbname = "ohDB_AGENT";
		private $conn;
		
		public function __construct($dbname){
			$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		public function query($str){
			
		}
		
		public function __destruct(){
			$conn = null;
		}
	}