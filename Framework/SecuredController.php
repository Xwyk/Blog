<?php
namespace Blog\Framework;
use Blog\Exceptions\NotEnoughRightsException;
use Blog\Exceptions\UserNotConnectedException;
/**
 * 
 */
abstract class SecuredController extends Controller
{
	public function __construct(View $view, Session $session){
	    if (!$session->existAttribute($session::AUTHENTICATED_KEY)) {
	    	if ($session->getAttribute($session::AUTHENTICATED_KEY)!=User::TYPE_ADMIN) {
	    		throw new NotEnoughRightsException();
	    	}
	    	throw new UserNotConnectedException();
	    }

    	$this->templating = $view;
    	$this->session = $session;
    }
}
