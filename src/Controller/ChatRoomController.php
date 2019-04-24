<?php

namespace App\Controller;

use App\Entity\ChatRoom;
use App\Form\ChatRoomType;
use App\Repository\ChatRoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chatroom")
 */
class ChatRoomController extends AbstractController
{
    /**
     * @Route("/", name="chat_room_index", methods={"GET"})
     */
    public function index(ChatRoomRepository $chatRoomRepository): Response
    {
        return $this->render('chat_room/index.html.twig', [
            'chat_rooms' => $chatRoomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="chat_room_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chatRoom = new ChatRoom();
        $form = $this->createForm(ChatRoomType::class, $chatRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chatRoom);
            $entityManager->flush();

            return $this->redirectToRoute('chat_room_index');
        }

        return $this->render('chat_room/new.html.twig', [
            'chat_room' => $chatRoom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chat_room_show", methods={"GET"})
     */
    public function show(ChatRoom $chatRoom): Response
    {
        return $this->render('chat_room/show.html.twig', [
            'chat_room' => $chatRoom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chat_room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ChatRoom $chatRoom): Response
    {
        $form = $this->createForm(ChatRoomType::class, $chatRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chat_room_index', [
                'id' => $chatRoom->getId(),
            ]);
        }

        return $this->render('chat_room/edit.html.twig', [
            'chat_room' => $chatRoom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chat_room_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ChatRoom $chatRoom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chatRoom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chatRoom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chat_room_index');
    }
}
