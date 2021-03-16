<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 *     attributes={
 *           "pagination_enabled"=true,
 *          "pagination_items_per_page"=10,
 *     },
 *     collectionOperations={
 *          "get_Caissier"={
 *              "method"="GET",
 *              "path"="/adminSysteme/caissier",
 *               "security_message"="Seul les adminSysteme sont autorise !",
 *              "security"= "is_granted('ROLE_AdminSysteme')",
 *     },
 *     "get_userAgence"={
 *      "method"="GET",
 *     "path"="/adminAgence/userAgence",
 *     "security_message"="Seul les adminAgence sont autorise !",
 *      "security"= "is_granted('ROLE_AdminAgence')",
 *     },
 *     "post_Caissier"={
 *      "method"="POST",
 *     "path"="/adminSysteme/caissier",
 *     "route_name"="caissier_post",
 *     },
 *     "post_userAgence"={
 *      "method"="POST",
 *      "path"="/adminAgence/userAgence",
 *     "route_name"="userAgence_post",

 *     },
 *     },
 *     itemOperations={
 *          "GET",
 *          "put_caissier"={
 *            "method"="PUT",
 *            "path"="/adminSysteme/caissier/{id}",
 *             "route_name"="caissier_put",
 *
 *     },
 *     "put_userAgence"={
 *      "method"="PUT",
 *     "path"="/adminAgence/userAgence/{id}",
 *     "route_name"="userAgence_put",
 *
 *     },
 *
 *          "delete_caissier"={
 *          "method"="DELETE",
 *          "path"="/adminSysteme/caissier/{id}",
 *           "security_message"="Seul les adminSysteme sont autorise !",
 *           "security"= "is_granted('ROLE_AdminSysteme')",
 *     },
 *     "delete_userAgence"={
 *          "method"="DELETE",
 *          "path"="/adminAgence/userAgence/{id}",
 *           "security_message"="Seul les adminAgence sont autorise !",
 *           "security"= "is_granted('ROLE_AdminAgence')",
 *
 *     },
 *     },
 *
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     * @Groups("compte:read")
     * @Groups({"profile:read"})
     *  @Groups({"trans_TTmcommission:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write"})
     * @Groups("compte:read")
     * @Groups({"profile:read"})
     *  @Groups({"trans_TTmcommission:read"})
     * @Assert\NotBlank
     */
    private $username;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @Groups("user:write")
     * @SerializedName("password")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups("compte:read")
     * @Groups({"profile:read"})
     *  @Groups({"trans_TTmcommission:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups("compte:read")
     * @Groups({"profile:read"})
     *  @Groups({"trans_TTmcommission:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups("compte:read")
     * @Groups({"profile:read"})
     *  @Groups({"trans_TTmcommission:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Groups("compte:read")
     * @Groups({"profile:read"})
     *  @Groups({"trans_TTmcommission:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user:write"})
     * @Groups("compte:read")
     */
    private $archivage;


    /**
     * @ORM\ManyToOne(targetEntity=AgencePartenaire::class, inversedBy="user")
     */
    private $agencePartenaire;

    /**
     * @ORM\OneToMany(targetEntity=Compte::class, mappedBy="user")
     */
    private $comptes;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="user")
     */
    private $transactions;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=TransactionBloquer::class, mappedBy="user")
     */
    private $transactionBloquers;

    /**
     * @ORM\ManyToMany(targetEntity=Profile::class, inversedBy="users")
     *  @Groups({"user:read", "user:write"})
     * @Groups("compte:read")
     *  @Groups({"trans_TTmcommission:read"})
     */
    private $profiles;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->transactionBloquers = new ArrayCollection();
        $this->profiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        foreach ($this->profiles as $value){
            $roles[] =  'ROLE_'.$value->getLibelle();
        }


        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

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

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setUser($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getUser() === $this) {
                $compte->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUser() === $this) {
                $transaction->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|TransactionBloquer[]
     */
    public function getTransactionBloquers(): Collection
    {
        return $this->transactionBloquers;
    }

    public function addTransactionBloquer(TransactionBloquer $transactionBloquer): self
    {
        if (!$this->transactionBloquers->contains($transactionBloquer)) {
            $this->transactionBloquers[] = $transactionBloquer;
            $transactionBloquer->setUser($this);
        }

        return $this;
    }

    public function removeTransactionBloquer(TransactionBloquer $transactionBloquer): self
    {
        if ($this->transactionBloquers->removeElement($transactionBloquer)) {
            // set the owning side to null (unless already changed)
            if ($transactionBloquer->getUser() === $this) {
                $transactionBloquer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Profile[]
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profile $profile): self
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles[] = $profile;
        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
        $this->profiles->removeElement($profile);

        return $this;
    }
}
