<?php

namespace App\Controller;
use App\Entity\User;
use App\Model\DataClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function test(Request $request): Response
    {
        $form = $this->createFormBuilder(data: new DataClass(), options: ['data_class' => DataClass::class, 'attr' => ['novalidate' => true]])
            ->add('uninitialisedInteger')
            ->add('integer')
            ->add('submit', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        return $this->render('base.html.twig', ['form' => $form]);
    }

    #[Route('/new-user')]
    public function newUser(Request $request): Response
    {
        // About to create a new user
        $user = new User();

        $form = $this->createFormBuilder(data: $user, options: [
            'data_class' => User::class,
            'attr' => ['novalidate' => true]
        ])
            ->add('userIdentifier', options: [
                'help' => 'Leave empty and hit the submit button'
            ])
            ->add('submit', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        return $this->render('user.html.twig', [
            'form' => $form,
            'text' => 'Whe $user->userIdentifier is not initialised, the form shows a correct validation error',
            'user' => $user,
        ]);
    }

    #[Route('/existing-user')]
    public function existingUser(Request $request): Response
    {
        // Say you would get this via $this->getUser()
        $user = new User();
        $user->userIdentifier = 'existing@value.com';

        $form = $this->createFormBuilder(data: $user, options: [
            'data_class' => User::class,
            'attr' => ['novalidate' => true]
        ])
            ->add('userIdentifier', options: [
                'help' => 'Clear the value and hit the submit button'
            ])
            ->add('submit', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        return $this->render('user.html.twig', [
            'form' => $form,
            'text' => 'Whe $user->userIdentifier had some value and a blank value is submitted, the request fails with an exception.',
            'user' => $user,
        ]);
    }
}
