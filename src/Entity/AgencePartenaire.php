<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AgencePartenaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AgencePartenaireRepository::class)
 * @ApiResource
 */
class AgencePartenaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte:read", "compte:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:read", "compte:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:read", "compte:write"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:read", "compte:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:read", "compte:write"})
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agencePartenaire")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setAgencePartenaire($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgencePartenaire() === $this) {
                $user->setAgencePartenaire(null);
            }
        }

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }
}
