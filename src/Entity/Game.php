<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource()]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $board = [];

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'currentGame', targetEntity: User::class)]
    private Collection $players;

    #[ORM\Column(nullable: true)]
    private ?int $player1ID = null;

    #[ORM\Column(nullable: true)]
    private ?int $player2ID = null;

    #[ORM\Column(nullable: true)]
    private ?int $turn = null;

    #[ORM\Column(nullable: true)]
    private ?int $winner = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $firstMoveTime = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastMoveTime = null;

    function __construct()
    {
        $this->board = [
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
            [0,0,0,0,0,0],
        ];
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoard(): array
    {
        return $this->board;
    }

    public function setBoard(array $board): static
    {
        $this->board = $board;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(User $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setCurrentGame($this);
        }

        return $this;
    }

    public function removePlayer(User $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getCurrentGame() === $this) {
                $player->setCurrentGame(null);
            }
        }

        return $this;
    }

    public function getPlayer1ID(): ?int
    {
        return $this->player1ID;
    }

    public function setPlayer1ID(?int $player1ID): static
    {
        $this->player1ID = $player1ID;

        return $this;
    }

    public function getPlayer2ID(): ?int
    {
        return $this->player2ID;
    }

    public function setPlayer2ID(?int $player2ID): static
    {
        $this->player2ID = $player2ID;

        return $this;
    }

    public function getTurn(): ?int
    {
        return $this->turn;
    }

    public function setTurn(?int $turn): static
    {
        $this->turn = $turn;

        return $this;
    }

    public function passTurn(): void
    {
        $this->turn = $this->turn == 1 ? 2 : 1;
    }

    public function getWinner(): ?int
    {
        return $this->winner;
    }

    public function setWinner(?int $winner): static
    {
        $this->winner = $winner;

        return $this;
    }

    public function getFirstMoveTime(): ?\DateTimeImmutable
    {
        return $this->firstMoveTime;
    }

    public function setFirstMoveTime(?\DateTimeImmutable $firstMoveTime): static
    {
        $this->firstMoveTime = $firstMoveTime;

        return $this;
    }

    public function getLastMoveTime(): ?\DateTimeImmutable
    {
        return $this->lastMoveTime;
    }

    public function setLastMoveTime(?\DateTimeImmutable $lastMoveTime): static
    {
        $this->lastMoveTime = $lastMoveTime;

        return $this;
    }




}
