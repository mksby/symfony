<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Search
{

    /**
     * @Assert\NotBlank
     */
    private $brands;

    /**
     * @Assert\NotBlank
     */
    private $models;

    /**
     * @Assert\NotBlank
     */
    private $engines;

    public function getBrands()
    {
        return $this->brands;
    }

    public function setBrands($brands)
    {
        $this->brands = $brands;
    }

    public function getEngines()
    {
        return $this->engines;
    }

    public function setEngines($engines)
    {
        $this->engines = $engines;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModels($models)
    {
        $this->models = $models;
    }
}