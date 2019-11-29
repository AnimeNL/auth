<?php

namespace App\Entity\Anplan;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Trikoder\Bundle\OAuth2Bundle\Model\Scope as AuthScope;

/**
 * @ORM\Table(name="jpop__visitors")
 * @ORM\Entity(repositoryClass="App\Repository\Anplan\UserRepository")
 */
class User implements UserInterface, EncoderAwareInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="vis_id_visitor")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="vis_email")
     */
    private string $email;

    /**
     * @ORM\Column(type="string", name="vis_password")
     */
    private string $password;

    /**
     * @var ArrayCollection|Scope[]
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Anplan\Scope",
     *     mappedBy="user",
     *     fetch="EAGER"
     * )
     */
    private $scopes;

    public function __construct()
    {
        $this->scopes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        $scopes = [];
        foreach ($this->scopes->toArray() as $scope) {
            if (!$scope->isActive()) {
                continue;
            }

            $scopes[] = new AuthScope($scope->getScope());
        }

        return $scopes;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
        $this->password = null;
    }

    /**
     * Gets the name of the encoder used to encode the password.
     *
     * If the method returns null, the standard way to retrieve the encoder
     * will be used instead.
     */
    public function getEncoderName(): ?string
    {
        if (strpos($this->password, '$') !== false) {
            return 'new';
        }

        return 'legacy';
    }
}
