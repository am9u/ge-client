<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AuthPage extends Controller_Page
{
    // Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
    // Can be set to a string or an array, for example 'login' or array('login', 'admin')
    // Note that in second(array) example, user must have both 'login' AND 'admin' roles set in database
    public $auth_required = FALSE;

    // Controls access for separate actions
    // 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
    // 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
    public $secure_actions = FALSE;

    
    /**
    * The before() method is called before your controller action.
    * In our template controller we override this method so that we can
    * set up default values. These variables are then available to our
    * controllers if they need to be modified.
    */
    public function before()
    {
        parent::before();

        // Open session
        $this->session= Session::instance();

        $request = Request::instance();

        // Check user auth and role
        $action_name = $request->action;
        if (($this->auth_required !== FALSE && self::logged_in($this->auth_required) === FALSE)
                || (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && 
                self::logged_in($this->secure_actions[$action_name]) === FALSE))
        {
            if (self::logged_in())
            {
                $request->redirect(Route::get('default')->uri(array('controller' => 'account', 'action' => 'noaccess')));
            }
            else
            {
                $request->redirect(Route::get('default')->uri(array('controller' => 'account', 'action' => 'login')).URL::query(array('continue' => $request->url())));
            }
        }

    }

    protected static function logged_in($roles=NULL)
    {
        $logged_in = FALSE;

        $token = Cookie::get('auth_token');

        if($token !== NULL)
        {
            $client = ServiceClient::factory('user');
            $client->identify(array('token' => $token));
            if($client->status['type'] === 'success')
            {
                $user_roles = $client->data->roles;

                if($roles === NULL)
                {
                    $logged_in = TRUE;
                }
                elseif( ! is_array($roles))
                {
                    $logged_in = in_array($roles, $user_roles);
                }
                else
                {
                    foreach($roles as $role)
                    {
                        $logged_in = TRUE;
                        if( ! in_array($role, $user_roles))
                        {
                            $logged_in = FALSE;
                            break;
                        }
                    }

                }
            }
        }

        return $logged_in;
    }

}
