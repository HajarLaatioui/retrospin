<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Entity\Vinyl;
use App\Form\LoanTypeForm;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;

#[IsGranted('ROLE_USER')]
class LoanController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/loan/new/{id}', name: 'loan_new_with_vinyl')]
    public function new(Request $request, EntityManagerInterface $em, Vinyl $vinyl): Response
    {
        $loan = new Loan();
        $loan->setVinyl($vinyl);
        $loan->setUser($this->security->getUser());
        $loan->setBorrowedAt(new \DateTimeImmutable());

        $form = $this->createForm(LoanTypeForm::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($loan);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('loan/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mes-prets', name: 'loan_list')]
    public function list(LoanRepository $loanRepository): Response
    {
        $user = $this->security->getUser();
        $loans = $loanRepository->findBy(['user' => $user]);

        return $this->render('loan/index.html.twig', [
            'loans' => $loans,
        ]);
    }

    #[Route('/loan/delete/{id}', name: 'loan_delete', methods: ['POST'])]
    public function delete(Request $request, Loan $loan, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $loan->getId(), $request->request->get('_token'))) {
            $em->remove($loan);
            $em->flush();
        }

        return $this->redirectToRoute('loan_list');
    }
}