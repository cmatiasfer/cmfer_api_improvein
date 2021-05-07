<?php 

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="actorsmovies");
 * @ORM\Entity(repositoryClass="App\Repository\ActorsMoviesRepository");
 */
class ActorsMovies
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Actors", inversedBy="actorMovie")
     */
    private $actor;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movies", inversedBy="actorMovies")
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActor(): ?Actors
    {
        return $this->actor;
    }

    public function setActor(?Actors $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    public function getMovie(): ?Movies
    {
        return $this->movie;
    }

    public function setMovie(?Movies $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

}