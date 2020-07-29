<?php

require_once(dirname(__DIR__).'/lib/pdf/fpdf.php');

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',18);
        // Move to the right
        $this->Cell(70);
        // Title
        $this->Cell(30,10,'Borrowers note','B',1,'C');
        $this->Cell( 40, 40, $this->Image("../img/dhbw_logo.jpg", 0, 0, 33.78), 0, 0, 'R', false );
        // Line break
        $this->Ln(12);
    }

// Page footer
    function Footer()
    {


        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function BasicInfo($name, $surname, $street, $plz, $city, $tel, $martikelNr, $course, $email)
    {
        $this->AliasNbPages();
        $this->AddPage();

        $this->SetFont('Arial','B',12);
        $this->Cell(80,10,'Information of the borrowing party:', 'B', 1);
// Line break
        $this->Ln(2);
        $this->Cell(30, 7, 'First name: ');
        $this->Cell(40, 7, $name, 'B');
        $this->Cell(10, 7, '');
        $this->Cell(30, 7, 'Last name: ');
        $this->Cell(40, 7, $surname, 'B');
        $this->Ln();
        $this->Cell(30, 7, 'Address: ');
        $this->Cell(40, 7, $street, 'B');
        $this->Cell(10, 7, '');
        $this->Ln();
        $this->Cell(30, 7, 'City: ');
        $this->Cell(40, 7, $city, 'B');
        $this->Cell(10, 7, '');
        $this->Cell(30, 7, 'Telephone: ');
        $this->Cell(40, 7, $tel, 'B', 1);
        $this->Cell(30, 7, 'UserID. : ');
        $this->Cell(40, 7, $martikelNr, 'B');
        $this->Cell(10, 7, '');
        $this->Cell(30, 7, 'Course: ');
        $this->Cell(40, 7, $course, 'B');
        $this->Ln();
        $this->Cell(30, 7, 'Email: ');
        $this->Cell(40, 7, $email, 'B');
        $this->Ln();
    }
    function Resources($resources)
    {
        $this->SetFont('Arial','B',12);
        $this->Cell(80,10,'Borrowed articles:', 'B', 1);
// Line break
        $this->Ln(2);
        $this->Cell(10, 7, 'Pos.', 1);
        $this->Cell(20, 7, 'Amount', 1);
        $this->Cell(50, 7, 'Resource', 1);
        $this->Cell(40, 7, 'Serial number', 1);
        $this->Cell(40, 7, 'Inventory number', 1);
        $this->Cell(30, 7, 'Comments', 1);
        $this->Ln();
        $this->Cell(10, 7, '1', 1);
        $this->Cell(20, 7, '1', 1);
        $this->Cell(50, 7, $resources->name, 1);
        $this->Cell(40, 7, $resources->serial, 1);
        $this->Cell(40, 7, $resources->inventory_nr, 1);
        $this->Cell(30, 7, $resources->comment, 1);
        $this->Ln();
        $this->Cell(10, 7, '2', 1);
        $this->Cell(20, 7, '', 1);
        $this->Cell(50, 7, '', 1);
        $this->Cell(40, 7, '', 1);
        $this->Cell(40, 7, '', 1);
        $this->Cell(30, 7, '', 1);
        $this->Ln();
        $this->Cell(10, 7, '3', 1);
        $this->Cell(20, 7, '', 1);
        $this->Cell(50, 7, '', 1);
        $this->Cell(40, 7, '', 1);
        $this->Cell(40, 7, '', 1);
        $this->Cell(30, 7, '', 1);
        $this->Ln();
    }

    function Conditions()
    {
        $this->Cell(5, 5, '1. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'The borrow contract is created between the Dualen Hochschule Baden-Wuerttemberg Mannheim, Coblitzalle 1-9, 68163 Mannheim and the borrowing party.');
        $this->Cell(5, 5, '2. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'The use of the resources is only permitted for the purposes of the study program.');
        $this->Cell(5, 5, '3. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'Transfer of the resources to a third party is not permitted.');
        $this->Cell(5, 5, '4. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'The resources are to be handled with care. Damage, loss or theft of the property is to be reported latest at the return to Stephan Kaldschmidt or Johann Meister of the DHBW Mannheim.');
        $this->Cell(5, 5, '5. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'The borrower is responsible for damages, loss or theft.');
        $this->Cell(5, 5, '6. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'The return is to happen by the agreed upon return date- the Duale Hochschule Baden-Wuerttemberg Mannheim reserves its right to deny further rentals.');
        $this->Cell(5, 5, '7. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'Opening hours for returns: Mo-Fr 9:00 - 15:00 Uhr to Stephan Kaldschmidt or Johann Meister.');
        $this->Cell(5, 5, '8. ');
        $this->Cell(5, 5, '');
        $this->MultiCell(150, 5, 'It is strictly forbidden to transfer the borrowed articles to a third party!');
    }

    function Signatures($date)
    {

        $this->SetFont('Arial','',10);
        $this->Ln(2);

        $this->SetFont('Arial','B',12);
        $this->Cell(80,10,'Terms of contract:', 'B', 1);
        $this->Ln(2);

        $this->SetFont('Arial','',6);
        $this->Conditions();
        $this->Ln(2);

        $this->SetFont('Arial','',10);
        $this->Cell(150,10,'With my signature I authorize the rental, and accept the terms of contract,', '', 1);
        $this->Ln(4);

        $this->SetFont('Arial','',12);
        $this->Ln(2);

        $this->Cell(40, 7, 'Mannheim the ');
        $this->Cell(40, 7,  $date, 'B');
        $this->Cell(10, 7, '');
        $this->Cell(90, 7, '', 'B', 1);
        $this->Cell(90, 7, '');
        $this->Cell(50, 7, 'Signature borrower', '', 1);
        $this->Ln();
        $this->Cell(40, 7, 'Returned on: ');
        $this->Cell(40, 7, '', 'B');
        $this->Cell(10, 7, '');
        $this->Cell(40, 7, 'Return through: ');
        $this->Cell(50, 7, '', 'B', 1);
        $this->Ln();
        $this->Cell(40, 7, 'Notes: ');
        $this->Cell(140, 7, '', 'B');
    }
}
