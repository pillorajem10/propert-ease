<?php
require_once('connect.php');
require('fpdf/fpdf.php');
require_once 'includes/security.php';
session_start();

function generateReceipt($name, $location, $payRate, $dueDate, $subTotal, $date, $transnum, $landname) {
    try {
        // Define a custom PDF class extending FPDF
        class PDF extends FPDF {
            function Header() {
                // Set background color with light blue-green
                $this->SetFillColor(193, 227, 217); 
                $this->Rect(0, 0, 210, 40, 'F'); // Header container rectangle
            
                // Include logo
                $logoPath = 'img/app-logo2.png';
                $imageWidth = 60; // Desired width for the logo
                $imageHeight = 0; // Initialize height for calculation
            
                // Calculate image height to maintain aspect ratio
                if (file_exists($logoPath)) {
                    list($logoWidth, $logoHeight) = getimagesize($logoPath);
                    $imageHeight = ($logoHeight / $logoWidth) * $imageWidth;
                }
            
                // Position logo on the left side with padding
                $logoX = 10; // X-coordinate for logo
                $logoY = (40 - $imageHeight) / 2; // Center vertically within the header container
            
                $this->Image($logoPath, $logoX, $logoY, $imageWidth, $imageHeight);
            
                // Title text
                $this->SetFont('Arial', 'B', 24); // Larger font for title
                $this->SetTextColor(45, 134, 135); // Darker green/blue shade
                $this->Cell(0, 10, '', 0, 1, 'C'); // Empty cell for vertical spacing
                $this->Cell(0, 10, 'Payment Receipt', 0, 1, 'C'); // Title cell
            
                $this->Ln(10); // Extra line spacing
            }                                                

            function Footer() {
                $this->SetY(-30); // Move to 30mm from bottom
                $this->SetFillColor(193, 227, 217); // Match header background color
                $this->Rect(0, 280, 210, 20, 'F'); // Create rectangular container
            }            

            function HeaderSection($transnum, $date, $name, $location, $landname) {
                $this->SetFont('Arial', 'B', 20); // Increased font size
                $this->SetTextColor(0); // Black text color
                
                // Header line
                $this->SetLineWidth(0.2);
                $this->SetDrawColor(0); // Black color for lines
                $this->Line(10, $this->GetY(), 200, $this->GetY()); // Draw a line below the header section
            
                // Set top margin for this section (slightly reduced)
                $this->SetY($this->GetY() + 8);
            
                // Receipt details
                $this->Cell(0, 15, 'Receipt Number: ' . $transnum, 0, 1); // Receipt number
                $this->Cell(0, 15, 'Date: ' . date('F j, Y', strtotime($date)), 0, 1); // Date
                $this->MultiCell(0, 15, 'Received from: ' . $name, 0); // Received from
                $this->MultiCell(0, 15, 'Sent to: ' . $landname, 0); // Received from
                $this->MultiCell(0, 15, 'Location: ' . $location, 0); // Location
                $this->Ln(8); // Extra line spacing
            }
            
            function PaymentDetailsSection($payRate, $dueDate) {
                $this->SetFont('Arial', 'B', 20); // Increased font size
                $this->SetTextColor(0); // Black text color
                
                // Payment details header line
                $this->SetLineWidth(0.2);
                $this->SetDrawColor(0); // Black color for lines
                $this->Line(10, $this->GetY(), 200, $this->GetY()); // Draw a line below the payment details header
            
                // Set top margin for this section (slightly reduced)
                $this->SetY($this->GetY() + 8);
            
                // Payment details
                $this->Cell(0, 15, 'Payment Details:', 0, 1); // Payment details header
      
                $this->Cell(0, 15, 'Due Date: ' . date('F j, Y', strtotime($dueDate)), 0, 1); // Due date
                $this->Cell(0, 15, 'Payment Total: Php ' . number_format($payRate, 2), 0, 1); // Pay rate
                // Set bottom margin for this section
                $this->SetY($this->GetY() + 10);
            }            
        }

        $pdf = new PDF(); // Create new instance of PDF class
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 16); // Set default font size to 16

        // Include different sections in the PDF
        $pdf->HeaderSection($transnum, $date, $name, $location, $landname);
        $pdf->PaymentDetailsSection($payRate, $dueDate);

        // Output PDF as base64-encoded string
        $pdfContent = $pdf->Output('S'); // Save PDF to file

        // Return base64-encoded PDF content
        return base64_encode($pdfContent);
    } catch (Exception $e) {
        // Log the error
        error_log('Error generating receipt: ' . $e->getMessage());
        return false;
    }
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $tenantId = $_SESSION['tenant_id'];

        // Fetch tenant details
        $stmt = $pdo->prepare("SELECT * FROM tenant_tbl WHERE tenant_id = ?");
        $stmt->execute([$tenantId]);
        $tenant = $stmt->fetch();

        require_once 'includes/tenant-decryption.php';

        // Fetch transaction details
        $uniqueId = $tenant['unique_id'];
        $stmt = $pdo->prepare("SELECT * FROM transaction_records WHERE unique_id = ?");
        $stmt->execute([$uniqueId]);
        $transactions = $stmt->fetch();

        // Fetch property details
        $propertyId = $tenant['property_id'];
        $stmt = $pdo->prepare("SELECT * FROM property_tbl WHERE property_id = ?");
        $stmt->execute([$propertyId]);
        $property = $stmt->fetch();

        require_once 'includes/property-decryption.php';

        $landlordId = $tenant['landlord_id'];
        $stmt = $pdo->prepare("SELECT * FROM landlord_tbl WHERE landlord_id = ?");
        $stmt->execute([$landlordId]);
        $landlord = $stmt->fetch();
        
        require_once 'includes/landlord-decryption.php';
        // Prepare data for receipt generation
        
        $name = $tenantFname . ' ' . $tenantLname;
        $location = $propertyAddress . ', ' . $propertyBrgy . ', ' . $propertyCity . ', ' . $propertyProvince . ', ' . $propertyZipcode;
        $payRate = $propertyPrice;
        $dueDate = $transactions['tenant_due'];
        $date = $transactions['transaction_date'];
        $transnum = $transactions['transaction_receipt'];
        $landname = $landlordFname. ' ' . $landlordLname;

        // Generate the receipt and get the PDF content as base64
        $pdfContent = generateReceipt($name, $location, $payRate, $dueDate, $subTotal, $date, $transnum, $landname);

        if ($pdfContent) {
            // Return JSON response with the PDF content
            header('Content-Type: application/json');
            echo json_encode(array('pdfContent' => $pdfContent));
        } else {
            // Handle error case - log error or return error response
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array('error' => 'PDF content not generated'));
            exit;
        }
    } catch (Exception $e) {
        // Log the error
        error_log('Error processing request: ' . $e->getMessage());
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array('error' => 'Internal Server Error'));
        exit;
    }
}
?>