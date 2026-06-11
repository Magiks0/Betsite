<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'admin_')]
#[IsGranted('ADMIN_ACCESS')]
class AdminController extends AbstractController
{
    #[Route('/users', name: 'users_index')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route('/users/{id}/suspend', name: 'users_suspend')]
    public function suspend(User $user, EntityManagerInterface $em): Response
    {
        $user->setSuspended(true);
        $em->flush();

        $this->addFlash('success', 'Utilisateur suspendu.');
        return $this->redirectToRoute('admin_users_index');
    }
}
