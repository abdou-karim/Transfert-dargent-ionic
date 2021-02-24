<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ApiResource(
 *     normalizationContext={"groups"={"compte:read"}},
 *     denormalizationContext={"groups"={"compte:read"}},
 *     routePrefix="/adminSysteme",
 *     attributes={
 *      "security_message"="Acces non autorisé",
 *     "security"= "is_granted('ROLE_AdminSysteme')",
 *      "pagination_enabled"=true,
 *          "pagination_items_per_page"=5,
 *     },
 *     collectionOperations={
 *          "GET",
 *          "POST",
 *     },
 *     itemOperations={
 *          "GET",
 *           "PUT",
 *          "DELETE"
 *     },
 *     )
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("compte:read")
     * @Groups({"trans_compte:read", "trans_compte:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:read", "compte:write"})
     * @Groups({"trans_compte:read", "trans_compte:write"})
     * @Assert\NotBlank
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:read", "compte:write"})
     * @Groups({"trans_compte:read", "trans_compte:write"})
     * @Assert\NotBlank
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups({"compte:read", "compte:write"})
     * @Assert\NotBlank
     *
     */
    private $dateRechargement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comptes")
     * @Groups("compte:read")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=AgencePartenaire::class, cascade={"persist", "remove"})
     * @Groups({"compte:read", "compte:write"})
     * @Assert\NotBlank
     */
    private $agencePartenaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="compte")
     */
    private $transaction;

    public function __construct()
    {
        $this->transaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateRechargement(): ?\DateTimeInterface
    {
        return $this->dateRechargement;
    }

    public function setDateRechargement(\DateTimeInterface $dateRechargement): self
    {
        $this->dateRechargement = $dateRechargement;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAgencePartenaire(): ?AgencePartenaire
    {
        return $this->agencePartenaire;
    }

    public function setAgencePartenaire(?AgencePartenaire $agencePartenaire): self
    {
        $this->agencePartenaire = $agencePartenaire;

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
     * @return Collection|Transaction[]
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transaction->contains($transaction)) {
            $this->transaction[] = $transaction;
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transaction->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }
}
