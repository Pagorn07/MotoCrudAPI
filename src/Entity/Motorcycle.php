<?php

namespace App\Entity;

use ApiPlatform\Metadata\{ApiResource, Get, GetCollection, Post, Patch, Delete};
use App\Repository\MotorcycleRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MotorcycleRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['motorcycle:read']]),
        new GetCollection(normalizationContext: ['groups' => ['motorcycle:read']]),
        new Post(
            normalizationContext: ['groups' => ['motorcycle:read']],
            denormalizationContext: ['groups' => ['motorcycle:write', 'motorcycle:create']]
        ),
        new Patch(
            normalizationContext: ['groups' => ['motorcycle:read']],
            denormalizationContext: ['groups' => ['motorcycle:write']]
        ),
        new Delete()
    ]
)]
class Motorcycle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['motorcycle:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El modelo es obligatorio")]
    #[Assert\Length(max: 50)]
    #[Groups(['motorcycle:read', 'motorcycle:write'])]
    private ?string $model = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La cilindrada es obligatoria")]
    #[Assert\Type(type: 'integer')]
    #[Groups(['motorcycle:read', 'motorcycle:write'])]
    private ?int $engineCapacity = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(message: "La marca es obligatoria")]
    #[Assert\Length(max: 40)]
    #[Groups(['motorcycle:read', 'motorcycle:write'])]
    private ?string $brand = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El tipo es obligatorio")]
    #[Groups(['motorcycle:read', 'motorcycle:write'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::JSON)]
    #[Assert\NotNull(message: "Los extras son obligatorios")]
    #[Assert\Count(max: 20, maxMessage: "No puede haber más de 20 extras")]
    #[Assert\All([
        new Assert\Type(type: 'string', message: 'Cada extra debe ser un string')
    ])]
    #[Groups(['motorcycle:read', 'motorcycle:write'])]
    private array $extras = [];

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['motorcycle:read', 'motorcycle:write'])]
    private ?int $weight = null;

    #[ORM\Column]
    #[Groups(['motorcycle:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['motorcycle:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Edición limitada es obligatorio")]
    #[Assert\Type(type: 'bool')]
    #[Groups(['motorcycle:read', 'motorcycle:create'])]
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
