<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource(
/*    normalizationContext: ['groups' => ['game:read']],
    denormalizationContext: ['groups' => ['game:write']],*/
)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["game:read"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["game:read"])]
    private array $board = [];

    #[ORM\Column(length: 255)]
    #[Groups(["game:read"])]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["game:read"])]
    private ?int $turn = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["game:read"])]
    private ?int $winner = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $firstMoveTime = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastMoveTime = null;

    #[ORM\OneToOne(inversedBy: 'gameAsPlayer1', cascade: ['persist', 'remove'])]
    #[Groups(["game:read"])]
    private ?User $player1 = null;

    #[ORM\OneToOne(inversedBy: 'gameAsPlayer2', cascade: ['persist', 'remove'])]
    #[Groups(["game:read"])]
    private ?User $player2 = null;

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
        $this->turn = null;
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

    public function getPlayer1(): ?User
    {
        return $this->player1;
    }



    public function setPlayer1(?User $player1): static
    {
        $this->player1 = $player1;

        return $this;
    }



    public function getPlayer2(): ?User
    {
        return $this->player2;
    }

    public function setPlayer2(?User $player2): static
    {
        $this->player2 = $player2;

        return $this;
    }


    // A function to return the player whose turn it is
    public function getCurrentPlayer(): ?User
    {
        if($this->getTurn() === null) return null;
        return $this->turn === 1 ? $this->player1 : $this->player2;
    }

    #[Groups(["game:read"])]
    public function getCurrentPlayerID(): ?int
    {
        $player = $this->getCurrentPlayer();
        if($player){
            return $player->getId();
        }
        return null;
    }

    // A function to return all the players in the game
    public function getPlayers(): Collection
    {
        return new ArrayCollection([$this->player1, $this->player2]);
    } 

    // A function to add a player to the game, if there is a free spot. Throws an exception if there are no free spots
    public function addPlayer(User $player): void
    {
        if ($this->player1 === null) {
            $this->setPlayer1($player);
        } elseif ($this->player2 === null) {
            $this->setPlayer2($player);
            $this->turn = 1;
        } else {
            throw new \Exception('Game is full',400);
        }
    }

    // Remove a player from the game
    public function removePlayer(User $player): void
    {
        if ($this->player1 === $player) {
            $this->setPlayer1(null);
        } elseif ($this->player2 === $player) {
            $this->setPlayer2(null);
        }
    }




}
