<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MotorcycleRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MotorcycleRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Motorcycle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El modelo es obligatiorio")]
    #[Assert\Length(max: 50)]
    private ?string $model = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La cilindrada es obligatoria")]
    #[Assert\Type(type: 'integer')]
    private ?int $engineCapacity = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(message: "La marca es obligatoria")]
    #[Assert\Length(max: 40)]
    private ?string $brand = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El tipo es obligatorio")]
    private ?string $type = null;

    #[ORM\Column(type: Types::JSON)]
    #[Assert\NotBlank(message: "Los extras son obligatorios")]
    #[Assert\Count(max: 20, maxMessage: "No puede haber más de 20 extras")]
    #[Assert\All([
        new Assert\Type(type: 'string', message: 'Cada extra debe ser un string')
    ])]
    private array $extras = [];

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: 'integer')]
    private ?int $weight = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Edición limitada es obligatorio")]
    #[Assert\Type(type: 'bool')]
    private ?bool $limitedEdition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;
        return $this;
    }

    public function getEngineCapacity(): ?int
    {
        return $this->engineCapacity;
    }

    public function setEngineCapacity(int $engineCapacity): static
    {
        $this->engineCapacity = $engineCapacity;
        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getExtras(): array
    {
        return $this->extras;
    }

    public function setExtras(array $extras): static
    {
        $this->extras = $extras;
        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isLimitedEdition(): ?bool
    {
        return $this->limitedEdition;
    }

    public function setLimitedEdition(bool $limitedEdition): static
    {
        $this->limitedEdition = $limitedEdition;
        return $this;
    }
}
