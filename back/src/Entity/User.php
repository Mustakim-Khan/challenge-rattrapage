<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\RegisterController;
use App\Controller\ResetPasswordController;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Asserts;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`user`")]
#[ApiResource(
    paginationEnabled: true,
)]
#[ApiFilter(SearchFilter::class, properties: [
    'username' => 'exact',
    'email' => 'exact',
])]
#[Get(
    normalizationContext: ['groups' => ['get_user']],
    security: "is_granted('ROLE_MODERATOR') or object == user"
)]
#[GetCollection(
    normalizationContext: ['groups' => ['getc_user']],
    security: "is_granted('ROLE_MODERATOR')",
)]
#[Post(
    name: 'user_register',
    uriTemplate: '/register',
    controller: RegisterController::class,
    denormalizationContext: ['groups' => ['write_user']],
    processor: UserPasswordHasher::class,
)]
#[Put(
    denormalizationContext: ['groups' => ['update_user']],
    security: "is_granted('ROLE_ADMIN') or object == user",
    securityMessage: 'Sorry, but you have a right for this action.'
)]
#[Patch(
    denormalizationContext: ['groups' => ['update_user']],
    security: "is_granted('ROLE_ADMIN') or object == user",
    securityMessage: 'Sorry, but you have a right for this action.'
)]
#[Patch(
    name: 'reset_password',
    uriTemplate: 'users/{id}/reset/password',
    controller: ResetPasswordController::class,
    denormalizationContext: ['groups' => ['updatePwd_user']],
    processor: UserPasswordHasher::class,
    security: "is_granted('ROLE_ADMIN') or object == user",
    securityMessage: 'Sorry, but you don\'t have a right for this action.'
)]
#[UniqueEntity('username', message: 'Ce nom d\'utilisateur {{ value }} existe déjà.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['getc_user','read_Forum', 'read_Comment', 'read_Media', 'read_Clip', 'read_Tournament', 'read_Comments', 'getc_article', 'getc_Tournament'])]
    private ?Uuid $id = null;
    
    #[ORM\Column(length: 180, unique: true)]
    #[Asserts\NotBlank()]
    #[Groups(['get_user', 'write_user', 'getc_user','update_user','read_Forum','read_Forums', 'read_Comment', 'read_Media', 'read_Clip', 'read_Tournament', 'get_article', 'getc_article', 'read_Comments', 'getc_Tournament'])]
    private ?string $username = null;
    
    #[ORM\Column]
    private array $roles = [];
    
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['write_user', 'update_user', 'updatePwd_user'])]
    private ?string $password = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['getc_user'])]
    private ?string $token = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user', 'getc_user', 'write_user', 'update_user'])]
    private ?string $email = null;
    

    #[ORM\Column(nullable: true)]
    private ?bool $isVerify = null;

    public function __construct()
    {
        $this->isVerify = false;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

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

    public function isIsVerify(): ?bool
    {
        return $this->isVerify;
    }

    public function setIsVerify(?bool $isVerify): self
    {
        $this->isVerify = $isVerify;

        return $this;
    }
}
