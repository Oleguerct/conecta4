<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameUserRelationTest extends KernelTestCase
{

    public function testCreateUser(): void
    {
        $kernel = self::bootKernel();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        assert($entityManager instanceof EntityManager);

        $user1 = new User();
        $user1->setUsername('Joan');

        $entityManager->persist($user1);
        $entityManager->flush();

    }

    public function testRelation(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        assert($entityManager instanceof EntityManager);

        $game = new Game();
        $user1 = new User();
        $user2 = new User();

        $game->setPlayer1($user1);
        $game->setPlayer2($user2);

        $entityManager->persist($game);
        $entityManager->flush();



    }
}
