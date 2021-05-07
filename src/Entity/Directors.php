<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="directors");
 * @ORM\Entity(repositoryClass="App\Repository\DirectorsRepository");
 */
class Directors
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movies", mappedBy="director")
     */
    private $movies;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TVShow", mappedBy="director")
     */
    private $tvshow;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->tvshow = new ArrayCollection();
    }

    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Movies[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movies $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->setDirector($this);
        }

        return $this;
    }

    public function removeMovie(Movies $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getDirector() === $this) {
                $movie->setDirector(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TVShow[]
     */
    public function getTvshow(): Collection
    {
        return $this->tvshow;
    }

    public function addTvshow(TVShow $tvshow): self
    {
        if (!$this->tvshow->contains($tvshow)) {
            $this->tvshow[] = $tvshow;
            $tvshow->setDirector($this);
        }

        return $this;
    }

    public function removeTvshow(TVShow $tvshow): self
    {
        if ($this->tvshow->removeElement($tvshow)) {
            // set the owning side to null (unless already changed)
            if ($tvshow->getDirector() === $this) {
                $tvshow->setDirector(null);
            }
        }

        return $this;
    }  
}