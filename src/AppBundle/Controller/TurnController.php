<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Turn;
use AppBundle\Entity\Game;
use AppBundle\Form\TurnType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Turn controller.
 *
 * @Route("/turn")
 */
class TurnController extends Controller
{
    /**
     * Creates a new Turn entity.
     *
     * @Route("/new/{id}", name="turn_new")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:turn:new.html.twig")
     */
    public function newAction(Request $request, Game $game)
    {
        if (!$game->belongsTo($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $turn = (new Turn())->setGame($game);
        $form = $this->createForm(get_class(new TurnType()), $turn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $turn->setUpdatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($turn);
            $em->flush();

            if ($turn->getShareLink() !== '0') {
                $turn->generateShareLink();
                $em->persist($turn);
                $em->flush();
            }

            return $this->redirectToRoute('turn_show', array('id' => $turn->getId()));
        }

        return array('turn' => $turn,'form' => $form->createView());
    }

    /**
     * Finds and displays a Turn entity.
     *
     * @Route("/{id}", name="turn_show")
     * @Method("GET")
     * @Template("AppBundle:turn:show.html.twig")
     */
    public function showAction(Turn $turn)
    {
        if (!$turn->getGame()->belongsTo($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $deleteForm = $this->createDeleteForm($turn);

        return array('turn' => $turn,'delete_form' => $deleteForm->createView());
    }

    /**
     * Finds and displays a Turn entity.
     *
     * @Route("/share/{shareLink}", name="turn_shared_show")
     * @Method("GET")
     * @Template("AppBundle:turn:shared.html.twig")
     */
    public function showSharedAction(Turn $turn)
    {
        return array('turn' => $turn);
    }

    /**
     * Finds and displays a Turn entity.
     *
     * @Route("/link/delete/{id}", name="turn_shared_delete")
     * @Method("GET")
     */
    public function deleteLink(Turn $turn)
    {
        if (!$turn->getGame()->belongsTo($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $turn->setShareLink(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($turn);
        $em->flush();

        return $this->redirectToRoute('turn_edit', ['id' => $turn->getId()]);
    }

    /**
     * Finds and displays a Turn entity.
     *
     * @Route("/link/generate/{id}", name="turn_shared_generate")
     * @Method("GET")
     */
    public function generateLink(Turn $turn)
    {
        if (!$turn->getGame()->belongsTo($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $turn->generateShareLink();
        $em = $this->getDoctrine()->getManager();
        $em->persist($turn);
        $em->flush();

        return $this->redirectToRoute('turn_edit', ['id' => $turn->getId()]);
    }

    /**
     * Displays a form to edit an existing Turn entity.
     *
     * @Route("/{id}/edit", name="turn_edit")
     * @Method({"GET", "POST"})
     * @Template("AppBundle:turn:edit.html.twig")
     */
    public function editAction(Request $request, Turn $turn)
    {
        if (!$turn->getGame()->belongsTo($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $deleteForm = $this->createDeleteForm($turn);
        $editForm = $this->createForm(get_class(new TurnType()), $turn);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($turn);
            $em->flush();

            return $this->redirectToRoute('game_show', array('id' => $turn->getGame()->getId()));
        }

        return array(
            'turn' => $turn,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Turn entity.
     *
     * @Route("/{id}", name="turn_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Turn $turn)
    {
        if (!$turn->getGame()->belongsTo($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $gameId = $turn->getGame()->getId();

        $form = $this->createDeleteForm($turn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($turn);
            $em->flush();
        }

        return $this->redirectToRoute('game_show', ['id'=> $gameId]);
    }

    /**
     * Creates a form to delete a Turn entity.
     *
     * @param Turn $turn The Turn entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Turn $turn)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('turn_delete', array('id' => $turn->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
