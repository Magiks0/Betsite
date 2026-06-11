<?php

namespace App\Controller;

use App\Form\BalanceType;
use App\Repository\BetRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    #[Route('/mon-compte', name: 'app_account')]
    public function __invoke(BetRepository $betRepository, UserService $userService, Request $request): Response
    {
        $user = $this->getUser();

        $bets = $betRepository->findByUser($user);

        $form = $this->createForm(BalanceType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->updateBalance($user, $form->getData()->getBalance());

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/index.html.twig', [
            'bets' => $bets,
            'form' => $form->createView(),
        ]);
    }
}
