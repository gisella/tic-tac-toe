<?php

namespace App\Application\Controller;

use App\Domain\Services\GameService;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', methods: ['POST'])]
    public function newGame(Request $request, GameService $gameService): JsonResponse
    {
        try {
            $game = $gameService->newGame();
            return $this->json([
                'message' => 'New game for you!',
                'gameid' => $game->getGameId(),
                'gamestatus'=>$game->getStatus(),
                'status' => 1
            ]);
        } catch (MongoDBException $e) {

            return $this->json([
                'error' => 'Error creating a new game',
                'details' => $e->getMessage(),
                'status' => 0
            ]);
        }
    }

    #[Route('/game/{gameid}', methods: ['GET'])]
    public function getGame($gameid, GameService $gameService): JsonResponse
    {
        $game = $gameService->getGame($gameid);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'gameid' => $game->getGameId(),
            'gamestatus'=>$game->getStatus(),
            'status' => 1
        ]);
    }


//, requirements: ['gameid' => '[0-9a-f]{8}-[0-9a-f]{4}-[1-6][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}']
    #[Route('/game/{gameid}', methods: ['POST'])]
    public function move(string $gameid, Request $request, GameService $gameService): JsonResponse
    {
        $user = $request->request->get('user');
        $row = $request->request->get('row');
        $col = $request->request->get('col');
        try {
            $game = $gameService->move($gameid, $user, $row, $col);
            $winner = $game->getWinner();

            $board = Translator::translateStepsToBoard($game);

            return $this->json([
                'winner' => $winner,
                'hasWinner' => isset($winner),
                'status' => $game->getStatus(),
                'gameid' => $game->getGameId(),
                'board' => $board,
            ]);
        } catch (Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
                'details' => $e->getMessage(),
                'status' => 0
            ]);
        }
    }

}
