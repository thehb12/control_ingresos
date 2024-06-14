<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types; 
use App\Repository\TrabajadoresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrabajadoresRepository::class)]
class Trabajadores
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cargo = null;

    #[ORM\Column(nullable: true)]
    private ?int $cedula = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $celular = null; 
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(?string $cargo): static
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function getCedula(): ?int
    {
        return $this->cedula;
    }

    public function setCedula(?int $cedula): static
    {
        $this->cedula = $cedula;

        return $this;
    }

    public function getCelular(): ?string
    {
        return $this->celular;
    }

    public function setCelular(?string $celular): static
    {
        $this->celular = $celular;

        return $this;
    }

}
