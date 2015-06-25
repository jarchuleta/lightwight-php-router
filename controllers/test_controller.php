<?php 

class Test_Controller{
	public function index($param1 =null, $param2=null){
		echo "index hit";		
		debug($param1);
		debug($_GET);
		var_dump($param2);
	}
}

?>
	