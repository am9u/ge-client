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

    protected $user = NULL;

    public $group_required = FALSE; // 'group_admin'
    public $group_required_actions = FALSE;

    protected $_group_id = NULL;

    
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
        if (($this->auth_required !== FALSE && $this->logged_in($this->auth_required) === FALSE)
                || (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && 
                $this->logged_in($this->secure_actions[$action_name]) === FALSE))
        {
            Kohana::$log->add('debug', 'Controller_AuthPage --> user failed auth roles check');

            if (self::logged_in())
            {
                $request->redirect(Route::get('default')->uri(array('controller' => 'account', 'action' => 'noaccess')));
            }
            else
            {
                $request->redirect(Route::get('default')->uri(array('controller' => 'account', 'action' => 'login')).URL::query(array('continue' => $request->url())));
            }
        }
        
        // check group roles
        if ($this->group_required !== FALSE 
                OR (is_array($this->group_required_actions) && array_key_exists($action_name, $this->group_required_actions)))
        {
            
            Kohana::$log->add('debug', 'Controller_AuthPage --> group roles check is required');

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
                }

                if ($this->_group_id !== NULL)
                {
                    $required_groups = array();

                    if ($this->group_required !== FALSE)
                    {
                        $required_groups[$this->_group_id] = $this->group_required;
                    }
                    else
                    {
                        $required_groups[$this->_group_id] = $this->group_required_actions[$action_name];
                    }
                }

                if (self::is_group_required($required_groups) === FALSE) 
                {
                    Kohana::$log->add('debug', 'Controller_AuthPage --> user failed group roles check');

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
        }

    }

    /**
     * Checks if user is logged in and has privileges to invoke a requested controller's action
     */
    protected function logged_in($roles=NULL)
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
                $user_roles = $this->user->roles;

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

    //protected static function is_group_required($group_id = NULL, $roles = NULL)
    protected static function is_group_required($groups = NULL)
    {
        $logged_in = FALSE;

        //Kohana::$log->add('debug', 'Controller_AuthPage::is_group_required -- group_id='.$group_id.' roles='.$roles);

        $token = Cookie::get('auth_token');

        if($groups !== NULL AND $token !== NULL)
        {
            // identify user
            $client = ServiceClient::factory('user');
            $client->identify(array('token' => $token));

            if($client->status['type'] === 'success')
            {
                // admin users can access all group views
                $user_roles = $client->data->roles;

                if(in_array('admin', $user_roles))
                {
                    $logged_in = TRUE;
                }

                // if user isn't admin, then check user's group roles
                else
                {

                    $valid_groups = array_keys($groups);

                    $user_groups = $client->data->groups;

                    foreach($user_groups as $group)
                    {

                        // Kohana::$log->add('debug', 'Controller_AuthPage::is_group_required -- group check '.$group['id'].'==='.$group_id);

                        if(in_array($group['id'], $valid_groups))
                        {
                            $roles = $groups[$group['id']];

                            if ($roles === TRUE OR $roles === NULL)
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
        }

        return $logged_in;
    }

}
