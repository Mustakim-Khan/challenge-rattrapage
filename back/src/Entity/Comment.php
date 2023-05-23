<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ApiResource(
    order: ['createdAt' => 'DESC'],
)]
#[Get(normalizationContext: ['groups' => ['read_Comment']])]
#[GetCollection(normalizationContext: ['groups' => ['read_Comments']])]
#[GetCollection(
    uriVariables: [
        'userId' => new Link(
            fromClass: User::class,
            fromProperty: 'comments'
        )
    ],
    uriTemplate: '/users/{userId}/comments.{_format}',
    normalizationContext: ['groups' => ['user:comments'],],
    security: "is_granted('ROLE_MODERATOR') or object == user",
    securityMessage: 'Sorry, but you are not the owner.'
)]
#[Post(
    normalizationContext: ['groups' => ['read_Comment']],
    denormalizationContext: ['groups' => ['write_Comment']]
)]
#[Put(
    denormalizationContext: ['groups' => ['update_Comment']],
    security: "is_granted('ROLE_MODERATOR') or object == user",
    securityMessage: 'Sorry, but you are not the admin.'
)]
#[Patch(
    denormalizationContext: ['groups' => ['update_Comment']],
    security: "is_granted('ROLE_MODERATOR') or object == user",
    securityMessage: 'Sorry, but you are not the admin.'
)]
#[Delete(
    security: "is_granted('ROLE_MODERATOR') or object == user",
    securityMessage: 'Sorry, but you are not the admin.'
)]
#[ApiFilter(SearchFilter::class, properties: [
    'forum' => 'exact',
])]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['read_Comment', 'read_Comments', 'read_Forum'])]
    private ?Uuid $id = null;

    #[ORM\Column]
    #[Groups(['read_Comment', 'read_Comments', 'user:comments'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_Comment', 'read_Comments', 'read_Forum', 'user:comments'])]
    #[Gedmo\Blameable(on: 'create')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_Comment', 'write_Comment', 'update_Comment', 'read_Comments', 'user:comments'])]
    private ?Forum $forum = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_Comment', 'write_Comment', 'update_Comment', 'read_Comments', 'user:comments', 'read_Forum'])]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: SignaledComment::class)]
    #[Groups(['read_Comment', 'read_Comments', 'user:comments'])]
    private Collection $signaledComments;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable("now", new \DateTimeZone("Europe/Paris"));
        $this->signaledComments = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, SignaledComment>
     */
    public function getSignaledComments(): Collection
    {
        return $this->signaledComments;
    }

    public function addSignaledComment(SignaledComment $signaledComment): self
    {
        if (!$this->signaledComments->contains($signaledComment)) {
            $this->signaledComments->add($signaledComment);
            $signaledComment->setComment($this);
        }

        return $this;
    }

    public function removeSignaledComment(SignaledComment $signaledComment): self
    {
        if ($this->signaledComments->removeElement($signaledComment)) {
            // set the owning side to null (unless already changed)
            if ($signaledComment->getComment() === $this) {
                $signaledComment->setComment(null);
            }
        }

        return $this;
    }
}
