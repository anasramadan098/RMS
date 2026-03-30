<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Exception;

class PrinterController extends Controller
{
    /**
     * Print paper - Note: This will only work if the printer is accessible via public IP
     * For local printers, consider using client-side solutions or print servers
     */
    public function printPaper($data, $type, $ip) {
        try {
            // Check if we're trying to access a local IP from hosted environment
            if ($this->isLocalIP($ip) && !$this->isLocalEnvironment()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Cannot access local printer from hosted server. Consider using client-side printing or a print server.',
                    'suggestions' => [
                        'Use browser printing with window.print()',
                        'Implement a local print server',
                        'Use cloud printing services',
                        'Generate PDF for download and manual printing'
                    ]
                ], 400);
            }

            $connector = new NetworkPrintConnector($ip, 9100);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("--- طلب $type ---\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("الصنف: " . ($data['name'] ?? '-') . "\n");
            $printer->text("الكمية: " . ($data['quantity'] ?? '-') . "\n");
            $printer->text("الحجم: " . ($data['size'] ?? '-') . "\n");
            $printer->text("الطاولة: " . ($data['table'] ?? '-') . "\n");
            $printer->text("النوع: " . ($data['type'] ?? '-') . "\n");
            $printer->feed(2);
            $printer->cut();
            $printer->close();
            
            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Generate printable HTML/PDF instead of direct printing
     * This is more suitable for hosted environments
     */
    public function generatePrintableReceipt($data, $type) {
        $html = view('receipts.print-template', [
            'data' => $data,
            'type' => $type,
            'timestamp' => now()
        ])->render();

        return response()->json([
            'status' => 'success',
            'html' => $html,
            'print_instruction' => 'Use browser print function (Ctrl+P) or download as PDF'
        ]);
    }

    public function kitchen(Request $request) {
        $data = $request->only(['name', 'quantity', 'size', 'table', 'type']);
        
        // For hosted environment, generate printable content instead
        if (!$this->isLocalEnvironment()) {
            return $this->generatePrintableReceipt($data, 'مطبخ');
        }
        
        return $this->printPaper($data, 'مطبخ', "192.168.1.100");
    }

    public function bar(Request $request) {
        $data = $request->only(['name', 'quantity', 'size', 'table', 'type']);
        
        // For hosted environment, generate printable content instead
        if (!$this->isLocalEnvironment()) {
            return $this->generatePrintableReceipt($data, 'بار');
        }
        
        return $this->printPaper($data, 'بار', "192.168.1.100");
    }

    /**
     * Check if IP is local/private
     */
    private function isLocalIP($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    /**
     * Check if running in local environment
     */
    private function isLocalEnvironment() {
        return app()->environment('local') || 
               str_contains(request()->getHost(), 'localhost') ||
               str_contains(request()->getHost(), '127.0.0.1') ||
               str_contains(request()->getHost(), '.local');
    }

    /**
     * Alternative: Generate PDF receipt for download
     */
    public function downloadReceipt(Request $request) {
        $data = $request->only(['name', 'quantity', 'size', 'table', 'type']);
        $type = $request->input('receipt_type', 'عام');
        
        // Generate PDF using a library like TCPDF or DOMPDF
        // This is a placeholder - you'll need to implement PDF generation
        return response()->json([
            'status' => 'success',
            'message' => 'PDF generation feature - implement with TCPDF or DOMPDF',
            'data' => $data,
            'type' => $type
        ]);
    }
}
