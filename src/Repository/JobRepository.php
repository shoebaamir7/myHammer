<?php

namespace App\Repository;

use App\Entity\Job;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Job::class);
    }


    /**
     * @param Job $job
     * @throws Exception
     */
    public function save(Job $job)
    {
        $em = $this->getEntityManager();
        $em->persist($job);
        $em->flush();
    }

    /**
     * @param string $servicefilter
     * @param string $regionfilter
     * @return mixed
     */
    public function findJObsByServiceAndRegion($servicefilter = '', $regionfilter = '')
    {
        $dt = date('Y-m-d', strtotime('-30 days'));
        $lastMonth = new DateTime($dt);
        $lastMonth->setTime(0, 0);
        $qb = $this->createQueryBuilder('j');
        $qb->select(
            'j.id as JobId',
            'j.title',
            'j.description',
            'j.jobDate',
            'cat.title',
            'r.city',
            'r.zipCode',
            'r.country',
            'u.name',
            'u.email'
        );
        $qb->leftJoin('j.categoryType','cat')
            ->leftJoin('j.region','r')
            ->leftJoin('j.user','u');
        $qb->where('j.jobDate > :lastMonth')
            ->setParameter('lastMonth', $lastMonth);
        if(!empty($servicefilter)) {
            $qb->andWhere('LOWER(cat.title) LIKE LOWER(:servicefilter)')
                ->setParameter('servicefilter', '%' . addcslashes($servicefilter, '%_') . '%');
        }

        if(!empty($regionfilter)) {
            $qb->andWhere('LOWER(r.city) LIKE LOWER(:regionfilter) OR LOWER(r.country) LIKE LOWER(:regionfilter) OR r.zipCode LIKE LOWER(:regionfilter)')
                ->setParameter('regionfilter', '%' . addcslashes($regionfilter , '%_') . '%');
        }

        return $qb->getQuery()->getResult();
    }

}
