<?php

namespace App\Controller;

use App\Entity\ShortLink;
use App\Form\ShortLinkType;
use App\Repository\ShortLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShortLinkerController
 *
 * @package App\Controller
 */
class ShortLinkerController extends Controller
{
    /**
     * @Route("/")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createShortLink(Request $request)
    {
        $clientIp = $request->getClientIp();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(ShortLinkType::class, null);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->get('link')->getData();
            $shortLinkService = $this->container->get('app.short_link');
            $shortLink = $shortLinkService->findShortLink($url, $clientIp);

            if (!empty($shortLink)) {
                $message = "<b class='badge-danger'>Your short link exists!</b> Short link is <a href='{$shortLink->getSlug()}'>{$shortLink->getSlug()}</a> and full link is {$shortLink->getUrl()}.";
            } else {
                $shortLink = $shortLinkService->createNewShortLink($url, $clientIp);
                $message = "Your new short link saved! New link is <a href='{$shortLink->getSlug()}'>{$shortLink->getSlug()}</a> and full link is {$shortLink->getUrl()}.";
            }

            $this->addFlash('notice', $message);
        }

        /** @var array $urls */
        $urls = $entityManager
            ->getRepository(ShortLink::class)
            ->findOneByClientIdFields($clientIp);

//        var_dump($urls);

        return $this->render('create-short-link.html.twig', [
            'client_ip' => $clientIp,
            'form' => $form->createView(),
            'urls' => $urls,
        ]);
    }

    /**
     * @Route("/{slug}", name="short_link")
     *
     * @return Response
     */
    public function showShortLink($slug, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ShortLink $shortLink */
        $shortLink = $entityManager->getRepository(ShortLink::class)
            ->findOneBy(['slug' => $slug]);
        $hits = $shortLink->getHits();

        $shortLink->setHits(++$hits);
        $entityManager->flush();

        return $this->redirect($shortLink->getUrl());
    }
}
