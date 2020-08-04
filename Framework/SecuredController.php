<?php
namespace Blog\Framework;
use Blog\Exceptions\NotEnoughRightsException;
use Blog\Exceptions\UserNotConnectedException;
use Blog\Model\User;
/**
 * 
 */
abstract class SecuredController extends Controller
{
	
    public function __construct(View $view, Session $session){
	    if (!$session->isAuthenticated()) {
	    	throw new UserNotConnectedException();
	    }
    	if (!$session->isAdmin()) {
    		throw new NotEnoughRightsException();
    	}

    	$this->templating = $view;
    	$this->session = $session;
    }
}
