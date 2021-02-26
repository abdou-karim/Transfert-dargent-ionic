<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ApiResource(
 *     collectionOperations={"GET","POST"},
 *     itemOperations={"GET"={"defaults"={"id"=null},},"PUT","DELETE"}
 * )
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $nomClient;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $numeroClient;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $nomBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $numeroBeneficiaire;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $cniBeneficiaire;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="client")
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

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getNumeroClient(): ?string
    {
        return $this->numeroClient;
    }

    public function setNumeroClient(string $numeroClient): self
    {
        $this->numeroClient = $numeroClient;

        return $this;
    }

    public function getNomBeneficiaire(): ?string
    {
        return $this->nomBeneficiaire;
    }

    public function setNomBeneficiaire(string $nomBeneficiaire): self
    {
        $this->nomBeneficiaire = $nomBeneficiaire;

        return $this;
    }

    public function getNumeroBeneficiaire(): ?string
    {
        return $this->numeroBeneficiaire;
    }

    public function setNumeroBeneficiaire(string $numeroBeneficiaire): self
    {
        $this->numeroBeneficiaire = $numeroBeneficiaire;

        return $this;
    }

    public function getCniBeneficiaire(): ?string
    {
        return $this->cniBeneficiaire;
    }

    public function setCniBeneficiaire(string $cniBeneficiaire): self
    {
        $this->cniBeneficiaire = $cniBeneficiaire;

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
            $transaction->setClient($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transaction->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getClient() === $this) {
                $transaction->setClient(null);
            }
        }

        return $this;
    }
}
