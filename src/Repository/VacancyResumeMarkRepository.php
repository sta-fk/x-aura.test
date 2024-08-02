<?php

namespace App\Repository;

use App\Entity\VacancyResumeMark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VacancyResumeMark>
 *
 * @method VacancyResumeMark|null find($id, $lockMode = null, $lockVersion = null)
 * @method VacancyResumeMark|null findOneBy(array $criteria, array $orderBy = null)
 * @method VacancyResumeMark[]    findAll()
 * @method VacancyResumeMark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacancyResumeMarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VacancyResumeMark::class);
    }

    public function save(VacancyResumeMark $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VacancyResumeMark $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
