<?php

namespace App\Controller;

use App\Entity\EventSession;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $eventSession = $em->getRepository(EventSession::class)->findOneBy(['isActive' => true]);
        return $this->render('default/index.html.twig', [
            'eventSession' => $eventSession
        ]);
    }

    #[Route('/qr/{slug}.svg', name: 'qr_svg')]
    public function getQRCode(string $slug): Response
    {
        $options = new QROptions([
            'version'             => 2,
            'outputType'          => QRCode::OUTPUT_MARKUP_SVG,
            'imageBase64'         => false,
            'eccLevel'            => QRCode::ECC_L,
            'drawCircularModules' => true,
            'circleRadius'        => 0.4,
            // connect paths
            'connectPaths'        => true,
        ]);
        $qr = new QRCode($options);
        $data = $this->generateUrl('quiz_play', ['slug' => $slug]);
        $headers = array(
            'Content-Type'     => 'image/svg+xml',
            'Content-Disposition' => 'inline; filename="'.$slug.'.svg"');
        return new Response($qr->render($data), 200, $headers);
    }
}
