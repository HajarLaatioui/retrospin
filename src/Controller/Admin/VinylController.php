<?php

namespace App\Controller\Admin;

use App\Entity\Vinyl;
use App\Form\VinylTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/vinyls')]
class VinylController extends AbstractController
{
    #[Route('/new', name: 'admin_vinyl_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $vinyl = new Vinyl();
        $form = $this->createForm(VinylTypeForm::class, $vinyl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($vinyl);
            $em->flush();
            return $this->redirectToRoute('admin_vinyl_list');
        }

        return $this->render('admin/new_vinyl.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('', name: 'admin_vinyl_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): Response
    {
        $vinyls = $em->getRepository(Vinyl::class)->findAll();

        return $this->render('admin/vinyls.html.twig', [
            'vinyls' => $vinyls,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_vinyl_edit', methods: ['GET', 'POST'])]
public function edit(Vinyl $vinyl, Request $request, EntityManagerInterface $em): Response
{
    $form = $this->createForm(VinylTypeForm::class, $vinyl);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('admin_vinyl_list');
    }

    return $this->render('admin/edit_vinyl.html.twig', [
        'form' => $form->createView(),
        'vinyl' => $vinyl,
    ]);
}

#[Route('/{id}/delete', name: 'admin_vinyl_delete', methods: ['POST'])]
public function delete(Request $request, Vinyl $vinyl, EntityManagerInterface $em): Response
{
    if ($this->isCsrfTokenValid('delete' . $vinyl->getId(), $request->request->get('_token'))) {
        $em->remove($vinyl);
        $em->flush();
    }

    return $this->redirectToRoute('admin_vinyl_list');
}
}