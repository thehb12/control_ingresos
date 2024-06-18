<?php

namespace App\Repository;

use App\Entity\Trasacciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trasacciones>
 */
class TrasaccionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trasacciones::class);
    }

    public function guardar(Trasacciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function borrar(Trasacciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function pageall(): array
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select(
                't.id',
                'tr.cedula',
                'tr.nombre',
                "DATE_FORMAT(t.fecha_entrada,'%Y-%m-%d %H:%i:%s') fecha_entrada",
                "DATE_FORMAT(t.fecha_salida,'%Y-%m-%d %H:%i:%s') fecha_salida",
                "CASE WHEN t.estado = 1 THEN 'Salio' ELSE 'Ingreso' END as estado ",
            )
            ->leftJoin('t.trabajadores', 'tr')
            ->orderBy('t.id', 'DESC');

        $results = $queryBuilder
            ->getQuery()
            ->getArrayResult();

        return $results;
    }
    public function pagepagination(int $offset, int $limit, string $search): array
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select(
                't.id',
                'tr.cedula',
                'tr.nombre',
                "DATE_FORMAT(t.fecha_entrada,'%Y-%m-%d %H:%i:%s') fecha_entrada",
                "DATE_FORMAT(t.fecha_salida,'%Y-%m-%d %H:%i:%s') fecha_salida",
                "CASE WHEN t.estado = 1 THEN 'Salio' ELSE 'Ingreso' END as estado ",
            )
            ->leftJoin('t.trabajadores', 'tr')
            ->orderBy('t.id', 'DESC');
    
        ($search != 'null') && $queryBuilder->andWhere('tr.cedula LIKE :cedula')
            ->setParameter('cedula', '%' . $search . '%');

        $queryBuilder->setFirstResult($offset)
            ->setMaxResults($limit);
        return  $queryBuilder
            ->getQuery()
            ->getArrayResult();
    }

    public function pagetotal(): int
    {

        $queryBuilder = $this->createQueryBuilder('t')
            ->select('COUNT(t.id)');
        return  $queryBuilder
            ->getQuery()
            ->getSingleScalarResult();
    }
}
