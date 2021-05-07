<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="movies");
 * @ORM\Entity(repositoryClass="App\Repository\MoviesRepository");
 */
class Movies
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
     * @ORM\Column(type="string", length=255)
     */
    protected $genre;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $popularity;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $voteAverage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Directors", inversedBy="movies")
     */
    private $director;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActorsMovies", mappedBy="movie")
     */
    private $actorsMovies;

    public function __construct()
    {
        $this->actorsMovies = new ArrayCollection();
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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function setPopularity(?int $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getVoteAverage(): ?int
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(?int $voteAverage): self
    {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    public function getDirector(): ?Directors
    {
        return $this->director;
    }

    public function setDirector(?Directors $director): self
    {
        $this->director = $director;

        return $this;
    }

    /**
     * @return Collection|ActorsMovies[]
     */
    public function getActorsMovies(): Collection
    {
        return $this->actorsMovies;
    }

    public function addActorsMovie(ActorsMovies $actorsMovie): self
    {
        if (!$this->actorsMovies->contains($actorsMovie)) {
            $this->actorsMovies[] = $actorsMovie;
            $actorsMovie->setMovie($this);
        }

        return $this;
    }

    public function removeActorsMovie(ActorsMovies $actorsMovie): self
    {
        if ($this->actorsMovies->removeElement($actorsMovie)) {
            // set the owning side to null (unless already changed)
            if ($actorsMovie->getMovie() === $this) {
                $actorsMovie->setMovie(null);
            }
        }

        return $this;
    }

    
   
}