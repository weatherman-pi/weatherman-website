<?php

namespace APIBundle\Controller;


use AppBundle\Entity\WeatherStation;
use AppBundle\Entity\WeatherStationData;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
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
            $username = $request->request->get('username', '');
            $password = $request->request->get('password', '');
            $temperature = $request->request->get('temperature', '');
            $humidity = $request->request->get('humidity', '');
            $pressure = $request->request->get('pressure');

            if ($this->verifyAuthentication($username, $password)) {
                $user = $this->getUserByName($username);

                if(is_numeric($temperature) && is_numeric($humidity) && is_numeric($pressure)){
                    $weatherStation = $this->getDoctrine()->getRepository('AppBundle:WeatherStation')->getWeatherStationByPin($pin);

                    if(isset($weatherStation)){
                        $weatherStationData = new WeatherStationData();
                        $weatherStationData->setWeatherStation($weatherStation);
                        $weatherStationData->setTemperature($temperature);
                        $weatherStationData->setHumidity($humidity);
                        $weatherStationData->setPressure($pressure);
                        $weatherStationData->setUpdateTime(new \DateTime("now", new \DateTimeZone('Canada/Eastern')));

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($weatherStationData);
                        $em->flush();

                        return new Response(json_encode(array('result' => true)));
                    } else {
                        return new Response(json_encode(array(
                            'result' => false,
                            'reason' => 'Invalid weather station pin.'
                        )));
                    }

                } else {
                    return new Response(json_encode(array(
                        'result' => false,
                        'reason' => 'Invalid parameters'
                    )));
                }
            } else {
                return new Response(json_encode(array(
                    'result' => false,
                    'reason' => 'Authentication failed'
                )));
            }
        }
        return new Response("Invalid request.");
    }

    private function getUserByName($username)
    {
        try {
            return $this->get('fos_user.user_provider.username')->loadUserByUsername($username);
        }catch(UsernameNotFoundException $e) {
            return null;
        }
    }

    private function verifyAuthentication($username, $password)
    {
        $factory = $this->get('security.encoder_factory');

        $user = $this->getUserByName($username);

        if(!$user) return false;
        
        $encoder = $factory->getEncoder($user);

        return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
    }
}