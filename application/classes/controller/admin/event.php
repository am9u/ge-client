<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Event extends Controller_Admin_Page
{

    private function _get_venues()
    {
        // get data from REST endpoint
        $client   = REST_client::instance(); 
        $response = $client->get('venue');

        // working with the XML response
        $data   = XML::factory(NULL, NULL, $response->data);
        $data   = $data->as_array();

        $venues = array();
        foreach($data['venues'][0]['venue'] as $venue)
        {
            // $venues[$venue['xml_attributes']['id']] = array(
            //     'id'             => $venue['xml_attributes']['id'],
            //     'name'           => $venue['name'][0],
            //     'address_1'      => $venue['address'][0]['address_1'][0],
            //     //'address_2'      => $venue['address'][0]['address_2'][0],
            //     'city'           => $venue['address'][0]['city'][0],
            //     'state_province' => $venue['address'][0]['state_province'][0],
            //     //'zip'            => $venue['address'][0]['zip'][0],
            // );

            $venues[$venue['xml_attributes']['id']] = $venue['name'][0];

        }

        return $venues;
    }

    public function action_index()
    {
        // get data from REST endpoint
        $client   = REST_client::instance(); 
        $response = $client->get('event');

        // working with the XML response
        $data   = XML::factory(NULL, NULL, $response->data);
        $data   = $data;
        // $this->request->response = print_r($data);

        //$events = $data['events'][0]['event'];


        $oevents = array();

        $events = $data->get('event');

        foreach($events as $event)
        {
            $name = $event->get('name');

            //print_r($name['dom_node']);

            $oevents[] = array(
                'id'          => $event->attributes('id'), //['xml_attributes']['id'],
                'name'        => $event->name->value(),
                'date'        => Date::formatted_time($event->datetime->value(), 'm/d/y', 'America/New_York'), // @TODO: account for timezone of group! ie: NY.com vs LA.com
                'time'        => Date::formatted_time($event->datetime->value(), 'g:i A', 'America/New_York'), // $date->format("g:i A"),
                'description' => $event->description->value()
            );
        }

        //echo Kohana::debug($oevents);

        $this->page_title = "Events";
        $this->_content = View::factory("pages/admin/event/index")
                            ->bind("events", $oevents);


        //another example of hitting a REST endpoint
        //
        //$client   = REST_client::instance('lastfm');
        //$response = $client->get('', array(
        //        'method'  => 'user.getrecenttracks',
        //        'user'    => 'jonnyheadphones',
        //        'api_key' => 'b25b959554ed76058ac220b7b2e0a026'
        //    ));

        // working with the REST response
        //
        // $this->request->response = $client->last_uri.'<br/>';
        // $this->request->response .= 'status: '.$response->status.'<br/>';
        // $this->request->response .= $response->data;

        // TODO: figure out how the XML library's get() method's return value works!
        //
        // $events = $data->get('event');
        // $this->request->response = print_r($events).'<br/><br/>';
        // foreach($events as $event)
        // {
        //     $this->request->response .= $event->nodeValue.'<br/>';
        // }

    }


    public function action_create() 
    {
        $log = Kohana_Log::instance();

        if( ! isset($_POST['submit']))
        {
            $venues = $this->_get_venues();
            Kohana::$log->add('debug action_create()', 'number of venues='.count($venues));

            $view = View::factory('admin/event/create');
            $view->bind('venues', $venues);
            $this->request->response = $view;
        }
        else 
        {
            $client   = REST_client::instance('api_writer');
            $data     = array();
            // print_r($_POST);
            foreach($_POST as $key => $val)
            {
                if(is_array($val))
                {
                    foreach($val as $i => $v)
                    {
                        $data[$key.'['.$i.']'] = $v;
                    }
                }
                else
                {
                    $data[$key] = $val;   
                }
            }

            $log->add('admin event create', 'POST request to API made');
            $log->add('admin event create', '$_POST size is '.count($data));
            $log->add('admin event create', '$_POST is '.$data);
            $log->write();

            print_r($data);

            $response = $client->post('event', $data);

            if($response->status == '200')
            {
                $out = 'Successfully created Event<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
            }
            else
            {
                $out = 'Error creating Event<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
            }

            $this->request->response = $out;
        }
    }

    public function action_create_photo()
    {
        if( ! isset($_POST['submit']))
        {
            $view = View::factory('upload');
            $this->request->response = $view;
        }
        else 
        {
            $client   = REST_client::instance('file_upload');

            Upload::save($_FILES['photo'], $_FILES['photo']['name']);
            $photo_path = '@upload/'.$_FILES['photo']['name'].';type='.$_FILES['photo']['type'];
            $data = array('photo' => $photo_path);

            // $response = $client->post('photo', $data);
            $response = $client->post('photo', $data);

            if($response->status == '200')
            {
                $out = 'Successfully created photo<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
            }
            else
            {
                $out = 'Error creating photo<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
            }

            $this->request->response = $out;
        }
    }

    public function action_update ($id=NULL)
    {
        if( ! isset($_POST['id']))
        {
            $view = View::factory('admin/event/update');
            $view->bind('event', $event);
            $event = ORM::factory('event', $id);
            $this->request->response = $view;
        }
        else 
        {
            $client   = REST_client::instance('api_writer');
            $response = $client->put('event/update/'.$_POST['id'], $_POST);
            
            if($response->status == '200')
            {
                $out = 'Successfully updated Event ID='.$_POST['id'].'<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
            }
            else
            {
                $out = 'Error updating Event ID='.$_POST['id'].'<br/>Status code: '.$response->status.'<br/>Response:'.$response->data;
            }

            $this->request->response = $out;

            // $put_request = Request::factory('/event/update/'.$_POST['id']);
            // // $put_request->method = 'PUT';
            // Request::$method = 'PUT';

            // $data = $put_request->execute()->send_headers()->response;
            // 
            // // Kohana::debug($data);

            // Request::$method = 'GET';
            // $this->request->response = $data;


        }
    }
}
