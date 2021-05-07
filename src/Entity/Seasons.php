<?php 

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="seasons");
 * @ORM\Entity(repositoryClass="App\Repository\SeasonsRepository");
 */
class Seasons
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
     * @ORM\ManyToOne(targetEntity="App\Entity\TVShow", inversedBy="seasons")
     */
    private $tvshow;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episodes", mappedBy="season")
     */
    private $episodes;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
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

    public function getTvshow(): ?TVShow
    {
        return $this->tvshow;
    }

    public function setTvshow(?TVShow $tvshow): self
    {
        $this->tvshow = $tvshow;

        return $this;
    }

    /**
     * @return Collection|Episodes[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episodes $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setSeason($this);
        }

        return $this;
    }

    public function removeEpisode(Episodes $episode): self
    {
        if ($this->episodes->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getSeason() === $this) {
                $episode->setSeason(null);
            }
        }

        return $this;
    }

}