<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionLdapRepository")
 */
class InscriptionLdap
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Saisir ici un nom.")
     * @Assert\Length(
     *     max="64",
     *     maxMessage="Le nom saisi ne doit dépasser {{ limit }} caractères  "
     * )*/
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Saisir ici le hostname de votre LDAP.")
     * @Assert\Length(
     *     max="64",
     *     maxMessage="Le hostname saisi ne doit dépasser {{ limit }} caractères  "
     * )
     */
    private $hostname;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Saisir ici le numero de port.")
     */
    private $port;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Saisir ici l'adresse baseDN.")
     * @Assert\Length(
     *     max="64",
     *     maxMessage="L'adressse baseDN saisi ne doit dépasser {{ limit }} caractères  "
     * )
     */
    private $basedn;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Saisir ici l'adresse binDN.")
     * @Assert\Length(
     *     max="64",
     *     maxMessage="L'adresse binDN saisi ne doit dépasser {{ limit }} caractères  "
     * )
     */
    private $binddn;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Saisir ici le mot de passe du LDAP.")
     * @Assert\Length(
     *     max="64",
     *     maxMessage="Le mot de passe du LDAP ne doit dépasser {{ limit }} caractères  "
     * )
     */
    private $password;


/****************************************************************
*                      Getters et Setter                        *
****************************************************************/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
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

    /**
     * @return mixed
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param mixed $hostname
     */
    public function setHostname($hostname): void
    {
        $this->hostname = $hostname;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port): void
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getBasedn()
    {
        return $this->basedn;
    }

    /**
     * @param mixed $basedn
     */
    public function setBasedn($basedn): void
    {
        $this->basedn = $basedn;
    }

    /**
     * @return mixed
     */
    public function getBinddn()
    {
        return $this->binddn;
    }

    /**
     * @param mixed $binddn
     */
    public function setBinddn($binddn): void
    {
        $this->binddn = $binddn;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

}