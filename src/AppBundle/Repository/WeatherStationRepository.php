<?php

namespace AppBundle\Repository;

/**
 * WeatherStationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WeatherStationRepository extends \Doctrine\ORM\EntityRepository
{

    public function getWeatherStationByPin($pin)
    {
        return $this->createQueryBuilder('w')
            ->where('w.id = :pin')
            ->setParameter('pin', $pin)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getWeatherStationByName($name, $userID)
    {
        return $this->createQueryBuilder('w')
            ->innerJoin('w.user', 'u')
            ->where('u.id = :userID')
            ->andWhere('w.name = :name')
            ->setParameters(['name' => $name, 'userID' => $userID])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getWeatherStationsForUserID($userID)
    {
        return $this->createQueryBuilder('w')
            ->innerJoin('w.user', 'u')
            ->where('u.id = :userID')
            ->setParameter('userID', $userID)
            ->getQuery()
            ->getResult();
    }
}
