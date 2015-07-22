<?php 

class Controller{

	/*
		@var determine if the render should be automatic
	*/	
	public $autoRender = true;
	
	/**
	* @var Shows up in view
	*/
	private $viewVars = array();
	public function getViewVars(){
		return $this->viewVars;
	}
	/**
	* @var controller -- this read only controller name is set in the constructor
	*/
	private $controller; 
	public function getControllerName(){
		return $this->controller;
	}
	
	/**
	* @var action -- this read only action name is set in the constructor
	*/
	private $action; 
	public function getActionName(){
		return $this->action;
	}
	
	//
	//contructor -- this is set in the router
	//
	public function Controller($controller, $action){
		$this->controller = $controller;
		$this->action = $action;
	}
	
	public function set($name,$value){
		$this->viewVars [$name] = $value;
	}
	
	public function autoRender(){
		if ($this->autoRender){
			$view = new View($this);
			$view->autoRender();
		}		
	}
	public function render($viewFile){
		$view = new View($this);
		$view->render($viewFile);
	}

	
}

?>