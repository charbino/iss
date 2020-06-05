<?php


namespace App\Repository;


use App\Entity\HistoryImportEssenceData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class HistoryImportEssenceDataRepository
 *
 * @package App\Repository
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class HistoryImportEssenceDataRepository extends ServiceEntityRepository
{

    /**
     * HistoryImportEssenceDataRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryImportEssenceData::class);
    }

    /**
     * @return array
     */
    public function findTheLatest(): array
    {
        $queryBuilder = $this->createQueryBuilder('h');

        return $queryBuilder
            ->orderBy('h.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

}
