<?php

namespace App\Entity;

use App\Repository\TrasaccionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TrasaccionesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Trasacciones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $update_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $create_at = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $fecha_entrada = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $fecha_salida = null;

    #[ORM\Column(nullable: true)]
    private ?int $estado = null;

    #[ORM\ManyToOne]
    private ?Trabajadores $trabajadores = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeImmutable $update_at): static
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(?\DateTimeImmutable $create_at): static
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getFechaEntrada(): ?\DateTimeImmutable
    {
        return $this->fecha_entrada;
    }

    public function setFechaEntrada(?\DateTimeImmutable $fecha_entrada): static
    {
        $this->fecha_entrada = $fecha_entrada;

        return $this;
    }

    public function getFechaSalida(): ?\DateTimeImmutable
    {
        return $this->fecha_salida;
    }

    public function setFechaSalida(?\DateTimeImmutable $fecha_salida): static
    {
        $this->fecha_salida = $fecha_salida;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(?int $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getTrabajadores(): ?Trabajadores
    {
        return $this->trabajadores;
    }

    public function setTrabajadores(?Trabajadores $trabajadores): self
    {
        $this->trabajadores = $trabajadores;

        return $this;
    }

    #[ORM\PrePersist]
    public function ingreso(): void
    {
        $this->estado = 0;
        $this->fecha_entrada = new \DateTimeImmutable();
        $this->create_at = new \DateTimeImmutable();
        $this->update_at= new \DateTimeImmutable();
        
    }

    #[ORM\PreUpdate]
    public function salio(): void
    {
        $this->estado = 1;
        $this->fecha_salida = new \DateTimeImmutable();
        $this->update_at= new \DateTimeImmutable();
    }
}
