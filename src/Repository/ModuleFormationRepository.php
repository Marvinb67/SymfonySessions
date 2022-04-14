<?php

namespace App\Repository;

use App\Entity\ModuleFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModuleFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleFormation[]    findAll()
 * @method ModuleFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleFormation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ModuleFormation $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ModuleFormation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getNonPlanifier($idSession)
    {
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $qb = $sub;
        $qb->select('m')
            ->from('APP\Entity\ModuleFormation', 'm')
            ->leftJoin('m.planifiers', 'p')
            ->where('p.id = :id');

        $sub = $em->createQueryBuilder();
        $sub->select('mf')
            ->from('App\Entity\ModuleFormation', 'mf')
            ->where($sub->expr()->notIn('mf.id', $qb->getDQL()))
            ->setParameter('id', $idSession)
            ->orderBy('mf.categories');

        $query = $sub->getQuery();

        return $query->getResult();
    }

    // /**
    //  * @return ModuleFormation[] Returns an array of ModuleFormation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModuleFormation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
