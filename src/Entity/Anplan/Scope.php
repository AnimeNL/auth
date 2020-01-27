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
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="vir_right")
     */
    private $scope;

    /**
     * @var bool
     * @ORM\Column(type="smallint", name="vir_active")
     */
    private $active;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\Anplan\User", inversedBy="scopes")
     * @ORM\JoinColumn(name="vir_id_visitor", referencedColumnName="vis_id_visitor", nullable=false)
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
