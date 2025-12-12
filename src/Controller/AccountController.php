<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/account', name: 'app_account')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class AccountController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: '')]
    public function index(OrderRepository $repository): Response
    {
        $currentUser = $this->getUser();
        if (!$currentUser instanceof User) {
            throw $this->createNotFoundException('This user does not exist!');
        }
        $orders = $repository->findBy(['client' => $currentUser, 'isComplete' => true], ['creationDate' => 'DESC']);
        $hasApiAccess = $currentUser->isApiEnabled();

        return $this->render('account/index.html.twig', [
            'orders' => $orders,
            'hasApiAccess' => $hasApiAccess,
        ]);
    }

    #[Route('/api-access', name: '_api_access', methods: ['POST'])]
    public function changeApiAccess(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createNotFoundException('This user does not exist!');
        }
        $user->setApiEnabled(!$user->isApiEnabled());
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_account');
    }

    #[Route('/delete-account', name: '_delete_account', methods: ['POST'])]
    public function deleteAccount(Security $security): Response
    {
        $user = $this->getUser();
        $security->logout(false);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
