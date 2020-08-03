<?php
namespace Blog\Framework;

/**
 * 
 */
abstract class Controller
{

    public $templating;
    public $session;

    public function __construct(View $view, Session $session){
    	$this->templating = $view;
    	$this->session = $session;
    }

	// abstract static public function display();

	protected function render(string $path, array $params = [], bool $tinyNeeded = false){
		$params += ['session'=> $this->session];
		$this->templating::render($path,$params,$tinyNeeded);
	}

	protected function redirect($path){
		header("Location: ".$path);
	}
	
	//abstract public function display();
}
