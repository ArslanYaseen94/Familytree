<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class generateFamilyTreePdfWithFpdi extends Controller
{
    public function generateFamilyTreePdfWithFpdi($treeId)
    {
        // Step 1: Fetch your data
        $family = Member::where('tree_id', $treeId)->orderBy('generation')->get();
        
        // Step 2: Create the PDF and import your template
        $pdf = new Fpdi();
        $pdf->AddPage();

        $templatePath = public_path('pdf/DIYFamilyTree24x36softbackground_ReaderExtended (1).pdf');
        $pageCount = $pdf->setSourceFile($templatePath);
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 0, 0);

        // Step 3: Set font style and size
        $pdf->SetFont('Helvetica', '', 14);

        // Step 4: Loop over your data and place text at coordinates
        foreach ($family as $index => $member) {
            if (!empty($member->name)) {
                // Compute your own X and Y here
                [$x, $y] = $this->getCoordinatesForIndex($index);

                $pdf->SetXY($x, $y);
                $pdf->Write(0, $member->name);

                // Optional: birthdate
                if (!empty($member->birthdate)) {
                    $pdf->SetXY($x, $y + 5); // adjust Y down by 5pt
                    $pdf->Write(0, 'Birth: ' . $member->birthdate);
                }

                // Optional: deathdate
                if (!empty($member->deathdate)) {
                    $pdf->SetXY($x, $y + 10); // adjust Y down by another 5pt
                    $pdf->Write(0, 'Death: ' . $member->deathdate);
                }
            }
        }

        // Step 5: Save the filled PDF
        $outputPdfPath = storage_path("app/public/family_tree_filled_fpdi_{$treeId}.pdf");
        $pdf->Output('F', $outputPdfPath);

        // Step 6: Display the generated PDF directly in the browser
        return response()->file($outputPdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="family_tree_filled.pdf"',
        ]);
    }

    /**
     * Calculate X,Y coordinates for each family member
     * Replace with your own logic to match your template
     */
    private function getCoordinatesForIndex($index)
    {
        // Example logic: spread out names horizontally & vertically
        $startX = 50;  // starting X
        $startY = 50;  // starting Y
        $xSpacing = 150;
        $ySpacing = 40;

        // Place members in rows of 5
        $x = $startX + ($index % 5) * $xSpacing;
        $y = $startY + floor($index / 5) * $ySpacing;

        return [$x, $y];
    }
}
