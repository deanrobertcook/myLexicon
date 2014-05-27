<?php
class Router {
	private $controller;
	private $action;
	private $params;
	
	private $basePath	= "myLexicon/";
	
	public function __construct(array $options = array()) {
		if (empty($options)) { 
			$options = $this->getParamsFromURL();
		}
		$this->controller = new Controller();
		$this->setAction($options['action']);
		$this->setParams($options['params']);
	}
	
	private function getParamsFromURL() {
		$path = $_SERVER["REQUEST_URI"];
		$path = trim($path, "/");
		$path = substr($path, strlen($this->basePath));
		
		$options = array(
			'action' => null,
			'params' => array(),
		);
		
		if (strlen($path) > 0) {
			$path = explode("/", $path);
			
			for ($i = 0; $i < sizeof($path); $i++) {
				if ($i == 0) {
					$options['action'] = $path[$i];
				} else {
					$options['params'][$i-1] = $path[$i];
				}
			}
		}
		return $options;
	}	
	
	private function setAction($action) {
		$reflector = new \ReflectionClass(get_class($this->controller));
		if ($reflector->hasMethod($action)) {
			$this->action = $action;
		} else {
			$this->action = "defaultAction";
		}
	}
	
	private function setParams($params = array()) {
		$this->params = $params;
	}
	
	public function runController() {
		$action = $this->action;
		$params = $this->params;
		$this->controller->{$action}($params);
	}	
}