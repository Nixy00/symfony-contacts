<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contactRepository, #[MapQueryParameter] ?string $search = ''): Response
    {
        $contacts = $contactRepository->search($search);

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contact/{id}', name: 'app_contact_id', requirements: ['id' => '\d+'])]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        Contact $contact,
    ): Response {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/contact/{id}/update', name: 'app_contact_update', requirements: ['id' => '\d+'])]
    public function update(Request $request, EntityManagerInterface $em, #[MapEntity] Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_contact_id', [
                'id' => $contact->getId(),
            ]);
        }

        return $this->render('contact/update.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/create', name: 'app_contact_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('app_contact_id', ['id' => $contact->getId()]);
        }

        return $this->render('contact/create.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/{id}/delete', name: 'app_contact_delete', requirements: ['id' => '\d+'])]
    public function delete(#[MapEntity] Contact $contact, Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        return $this->render('contact/delete.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }
}
