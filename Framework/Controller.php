<?php
namespace Blog\Framework;

/**
 * 
 */
abstract class Controller
{
    const URL_ADMIN="/?action=admin";
	const URL_HOME="/?action=home";
	const URL_LOGIN="/?action=login";
	const URL_LOGOUT="/?action=logout";
	const URL_REGISTER="/?action=register";
	const URL_POST="/?action=post&id=";
	const URL_ADDPOST="/?action=addPost";
	const URL_ADDCOMMENT="/?action=addComment&postId=";
    
	const VIEW_ADDPOST="addPost";
	const VIEW_ADMIN="admin";
	const VIEW_EDITPOST="editPost";
	const VIEW_HOME="home";
	const VIEW_LOGIN="login";
	const VIEW_POST="post";
	const VIEW_REGISTER="register";

    public $templating;
    public $session;

    public function __construct(View $view, Session $session){
    	$this->templating = $view;
    	$this->session = $session;
    }

	// abstract static public function display();

	protected function render(string $path, array $params = []){
		$params += ['session'=> $this->session];
		$this->templating::render($path,$params);
	}

	protected function redirect($path){
		header("Location: ".$path);
	}
	
	//abstract public function display();
}
