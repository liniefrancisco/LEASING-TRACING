<?php 
class MYPDF extends TCPDF {

	public $title = "Default Title";

	public function set_default_settings(){
		$this->SetCreator("Alturas Group of Companies");
		$this->SetAuthor('Alturas Group of Companies');
		$this->SetTitle($this->title);
		$this->SetSubject('TENANT SALES AND MONITORING SYSTEM');
		// set default header data
		$this->SetHeaderData('alturas logo.jpg', PDF_HEADER_LOGO_WIDTH, "ALTURAS GROUP OF COMPANIES", "Tenant Sales and Monitoring System");

		// set header and footer fonts
		$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);


		// set auto page breaks
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
	}

	 public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 9, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}
