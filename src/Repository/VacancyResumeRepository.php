<?php

namespace App\Repository;

use App\Entity\VacancyResume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VacancyResume>
 *
 * @method VacancyResume|null find($id, $lockMode = null, $lockVersion = null)
 * @method VacancyResume|null findOneBy(array $criteria, array $orderBy = null)
 * @method VacancyResume[]    findAll()
 * @method VacancyResume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacancyResumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VacancyResume::class);
    }

    public function save(VacancyResume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VacancyResume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
