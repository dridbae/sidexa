<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->get('AppBundle\Service\CheckDuplicateMail')->check($user->getEmail())) {
                return $this->render('default/index.html.twig', [
                    'error' => 'You have already subscribe to our partners newsletter',
                    'form' => $form->createView()
                ]);
            }

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('success_page'));
            } catch (\Exception $e) {
                return $this->render('default/index.html.twig', [
                    'error' => $e->getMessage(),
                    'form' => $form->createView()
                ]);
            }
        } else {
            return $this->render('default/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/success", name="success_page")
     * @param Request $request
     * @return Response
     */
    public function successAction(Request $request): Response
    {
        return $this->render('success/index.html.twig');
    }
}
