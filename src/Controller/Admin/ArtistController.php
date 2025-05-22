<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use App\Form\ArtistTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/artists')]
class ArtistController extends AbstractController
{
    #[Route('/new', name: 'admin_artist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistTypeForm::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($artist);
            $em->flush();
            return $this->redirectToRoute('admin_artist_list');
        }

        return $this->render('admin/new_artist.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('', name: 'admin_artist_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): Response
    {
        $artists = $em->getRepository(Artist::class)->findAll();

        return $this->render('admin/artists.html.twig', [
            'artists' => $artists,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_artist_edit', methods: ['GET', 'POST'])]
    public function edit(Artist $artist, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ArtistTypeForm::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_artist_list');
        }

        return $this->render('admin/edit_artist.html.twig', [
            'form' => $form->createView(),
            'artist' => $artist,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_artist_delete', methods: ['POST'])]
    public function delete(Request $request, Artist $artist, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $request->request->get('_token'))) {
            $em->remove($artist);
            $em->flush();
        }

        return $this->redirectToRoute('admin_artist_list');
    }
}