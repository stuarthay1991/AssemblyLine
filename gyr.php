<?php


//require_once('tcpdf/examples/tcpdf_include.php');

//include 'tcpdf/examples/tcpdf_include.php';
require_once('tcpdf/tcpdf.php');

class JProofTcpdf extends TCPDF
{
    /**
     * @buggy svg handler in 6.2.
     *
     * @param        $file
     * @param string $x
     * @param string $y
     * @param int    $w
     * @param int    $h
     * @param string $link
     * @param string $align
     * @param string $palign
     * @param int    $border
     * @param bool   $fitonpage
     *
     * @return \image|void
     */
    public function ImageSVG($file, $x = '', $y = '', $w = 0, $h = 0, $link = '', $align = '', $palign = '', $border = 0, $fitonpage = false)
    {
        if (is_file($file) && is_readable($file))
        {
            $file = '@' . file_get_contents($file);
        }

        return parent::ImageSVG($file, $x, $y, $w, $h, $link, $align, $palign, $border, $fitonpage);
    }
}

$encodePAH1Zdata = $_POST['PAH1Zdata'];
$input_filename = $_POST['filename_pdf'];
$input_filename = $input_filename . ".pdf";
//echo $encodeData;

ob_start();
file_put_contents('PAH1Zdata.svg', $encodePAH1Zdata);
$pdf = new JProofTcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();
$pdf->ImageSVG($file ='PAH1Zdata.svg', $x=0, $y=0, $w=195, $h=195, $link='', $palign='', $border=1, $fitonpage=false);
$pdf->SetAlpha(1);
ob_end_clean();
$pdf->Output($input_filename, 'D');


?>