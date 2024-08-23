<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Printer;
use Barryvdh\DomPDF\Facade\Pdf;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printer::all();
        return view('print-form', compact('printers'));
    }

    public function sendToPrinter(Request $request)
    {
        $request->validate([
            'printer_id' => 'required|exists:printers,id',
            'customer_name' => 'required|string',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
        ]);

        $printer = Printer::findOrFail($request->printer_id);

        try {
            // Generate PDF
            $pdf = Pdf::loadView('receipt', [
                'customer_name' => $request->customer_name,
                'items' => $request->items
            ]);

            // Save PDF to a temporary file
            $pdfPath = storage_path('app/temp_receipt.pdf');
            $pdf->save($pdfPath);

            // Connect to the printer via TCP/IP
            $fp = fsockopen($printer->ip_address, 9100, $errno, $errstr, 10);

            if (!$fp) {
                return response()->json(['success' => false, 'message' => "Error connecting to the printer: $errstr ($errno)"], 500);
            }

            // Read the PDF file and send its content to the printer
            $pdfData = file_get_contents($pdfPath);
            fwrite($fp, $pdfData);
            fclose($fp);

            // Delete the temporary PDF file
            unlink($pdfPath);

            return response()->json(['success' => true, 'message' => 'Print job sent successfully']);
        } catch (\Exception $e) {
            \Log::error("Print job failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send print job: ' . $e->getMessage()], 500);
        }
    }
}
