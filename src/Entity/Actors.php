<?php 

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="actors");
 * @ORM\Entity(repositoryClass="App\Repository\ActorsRepository");
 */
class Actors
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
     * @ORM\OneToMany(targetEntity="App\Entity\ActorsMovies", mappedBy="actor")
     */
    private $actorMovie;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActorsTVShow", mappedBy="actor")
     */
    private $actorTVShow;

    public function __construct()
    {
        $this->actorMovie = new ArrayCollection();
        $this->actorTVShow = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|ActorsMovies[]
     */
    public function getActorMovie(): Collection
    {
        return $this->actorMovie;
    }

    public function addActorMovie(ActorsMovies $actorMovie): self
    {
        if (!$this->actorMovie->contains($actorMovie)) {
            $this->actorMovie[] = $actorMovie;
            $actorMovie->setActor($this);
        }

        return $this;
    }

    public function removeActorMovie(ActorsMovies $actorMovie): self
    {
        if ($this->actorMovie->removeElement($actorMovie)) {
            // set the owning side to null (unless already changed)
            if ($actorMovie->getActor() === $this) {
                $actorMovie->setActor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ActorsTVShow[]
     */
    public function getActorTVShow(): Collection
    {
        return $this->actorTVShow;
    }

    public function addActorTVShow(ActorsTVShow $actorTVShow): self
    {
        if (!$this->actorTVShow->contains($actorTVShow)) {
            $this->actorTVShow[] = $actorTVShow;
            $actorTVShow->setActor($this);
        }

        return $this;
    }

    public function removeActorTVShow(ActorsTVShow $actorTVShow): self
    {
        if ($this->actorTVShow->removeElement($actorTVShow)) {
            // set the owning side to null (unless already changed)
            if ($actorTVShow->getActor() === $this) {
                $actorTVShow->setActor(null);
            }
        }

        return $this;
    }

}