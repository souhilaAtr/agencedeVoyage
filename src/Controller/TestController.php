<?php

namespace App\Controller;

use Mpdf\Mpdf;

use App\Entity\Test;
use App\Form\TestType;
use Smalot\PdfParser\Parser;
use setasign\Fpdi\Tcpdf\Fpdi;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/', name: 'app_test_index', methods: ['GET'])]
    public function index(TestRepository $testRepository): Response
    {
        return $this->render('test/index.html.twig', [
            'tests' => $testRepository->findAll(),
        ]);
    }
    #[Route('/extract-pdf', name: "extract_pdf")]
    public function extractPdf(): Response
    {
        // Chemin vers le fichier PDF que vous souhaitez traiter
        $pdfPath = __DIR__ . '/Bootstrap.pdf';

        // Instanciez le parser PDF
        $parser = new Parser();

        // Chargez le fichier PDF
        $pdf = $parser->parseFile($pdfPath);
        
        // Récupérez le texte du PDF
        $text = $pdf->getText();
dd($text);
        return new Response($text);
    }
    #[Route('/new', name: 'app_test_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test/new.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_show', methods: ['GET'])]
    public function show(Test $test): Response
    {
        return $this->render('test/show.html.twig', [
            'test' => $test,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Test $test, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test/edit.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_delete', methods: ['POST'])]
    public function delete(Request $request, Test $test, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $test->getId(), $request->request->get('_token'))) {
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
    }




    // #[Route('/{id}', name: 'app_test_show', methods: ['GET'])]
    // public function sxxhow(Test $test): Response
    // {
    //     return $this->render('test/show.html.twig', [
    //         'test' => $test,
    //     ]);
    // }

    // #[Route('/pdf', name: 'app_test_pdf', methods: ['GET'])]
    public function generatePdf(TestRepository $test)
    {
        $test = $test->findAll();
        // dd($test);
        // Créez une instance de mPDF
        $mpdf = new Mpdf();
        $yourData = "souhila";
        // Générez le contenu HTML que vous souhaitez convertir en PDF
        $html = $this->renderView('souhila.html.twig', [
            'data' => $test,
        ]);

        // Convertissez le HTML en PDF
        $mpdf->WriteHTML($html);

        // Renvoyez le PDF en tant que réponse HTTP
        return new Response($mpdf->Output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
