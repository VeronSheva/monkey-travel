<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshTokenRepository;
use Gesdinet\JWTRefreshTokenBundle\Model\AbstractRefreshToken;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
/**
 * @ORM\Entity
 *
 * @ORM\Table("refresh_tokens")
 */
class RefreshToken extends AbstractRefreshToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string')]
    protected $refreshToken;

    #[ORM\Column(type: 'string')]
    protected $username;

    #[ORM\Column(type: 'datetime')]
    protected $valid;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: User::class)]
    private UserInterface $user;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeInterface $createdAt;

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return RefreshToken
     */
    public function setId(mixed $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param mixed $refreshToken
     *
     * @return RefreshToken
     */
    public function setRefreshToken($refreshToken = null)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return RefreshToken
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getValid(): mixed
    {
        return $this->valid;
    }

    /**
     * @param mixed $valid
     *
     * @return RefreshToken
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public static function createForUserWithTtl(string $refreshToken, UserInterface $user, int $ttl): RefreshTokenInterface
    {
        /** @var RefreshToken $entity */
        $entity = parent::createForUserWithTtl($refreshToken, $user, $ttl);
        $entity->setUser($user);

        return $entity;
    }
}
