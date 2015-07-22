<?php


class View{
	
	/*
	*@var controller if provided.
	*/
	private $controller = null; 
	
	/**
	* @var Shows up in view
	*/
	private $viewVars = array();
	
	public function View($controller=null){
		$this->controller = $controller;
		//set the viewvars from the controller
		if ( $this->controller != null ){
			$this->viewVars = $this->controller->getViewVars();
		}
	}
	
	/*
	* Gets the view for autorender
	*/
	private function getViewFile()
	{
		$target = null;
		//compute the path to the file
		if ($this->controller != null){
			$target = APP_ROOT . '/views/' . $this->controller->getControllerName() . '/'.$this->controller->getActionName().'.php';
		}		
			
		return $target;
	}
	
	/*
	* Gets the view for template file
	*/
	private function getTemplateFile()
	{
		//compute the path to the file
		$target = APP_ROOT . '/views/template.php';
		
			
		return $target;
	}
	
	/*
	* attempts to find a view file
	*/
	public function findViewFile($viewName)
	{	
		
		//attempt to guess various locations for views
		$locations = array(
				APP_ROOT . '/views/' . $this->controller->getControllerName() . '/'.$viewName,
				APP_ROOT . '/views/' . $this->controller->getControllerName() . '/'.$viewName.'.php',
				APP_ROOT . '/views/' . $viewName,
				APP_ROOT . '/views/' . $viewName.'.php',
		);

		//loop through and load each class as needed
		foreach($locations as $location){
			if (is_file($location)){
				return $location;
			}	
		}
			
		return null;
	}

	/*
	* Autorenders based on the file assumed file path
	*/
	public function autoRender(){

		$template = $this->getTemplateFile();
		$file = $this->getViewFile();
		
		if (!file_exists($file)){
			echo "Missing autorender view file expected: $file <br />";
		}
		
		$body = $this->renderFile($file);
		
		require($template);
		
	}
	
	
	/*
	 * Render the view as php require. It extracts the variables and load the
	*	@param string $_file_ the view file.
	*/
	public function render($viewFile){
		$template = $this->getTemplateFile();
		$file = $this->findViewFile($viewFile);
		
		if (!file_exists($file)){
			echo "Missing render view file expected: $file <br />";
		}
		
		$body = $this->renderFile($file);
		
		require($template);
	}
	
	/*
	* Render the view as php require. It extracts the variables and load the
	*	@param string $_file_ the view file.
	*/
	public function renderFile($viewFile){
	
		// make sure the view exists otherwise we can't render it
		if (!file_exists($viewFile)){
		
			// attempt to find the view file
			$viewFile = $this->findViewFile($viewFile);
			
			if (!file_exists($viewFile)){
				echo "Missing View file. $viewFile <br />";
			}
		}
	
		if (file_exists($viewFile)){
			ob_start();
			ob_implicit_flush(false);
			extract($this->viewVars, EXTR_OVERWRITE);
			require($viewFile);
			return ob_get_clean();
		}
	}
	
	
}


