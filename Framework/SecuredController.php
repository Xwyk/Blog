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
	    if (!$session->existAttribute($session::AUTHENTICATED_KEY)) {
	    	throw new UserNotConnectedException();
	    }
    	// if ($session->getAttribute($session::AUTHENTICATED_KEY)->getType()!=User::TYPE_ADMIN) {
    	// 	throw new NotEnoughRightsException();
    	// }

    	$this->templating = $view;
    	$this->session = $session;
    }
}
