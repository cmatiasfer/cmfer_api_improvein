<?php 

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="TVShow");
 * @ORM\Entity(repositoryClass="App\Repository\TVShowRepository");
 */
class TVShow
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Directors", inversedBy="tvshow")
     */
    private $director;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Seasons", mappedBy="tvshow")
     */
    private $seasons;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActorsTVShow", mappedBy="tvshow")
     */
    private $actorTVShow;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
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
     * @return Collection|Seasons[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Seasons $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons[] = $season;
            $season->setTvshow($this);
        }

        return $this;
    }

    public function removeSeason(Seasons $season): self
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getTvshow() === $this) {
                $season->setTvshow(null);
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
            $actorTVShow->setTvshow($this);
        }

        return $this;
    }

    public function removeActorTVShow(ActorsTVShow $actorTVShow): self
    {
        if ($this->actorTVShow->removeElement($actorTVShow)) {
            // set the owning side to null (unless already changed)
            if ($actorTVShow->getTvshow() === $this) {
                $actorTVShow->setTvshow(null);
            }
        }

        return $this;
    }


}