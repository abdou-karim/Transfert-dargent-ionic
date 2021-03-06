<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ApiResource(
 *      normalizationContext={"groups"={"profile:read"}},
 *     denormalizationContext={"groups"={"profile:write"}},
 *     routePrefix="adminSysteme",
 *     attributes={
 *       "pagination_enabled"=true,
 *          "pagination_items_per_page"=2,
 *      "security_message"="Acces non autorisé",
 *     "security"= "is_granted('ROLE_AdminSysteme')",
 *     },
 *     collectionOperations={
 *          "GET",
 *          "POST",
 *     },
 *     itemOperations={
 *          "GET",
 *          "PUT",
 *          "DELETE"
 *     },
 *     )
 *
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "user:write"})
     * @Groups({"profile:read", "profile:write","getAllProfile"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups({"compte:read", "compte:write"})
     * @Groups({"profile:read", "profile:write","getAllProfile"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user:write"})
     */
    private $archivage;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="profiles")
     *  @Groups({"profile:read"})
     * @ApiSubresource()
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addProfile($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeProfile($this);
        }

        return $this;
    }
}
