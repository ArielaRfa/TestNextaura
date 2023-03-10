<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\User\AuthenticateAction;
use App\Controller\User\GetUserIdByIdentifier;
use App\Controller\User\RefreshUserTokenAction;
use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    collectionOperations: [
        'identifier' => [
            'path' => '/identifier',
            'method' => 'POST',
            'controller' => GetUserIdByIdentifier::class,
            'normalization_context' => ['groups' => ['user:read']]
        ],
        'login' => [
            'path' => '/login',
            'method' => 'POST',
            'controller' => AuthenticateAction::class,
            'normalization_context' => ['groups' => ['user:read']]
        ],
        'refreshUserToken' => [
            'path' => '/refresh',
            'method' => 'POST',
            'controller' => RefreshUserTokenAction::class,
            'normalization_context' => ['groups' => ['user:read']]
        ]
    ],
    itemOperations: [
        'GET' => [
            'path' => '/{id}',
            'requirements' => ['id' => '\d+'],
            'normalization_context' => [
                'groups' => ['user:read']
            ],
        ]
    ],
    routePrefix: '/user'
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true, nullable: false)]
    #[Groups(['user:read'])]
    #[Assert\Email]
    public ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(nullable: false)]
    #[Groups(['user:write'])]
    private string $password = "password";

    #[ORM\Column(length: 100)]
    #[Groups(['user:read'])]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Groups(['user:read'])]
    #[Assert\NotBlank]
    private ?string $surname = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    #[Groups(['user:read'])]
    private DateTimeInterface $creationDate;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['user:read'])]
    private DateTimeInterface $updatedAt;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read_full'])]
    private ?string $apiRefreshToken = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['user:read_full'])]
    private ?DateTimeInterface $apiRefreshTokenExpiration = null;

    public function __construct()
    {
        $this->creationDate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        if (count($roles) === 0) {
            // guarantee every user at least has ROLE_USER
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
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
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCreationDate(): DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getApiRefreshToken(): string
    {
        return $this->apiRefreshToken;
    }

    /**
     * @param string|null $apiRefreshToken
     */
    public function setApiRefreshToken(?string $apiRefreshToken): void
    {
        $this->apiRefreshToken = $apiRefreshToken;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getApiRefreshTokenExpiration(): ?DateTimeInterface
    {
        return $this->apiRefreshTokenExpiration;
    }

    /**
     * @param DateTimeInterface|null $apiRefreshTokenExpiration
     */
    public function setApiRefreshTokenExpiration(?DateTimeInterface $apiRefreshTokenExpiration): void
    {
        $this->apiRefreshTokenExpiration = $apiRefreshTokenExpiration;
    }
}
