<?php 

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="actorstvshow");
 * @ORM\Entity(repositoryClass="App\Repository\ActorsTVShowRepository");
 */
class ActorsTVShow
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Actors", inversedBy="actorTVShow")
     */
    private $actor;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TVShow", inversedBy="actorTVShow")
     */
    private $tvshow;

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

    public function getTvshow(): ?TVShow
    {
        return $this->tvshow;
    }

    public function setTvshow(?TVShow $tvshow): self
    {
        $this->tvshow = $tvshow;

        return $this;
    }

}