<?php
namespace Blog\Framework;

/**
 * 
 */
abstract class Controller
{

    public $templating;
    public $session;

    public function __construct(){
    	$this->templating = new View();
    	$this->session = new session();
    }

	// abstract static public function display();

	protected function render($path,$params = null){
		$this->templating::render($path,$params);
	}

	protected function redirect($path){
		header("Location: ".$path);
	}
}