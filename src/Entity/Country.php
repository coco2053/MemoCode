<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_uppercase", type="string")
     */
    private $nameUppercase;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string")
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha2",length=2, type="string")
     */
    private $alpha2;

    /**
     * @var string
     *
     * @ORM\Column(name="alpha3",length=3, type="string")
     */
    private $alpha3;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Departement
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNameUppercase()
    {
        return $this->nameUppercase;
    }

    /**
     * @param string $nameUppercase
     */
    public function setNameUppercase($nameUppercase)
    {
        $this->nameUppercase = $nameUppercase;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getAlpha2()
    {
        return $this->alpha2;
    }

    /**
     * @param string $alpha2
     */
    public function setAlpha2($alpha2)
    {
        $this->alpha2 = $alpha2;
    }

    /**
     * @return string
     */
    public function getAlpha3()
    {
        return $this->alpha3;
    }

    /**
     * @param string $alpha3
     */
    public function setAlpha3($alpha3)
    {
        $this->alpha3 = $alpha3;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
