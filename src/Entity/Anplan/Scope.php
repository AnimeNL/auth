<?php

namespace App\Entity\Anplan;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="jpop__visitor_rights")
 * @ORM\Entity()
 */
class Scope
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="vir_right")
     */
    private string $scope;

    /**
     * @ORM\Column(type="smallint", name="vir_active")
     */
    private bool $active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Anplan\User", inversedBy="scopes")
     * @ORM\JoinColumn(name="vir_id_visitor", referencedColumnName="vis_id_visitor", nullable=false)
     */
    private User $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function __toString(): string
    {
        return $this->scope;
    }
}
