<?php

namespace App\Repository;

use App\Entity\Trabajadores;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class TrabajadoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trabajadores::class);
    }

    public function guardar(Trabajadores $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function borrar(Trabajadores $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function pageall(): array 
    {
        $SQL = $this->createQueryBuilder('t')
        ->select('t.id','t.nombre','t.cedula','t.cargo','t.celular')
        ->orderBy('t.id', 'ASC');

    return $SQL
        ->getQuery()
        ->getArrayResult();
    }

    public function probando():array 
    {
        $SQL = $this->createQueryBuilder('t')
        ->select('t.id','t.nombre','t.cedula')
        ->orderBy('t.id', 'ASC');

    return $SQL
        ->getQuery()
        ->getArrayResult();
      
    }
}
