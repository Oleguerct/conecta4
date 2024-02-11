<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["game:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["game:read"])]
    private ?string $username = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?Game $currentGame = null;

    #[ORM\OneToOne(mappedBy: 'player1', cascade: ['persist', 'remove'])]
    private ?Game $gameAsPlayer1 = null;

    #[ORM\OneToOne(mappedBy: 'player2', cascade: ['persist', 'remove'])]
    private ?Game $gameAsPlayer2 = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }



    public function setCurrentGame(?Game $currentGame): static
    {
        $this->currentGame = $currentGame;

        return $this;
    }

    /**
     * Return the game where the user is player 1 or player 2, or null if the user is not in a game
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->gameAsPlayer1 ?? $this->gameAsPlayer2;
    }


    public function getGameAsPlayer1(): ?Game
    {
        return $this->gameAsPlayer1;
    }

    public function setGameAsPlayer1(?Game $game): static
    {
        // unset the owning side of the relation if necessary
        if ($game === null && $this->gameAsPlayer1 !== null) {
            $this->gameAsPlayer1->setPlayer1(null);
        }

        // set the owning side of the relation if necessary
        if ($game !== null && $game->getPlayer1() !== $this) {
            $game->setPlayer1($this);
        }

        $this->gameAsPlayer1 = $game;

        return $this;
    }

    public function getGameAsPlayer2(): ?Game
    {
        return $this->gameAsPlayer2;
    }

    public function setGameAsPlayer2(?Game $gameAsPlayer2): static
    {
        // unset the owning side of the relation if necessary
        if ($gameAsPlayer2 === null && $this->gameAsPlayer2 !== null) {
            $this->gameAsPlayer2->setPlayer2(null);
        }

        // set the owning side of the relation if necessary
        if ($gameAsPlayer2 !== null && $gameAsPlayer2->getPlayer2() !== $this) {
            $gameAsPlayer2->setPlayer2($this);
        }

        $this->gameAsPlayer2 = $gameAsPlayer2;

        return $this;
    }

}
