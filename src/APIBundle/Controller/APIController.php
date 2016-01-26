<?php

namespace APIBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use UserBundle\Entity\User;

class APIController extends Controller
{
    public function authenticateAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username', '');
            $password = $request->request->get('password', '');

            $user_manager = $this->get('fos_user.user_provider.username');
            $factory = $this->get('security.encoder_factory');

            $user = $user_manager->loadUserByUsername($username);

            $encoder = $factory->getEncoder($user);

            $authenticationSuccess = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());


            $response = array(
                'result' => $authenticationSuccess,
                'stations' => array()
            );

            foreach($user->getWeatherStations() as $weatherStation){
                array_push($response['stations'], array(
                    'name' => $weatherStation->getName(),
                    'location' => $weatherStation->getLocation(),
                    'pin' => $weatherStation->getPin()
                ));
            }
            return new Response(json_encode($response));
        }
        return new Response("Invalid request.");
    }

    public function updateStationInfoAction(Request $request){
        if ($request->isMethod('POST')) {
            $pin = $request->request->get('pin', '');
            $temperature = $request->request->get('temperature', '');;
            $humidity = $request->request->get('humidity', '');;

            $response = array('result' => 'failed');

            if(strlen($pin) > 0 && strlen($temperature > 0) && strlen($humidity) > 0) {
                $response = array(
                    'result' => 'success'
                );
            }

            return new Response(json_encode($response));
        }
        return new Response("Invalid request.");
    }
}