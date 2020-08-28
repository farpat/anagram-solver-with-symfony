<?php

namespace App\Controller;

use App\Services\AnagramSolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{File\UploadedFile, Request, Response};
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     */
    public function index(Request $request, AnagramSolver $anagramSolver): Response
    {
        $results = [];

        if ($request->getMethod() === 'POST' && $this->isCsrfTokenValid('home',
                $request->request->get('_csrf_token'))) {
            /** @var ?UploadedFile $file */
            $file = $request->files->get('file');

            if ($file !== null && $file->getMimeType() === 'text/plain') {
                if ($resource = fopen($file->getPathname(), 'r')) {
                    while (!feof($resource)) {
                        $string = trim(fgets($resource));
                        if ($string === '') {
                            continue;
                        }
                        [$firstString, $secondString] = explode(' ', $string);
                        $results[] = sprintf("Pour %s et %s => Le résultat est %s",
                            $firstString,
                            $secondString,
                            $anagramSolver->getTheNumberOfMoves($firstString, $secondString)
                        );
                    }
                }
            }
        }

        return $this->render('home/index.html.twig', [
            'results' => $results
        ]);
    }
}
