<?php

namespace jjalvarezl\PDFjsViewerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewerController extends Controller
{
    /**
     * Solves de pdf final location under the restriction that pdf's viewers can be only seen in
     * webroot directories.
     *
     * @param boolean $isPdfOutsideWebroot, determines if pdf is inside or outside webroot
     * @param $pdf, the path of the pdf, depends of $isPdfOutsideWebroot, if it's true, $pdf is absolute, else just the pdf complete name.
     * @param $tmpPdfPath, path of pdf's temporal dir
     * @return final pdf name, it already is inside the temp dir of pdfs
     * @throws \Exception
     */
    private function solvePDFLocation($isPdfOutsideWebroot, $pdf, $tmpPdfPath)
    {
        if(!$tmpPdfPath){
            $tmpPdfPath = '/bundles/jjalvarezlpdfjsviewer/tmpPdf/';
        }

        if($isPdfOutsideWebroot){
            exec('cp '.$pdf.' '.$this->get('kernel')->getRootDir().'/../web'.$tmpPdfPath.' 2>&1', $output, $returnVal);
            if($returnVal!=0){
                throw new \Exception('Can not copy pdf file to temporal directory: Exit='.$returnVal.' Message: '.implode(' ',$output));
            }
            $splittedPDFRoute = explode('/', $pdf);
            $pdf = end($splittedPDFRoute);
        }
        return $pdf;
    }

    /**
     * Renders the default pdf (used for test viewer with default settings).
     *
     * Mostly used for testing this viewer with all browsers.
     *
     */
    public function renderTestViewer()
    {
        return $this->render('jjalvarezlPDFjsViewerBundle:viewer:default.html.twig');
    }

    /**
     * View a pdf with all visual elements but custom pdf location (inside or outside webroot)
     *
     * an example of custom parameters customizing the viewer's options.
     *
     */
    public function renderDefaultViewer($parameters)
    {

        $parameters['pdf'] = $this::solvePDFLocation(
            $parameters['isPdfOutsideWebroot'],
            $parameters['pdf'],
            !isset($parameters['tmpPdfDirectory'])? null : $parameters['tmpPdfDirectory']
        );
        return $this->render('jjalvarezlPDFjsViewerBundle:viewer:default.html.twig',
            $parameters
        );
    }

    /**
     * View a pdf with custom parameters showing or hiding the pdf's viewer elements.
     *
     * an example of custom parameters customizing the viewer's options.
     *
     */
    public function renderCustomViewer($parameters)
    {
        $parameters['pdf'] = $this::solvePDFLocation(
            $parameters['isPdfOutsideWebroot'],
            $parameters['pdf'],
            !isset($parameters['tmpPdfDirectory'])? null : $parameters['tmpPdfDirectory']
        );
        return $this->render('jjalvarezlPDFjsViewerBundle:viewer:custom.html.twig',
            $parameters
        );
    }

    /**
     * Pdf system deletion from tmpDir
     *
     * @param string $PdfTmpPath , relative path to the pdf from webroot dir
     * @Route("/jjalvarezl_erase_pdf", name="jjalvarezl_erase_pdf")
     *
     * @return Response, Error in pdf deletion. If it's ok, this function must return an empty string.
     */
    public function deletePDF (Request $request){
        try{
            unlink(substr($request->get('PdfTmpPath'), 1));
        } catch (\Exception $e){
            return new Response('Can not delete pdf file from temporal directory, '.$e->getMessage().', please configure tmpPdfDirectory and pdf variables');
        }
        return new Response('');
    }
}
