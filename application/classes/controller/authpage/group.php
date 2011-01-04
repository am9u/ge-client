<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AuthPage_Group extends Controller_AuthPage
{
    // Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
    // Can be set to a string or an array, for example 'login' or array('login', 'admin')
    // Note that in second(array) example, user must have both 'login' AND 'admin' roles set in database
    public $auth_required = FALSE;

    // Controls access for separate actions
    // 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
    // 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
    public $secure_actions = FALSE;

    public $group_required = FALSE; // 'group_admin'
    public $group_required_actions = FALSE;

    protected $_group_id;

    
    /**
    * The before() method is called before your controller action.
    * In our template controller we override this method so that we can
    * set up default values. These variables are then available to our
    * controllers if they need to be modified.
    */
    public function before()
    {
        parent::before();

        // get group based on route
        $this->_group_id = NULL;
        $group_name = Request::instance()->param('group', NULL);

        if($group_name !== NULL)
        {
            $group_client = ServiceClient::factory('group');
            $group_client->get_by_name($group_name);

            if($group_client->status['type'] !== 'error')
            {
                $this->_group_id = $group_client->data->id;
                Kohana::$log->add('debug', 'Controller_Admin_Event::action_create() -- $group_id='.$group_id);
            }
        }

        // Open session
        $this->session= Session::instance();

        $request = Request::instance();

        // Check user auth and role
        $action_name = $request->action;

        if (($this->group_required !== FALSE && self::is_group_required($this->auth_required) === FALSE)
                || (is_array($this->group_required_actions) && array_key_exists($action_name, $this->group_required_actions) && 
                self::is_group_required($this->group_required_actions[$action_name]) === FALSE))
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

    protected static function is_group_required($roles)
    {
        $logged_in = FALSE;

        $token = Cookie::get('auth_token');

        if($token !== NULL)
        {
            $client = ServiceClient::factory('user');
            $client->identify(array('token' => $token));
            if($client->status['type'] === 'success')
            {
                $this->user = $client->data;

                $user_groups = $this->user->groups;

                foreach($user_groups as $group)
                {
                    if($group['id'] === $this->_group_id)
                    {
                        if ($this->group_required === TRUE OR $roles === NULL)
                        {
                            $logged_in = TRUE;
                            break;
                        }
                        else if ( ! is_array($roles))
                        {
                            $logged_in = in_array($roles, $group['roles']);
                        }
                        else
                        {
                            foreach($roles as $role)
                            {
                                $logged_in = TRUE;
                                if( ! in_array($role, $group_roles))
                                {
                                    $logged_in = FALSE;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $logged_in;
    }

}
