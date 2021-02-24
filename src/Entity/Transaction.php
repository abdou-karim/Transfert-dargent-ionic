<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $dateTransfert;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDexpiration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $partEtat;

    /**
     * @ORM\Column(type="integer")
     */
    private $partEntreprise;

    /**
     * @ORM\Column(type="integer")
     */
    private $partAgence;

    /**
     * @ORM\Column(type="integer")
     */
    private $partAgenceDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transaction")
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateTransfert(): ?\DateTimeInterface
    {
        return $this->dateTransfert;
    }

    public function setDateTransfert(\DateTimeInterface $dateTransfert): self
    {
        $this->dateTransfert = $dateTransfert;

        return $this;
    }

    public function getDateDexpiration(): ?\DateTimeInterface
    {
        return $this->dateDexpiration;
    }

    public function setDateDexpiration(\DateTimeInterface $dateDexpiration): self
    {
        $this->dateDexpiration = $dateDexpiration;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPartEtat(): ?int
    {
        return $this->partEtat;
    }

    public function setPartEtat(int $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getPartEntreprise(): ?int
    {
        return $this->partEntreprise;
    }

    public function setPartEntreprise(int $partEntreprise): self
    {
        $this->partEntreprise = $partEntreprise;

        return $this;
    }

    public function getPartAgence(): ?int
    {
        return $this->partAgence;
    }

    public function setPartAgence(int $partAgence): self
    {
        $this->partAgence = $partAgence;

        return $this;
    }

    public function getPartAgenceDepot(): ?int
    {
        return $this->partAgenceDepot;
    }

    public function setPartAgenceDepot(int $partAgenceDepot): self
    {
        $this->partAgenceDepot = $partAgenceDepot;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
