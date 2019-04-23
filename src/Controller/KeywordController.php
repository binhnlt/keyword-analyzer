<?php

namespace App\Controller;

use App\Entity\Keyword;
use App\Form\KeywordUploaderType;
use App\Service\KeywordAnalyzerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class KeywordController extends AbstractController
{

    /**
     * @var KeywordAnalyzerService
     */
    private $keywordAnalyzerService;

    public function __construct(KeywordAnalyzerService $keywordAnalyzerService)
    {
        $this->keywordAnalyzerService = $keywordAnalyzerService;
    }

    /**
     * Display report base on keywords
     * 
     * @Route("/keyword/report", name="keyword_report")
     */
    public function indexAction()
    {
        $data = $this->keywordAnalyzerService->getOverviewReport();
        return $this->render('keyword/index.html.twig', $data);
    }

    /**
     * Display all reports by keyword ID
     * 
     * @Route("/keyword/report/{keywordId}", name="keyword_report_detail")
     */
    public function detailAction(int $keywordId)
    {
        $data = $this->keywordAnalyzerService->getDetailByKeywordId($keywordId);

        if (!$data) {
            throw $this->createNotFoundException('The Keyword ID does not exist');
        }

        return $this->render('keyword/detail.html.twig', $data);
    }

    /**
     * Display all reports by keyword ID
     * 
     * @Route("/keyword/report/{keywordId}/cached/{reportId}", name="keyword_report_cached_page")
     */
    public function showCachedPageAction(int $keywordId, int $reportId)
    {
        $data = $this->keywordAnalyzerService->getCachedPageByReportId($reportId);
        return $this->render('keyword/cached_page.html.twig', $data);
    }

    /**
     * Display the form that allow user to upload CSV file
     * 
     * @Route("/keyword/upload", name="keyword_upload", methods={"GET"})
     */
    public function uploadAction()
    {
        $form = $this->createForm(KeywordUploaderType::class);
        return $this->render('keyword/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Uploading file
     * 
     * @Route("/keyword/upload", name="keyword_do_upload", methods={"POST"})
     */
    public function doUpload(Request $request)
    {
        $files = $request->files->get('keyword_uploader');
        $file = reset($files);

        $fileExtension = $file->getClientOriginalExtension();

        if (!in_array($fileExtension, ['csv'])) {
            $this->addFlash('error', 'Invalid file type');
            return $this->redirectToRoute('keyword_upload');
        }

        // Generate unique filename
        $fileName = md5(uniqid()) . '.' . $fileExtension;

        $file->move($this->getParameter('keyword_files_directory'), $fileName);
        $this->addFlash('success', 'Great!!! Your file is being processed, please wait...');
        return $this->redirectToRoute('keyword_upload');
    }
}
