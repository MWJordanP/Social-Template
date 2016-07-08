<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              unique = true,
 *              nullable= false
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              unique = true,
 *              nullable= false
 *          )
 *      )
 *
 * })
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Social", mappedBy="userSocial")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $socials;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->socials = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSocials()
    {
        return $this->socials;
    }

    /**
     * @param mixed $socials
     *
     * @return User
     */
    public function setSocials($socials)
    {
        $this->socials = $socials;

        return $this;
    }

    /**
     * @param $socials
     * @return boolean
     */
    public function hasSocials($socials)
    {
        return $this->getSocials()->contains($socials);
    }
    /**
     * @param $social
     * @return $this
     */
    public function addSocials($social)
    {
        if (!$this->getSocials()->contains($social)) {
            $this->getSocials()->add($social);
        }
        return $this;
    }
}