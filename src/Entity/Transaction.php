<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ApiResource(
 *     routePrefix="transaction",
 *     attributes={},
 *     collectionOperations={
 *          "get_commision_utilisateurAgence"={
 *              "method"="GET",
 *              "path"="/commisons_user",
 *              "security"= "is_granted('ROLE_UtilisateurAgence')",
 *              "security_message"="Acces non autorisé",
 *     },
 *          "get_transaction_commision_agencePartenaire"={
 *              "method"="GET",
 *               "path"="/mes_commision",
 *          "security"= "is_granted('ROLE_AdminAgence')",
 *          "security_message"="Acces non autorisé",
 *     },
 *
 *           "Recharge_compte"={
 *              "method"="POST",
 *              "path"="/compte",
 *              "security_message"="Acces non autorisé",
 *              "security"= "is_granted('ROLE_AdminSysteme') or is_granted('ROLE_Caissier')",
 *              "normalization_context"={"groups"={"trans_compte:read"}},
 *              "denormalization_context"={"groups"={"trans_compte:write"}},
 *     },
 *          "Transfert_client"={
 *              "method"="POST",
 *              "path"="/client",
 *              "security_message"="Acces non autorisé",
 *              "security"= "is_granted('ROLE_AdminAgence') or is_granted('ROLE_UtilisateurAgence')",
 *               "normalization_context"={"groups"={"trans_client:read"}},
 *              "denormalization_context"={"groups"={"trans_client:write"}},
 *     }
 *     },
 *     itemOperations={
 *          "GET"={"defaults"={"id"=null},},
 *          "get_trans_by_code"={
 *                 "method"="PUT",
 *               "path"="/code",
 *          "security"= "is_granted('ROLE_AdminAgence') or is_granted('ROLE_UtilisateurAgence')",
 *          "security_message"="Acces non autorisé",
 *     },
 *          "DELETE"
 *     },
 *     )
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"trans_compte:read", "trans_compte:write"})
     * @Groups({"trans_client:read", "trans_client:write"})
     * @Groups({"getTrans"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     * @Groups({"getTrans"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"trans_compte:read", "trans_compte:write"})
     * @Groups({"trans_client:read", "trans_client:write"})
     * @Groups({"getTrans"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"trans_compte:read", "trans_compte:write"})
     * @Groups({"trans_client:read", "trans_client:write"})
     * @Groups({"getTrans"})
     */
    private $dateTransfert;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"trans_compte:read", "trans_compte:write"})
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     * @Groups({"getTrans"})
     */
    private $partEtat;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     * @Groups({"getTrans"})
     */
    private $partEntreprise;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $partAgenceRetrait;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Groups({"trans_client:read", "trans_client:write"})
     * @Groups({"getTrans"})
     */
    private $partAgenceDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transaction",cascade={"persist", "remove"})
     * @Groups({"getTrans"})
     * @Groups({"trans_client:read", "trans_client:write"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="transaction",cascade={"persist", "remove"})
     * @Groups({"trans_compte:read", "trans_compte:write"})
     */
    private $compte;

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
      //  return \DateTime::createFromFormat('Y-m-d',$this->dateTransfert);
    }

    public function setDateTransfert(\DateTimeInterface $dateTransfert): self
    {
        $this->dateTransfert = $dateTransfert;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
        //return \DateTime::createFromFormat('Y-m-d',$this->dateRetrait);
    }

    public function setDateDexpiration(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

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

    public function getPartAgenceRetrait(): ?int
    {
        return $this->partAgenceRetrait;
    }

    public function setPartAgence(int $partAgenceRetrait): self
    {
        $this->partAgenceRetrait = $partAgenceRetrait;

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

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
