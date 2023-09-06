<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

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
}

class DataClass {
    #[Assert\NotBlank]
    public int $uninitialisedInteger;

    #[Assert\NotBlank]
    public int $integer = 1;
}