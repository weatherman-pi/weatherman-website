<?php

namespace APIBundle\Controller;


use AppBundle\Entity\WeatherStation;
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


            $response = array();
            if (!$this->verifyAuthentication($username, $password)) {
                $response = array(
                    'result' => false,
                    'reason' => 'Authentication failed'
                );
            } else {
                $response = array(
                    'result' => true,
                    'stations' => array()
                );

                foreach ($this->getUserByName($username)->getWeatherStations() as $weatherStation) {
                    array_push($response['stations'], array(
                        'name' => $weatherStation->getName(),
                        'location' => $weatherStation->getLocation(),
                        'pin' => $weatherStation->getPin()
                    ));
                }
            }
            return new Response(json_encode($response));
        }
        return new Response("Invalid request.");
    }

    public function createStationAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username', '');
            $password = $request->request->get('password', '');
            $pcname = $request->request->get('pcname', '');
            $location = $request->request->get('location', '');

            if ($this->verifyAuthentication($username, $password)) {

                $user = $this->getUserByName($username);
                $weatherStation = $this->getDoctrine()->getRepository('AppBundle:WeatherStation')->getWeatherStationByName($pcname, $user->getId());

                if ($weatherStation != null ) {
                    return new Response(json_encode(array('result' => true, 'pin' => $weatherStation->getPin())));
                } else {
                    $weatherStation = new WeatherStation();
                    $weatherStation->setUser($user);
                    $weatherStation->setLocation($location);
                    $weatherStation->setName($pcname);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($weatherStation);
                    $em->flush();

                    return new Response(json_encode(array('result' => true, 'pin' => $weatherStation->getPin())));
                }
            } else {
                return new Response(json_encode(array(
                    'result' => false,
                    'reason' => 'Authentication failed'
                )));
            }
        }
        return new Request('Invalid request.');
    }

    public function updateStationInfoAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $pin = $request->request->get('pin', '');
            $temperature = $request->request->get('temperature', '');;
            $humidity = $request->request->get('humidity', '');;

            $response = array('result' => 'failed');

            if (strlen($pin) > 0 && strlen($temperature > 0) && strlen($humidity) > 0) {
                $response = array(
                    'result' => 'success'
                );
            }

            return new Response(json_encode($response));
        }
        return new Response("Invalid request.");
    }

    private function getUserByName($username)
    {
        return $this->get('fos_user.user_provider.username')->loadUserByUsername($username);
    }

    private function verifyAuthentication($username, $password)
    {
        $factory = $this->get('security.encoder_factory');

        $user = $this->getUserByName($username);
        $encoder = $factory->getEncoder($user);

        return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
    }
}