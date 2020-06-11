<?php
namespace Blog\Framework;
/**
 * 
 */
abstract class Controller
{
	abstract static public function display();

	static public function redirect($path){
		header("Location: ".$path);
	}
}