<?php

namespace App\Controller\Auth;

use App\Controller\ErrorHandler;
use App\Model\User\UseCase;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    public function __construct(private ErrorHandler $errorHandler)
    {
    }

    #[Route(path: '/signup', name: 'auth.signup')]
    public function signUp(Request $request, UseCase\Create\Handler $handler): Response
    {
        $command = new UseCase\Create\Command();

        $form = $this->createForm(UseCase\Create\Form::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Check your email');
                return $this->redirectToRoute('app_login');
            } catch (DomainException $e) {
                $this->addFlash('error', $e->getMessage());
                $this->errorHandler->handle($e);
            }
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/signup/{token}/confirm', name: 'auth.signup.confirm')]
    public function signUpConfirm(string $token, UseCase\ConfirmToken\Handler $handler): Response
    {
        $command = new UseCase\ConfirmToken\Command($token);
        try {
            $handler->handle($command);
            $this->addFlash('success', 'You activate your account');
        } catch (DomainException $e) {
            $this->addFlash('error', 'Could not activate your account');
            $this->errorHandler->handle($e);
        }

        return $this->redirectToRoute('app_login');
    }
}