<?php 
/** ------------------------------------------------------------
 * Name:        index.php
 * Author:      James Archuleta, IRM-CAS, LANL
 * Date:        Apr 13, 2012
 * Description: Lightweight router/dispatcher loader written to replace cakephp
 * for use on lower environments where cakephp doesn't work
 *-------------------------------------------------------------*/

//define APP_ROOT
define('APP_ROOT' , dirname($_SERVER['SCRIPT_FILENAME']));

//
//Automatically load components
//
load_components();


//
//--- Router/dispatcher ---------------------------------------------------------
//

// GET the Request and build out controller
$requestURI = explode('/', $_SERVER['REQUEST_URI']);
$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

for($i = 0; $i < sizeof ( $scriptName ); $i ++) {
	if ($requestURI [$i] == $scriptName [$i]) {
		unset ( $requestURI [$i] );
	}
}



//parse out url data
$command = array_values ( $requestURI );
$controller = 'app'; // Change this line to change the default controller name
if (count($command) >= 1){
	if ($command[0] != ''){
		$controller = $command[0];
	}
	
	$action = 'index'; // Change default action name here
	$params = array();
	if (isset($command[1])){
		$url = explode("?",$command[1]);
		$action =  $url[0];
		$params = array_values($command);
		// remove controllor and action in params list
		unset($params[0]);
		unset($params[1]);
	}
	
	//clean up
	unset( $command[0]); 
	unset( $command[1]);
}

//compute the path to the file
$target = APP_ROOT . '/controllers/' . $controller . '_controller.php';
//modify page to fit naming convention
$class = ucfirst($controller) . '_Controller';

//get target
if (file_exists($target))
{
	
	//includes the class file, stray markup can be coming from here
	include_once($target);
	
	//check class
	if (!class_exists($class))
	{
		//did we name our class correctly?
		$expected = "<pre>class $class { \n\n}
		</pre>";
		
		
		die("class does not exist! $expected");
	}
		
	//instantiate the appropriate class
	$controllerClass = new $class($controller, $action);		
	
	//check if method exits
	if (! is_callable( array($controllerClass, $action)  ) ){
		
		$expected = "<pre>public function $action() { \n\n}</pre>";
		
		die("action does not exist! Expected: $expected");
	}
	
	//call the action
	call_user_func_array(array($controllerClass, $action), $params);
	//call the autorender, can be turned off from the controller	
	$controllerClass->autoRender();
}
else
{
	//can't find the file in 'controllers'!
	
	echo "Controller does not exist! Expected: $target <br />";
	
	echo "<pre>
&lt;?php<br />
<br />
	class $class{<br />
		public function $action(\$param1 =null, \$param2=null){<br />
			echo \"index hit\";<br />
		}<br />
	}<br />
	<br />
?&gt;</pre>";
	
	
}


//
//--- AutoLoading--------------------------------------------------------------
//

function __autoload($class_name)
{
	
	$locations = array(
			'framework',
			'controllers',			
			// additional locations
	);

	//loop through and load each class as needed
	foreach($locations as $location){
		$target = APP_ROOT . "/$location/" . "$class_name.php";

		if (file_exists($target)){
			require_once($target);
		}
	}

}


//
// -- Load compontents
//

function load_components(){
	$directory = APP_ROOT.'/components';
	
	
	if (! is_dir($directory)) {
		exit('Invalid diretory path');
	}
	
	$files = array();
	
	foreach (scandir($directory) as $file) {
		if ('.' === $file) continue;
		if ('..' === $file) continue;
	
		if (strpos($file,'.php') !== false){
			require_once($directory.'/'.$file);
		}
		 
	}	
}



?>