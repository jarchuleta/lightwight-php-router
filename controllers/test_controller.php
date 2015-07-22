<?php 

class Test_Controller extends Controller{
	public function index($param1 =null, $param2=null){
		echo "index hit";		
		//debug($param1);
		//debug($_GET);
		//debug($param2);	
		
		$this->set('view_name', "View Name JAMES");
		
	}
	
	
	public function test2(){
		$this->autoRender = false;
		$this->set('view_name', "View Name test2");
		$this->render('index');
	}
}

?>