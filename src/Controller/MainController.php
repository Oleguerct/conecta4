<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class MainController extends AbstractController
{

    #[Route('/', name: 'app_main')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $username = '';
        $session = $request->getSession();
        if($session->get('user_id')){
            $user = $userRepository->find($session->get('user_id'));
            $username = $user->getUsername();
        }

        $userObject = isset($user) ? ['username' => $user->getUsername(), 'userId' => $user->getId()] : '';

        return $this->render('main/main.html.twig',[
            'userObj' => $userObject
        ]);
    }

    #[Route('/publish', name: 'app_publish')]
    public function publish(HubInterface $hub): Response
    {
        $update = new Update(
            'https://example.com/books/1',
            json_encode(['status' => 'published'])
        );

        $hub->publish($update);

        return new Response('published!');
    }

    #[Route('/js', name: 'app_js')]
    public function js(HubInterface $hub): Response
    {


        return $this->render('main/js.html.twig');
    }

    #[Route('/test', name: 'app_test')]
    public function test(HubInterface $hub, EntityManagerInterface $entityManager): Response
    {

        $user1 = new User();
        $user1->setUsername('Joan');

        $user2 = new User();
        $user2->setUsername('Pep');

        $game = new Game();
        $game->setTitle('Game X');

        $user1->setGameAsPlayer1($game);
        $user2->setGameAsPlayer2($game);

        $game->setPlayer1($user2);
        $game->setPlayer2($user1);

        $entityManager->persist($user1);
        $entityManager->persist($user2);
        $entityManager->persist($game);
        $entityManager->flush();


        //dd($user1);

        echo 'Game.player1 is '.$game->getPlayer1()->getUsername();
        echo '<br>';
        echo 'Game.player2 is '.$game->getPlayer2()->getUsername();
        echo '<br>';
        echo '<br>';
        echo 'Player1.game is '.$user1->getGameAsPlayer1()->getTitle();
        echo '<br>';
        echo 'Player2.game is '.$user2->getGameAsPlayer2()->getTitle();


        return $this->render('base.html.twig');
    }

}
