<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;



use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Exception;

class BillController extends Controller
{

    public function store($orderId)
    {
        $user_id = Auth::user()->id;
        $order = Order::findOrFail($orderId);

        // التحقق من وجود فاتورة سابقة لهذا الطلب
        $existingBill = Bill::where('order_id', $order->id)->first();
        if ($existingBill) {
            return redirect()->route('bills.show', $existingBill->id);
        }

        $project = Project::first();
        $client = $order->client;
        $items = $order->orderItems()->get();

        $billData = [
            'project_name' => $project->name ?? '',
            'project_link' => $project->link ?? '',
            'project_qr' => $project->qr_code ?? '',
            'date' => $order->created_at->format('Y-m-d H:i'),
            'client' => [
                'name' => $client->name ?? '',
                'email' => $client->email ?? '',
                'id' => $client->id ?? '',
            ],
            'order_details' => [
                'order_number' => $order->order_number,
                'order_type' => $order->order_type,
                'table_number' => $order->table_number,
            ],
            'meals' => $items->map(function($item) {
                return [
                    'meal_id' => $item->meal_id,
                    'meal_name' => Meal::find($item->meal_id)->name ?? 'Deleted Meal',
                    'quantity' => $item->quantity,
                    'price' => $item->unit_price,
                    'total' => $item->total_price,
                ];
            }),
            'summary' => [
                'subtotal' => $order->subtotal,
                'tax_amount' => $order->tax_amount,
                'delivery_fee' => $order->delivery_fee,
                'total_amount' => $order->total_amount,
            ]
        ];

        $bill = new Bill();
        $bill->order_id = $order->id;
        $bill->bill_number = 'BILL-' . now()->format('YmdHis') . '-' . $order->id;
        $bill->bill_data = json_encode($billData);
        $bill->save();


        // #region Print
        try {
            // Enter the IP address of your printer
            $connector = new NetworkPrintConnector("192.168.1.100", 9100);
            $printer = new Printer($connector);

            // Project name centered and bold
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text($billData['project_name'] . "\n");
            $printer->setEmphasis(false);
            $printer->text("--------------------------------\n");
            $printer->text("CAIRO\n");
            $printer->text("01023399990\n");
            $printer->feed(3); // 50px space equivalent

            // Invoice number
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("فاتورة: " . $billData['order_details']['order_number'] . "\n");
            $printer->text("--------------------------------\n");

            // Date and time
            $date = new \DateTime($billData['date']);
            $shift = ($date->format('H') >= 12) ? "مسائًا" : "صباحًا";
            $printer->text("التاريخ: " . $date->format('Y-m-d') . "     الوقت: " . $date->format('H:i') . "\n");
            $printer->text("الطاولة: " . $billData['order_details']['table_number'] . "     الوردية: " . $shift . "\n");
            $printer->text("العميل: " . $billData['client']['name'] . " => " . $billData['client']['id'] . "\n");
            $printer->feed(2); // 30px space equivalent

            // Items table header
            $printer->text("الصنف     الكمية     السعر     القيمة\n");
            $printer->text("--------------------------------\n");

            // Items
            foreach ($billData['meals'] as $meal) {
                $printer->text(sprintf("%-10s %-8d %-8.2f %-8.2f\n",
                    $meal['meal_name'],
                    $meal['quantity'],
                    $meal['price'],
                    $meal['total']
                ));
            }
            $printer->text("--------------------------------\n");

            // Summary table
            $printer->text(sprintf("الإجمالي: %-20.2f\n", $billData['summary']['subtotal'] ?? 0));
            $printer->text(sprintf("الضريبة: %-20.2f\n", $billData['summary']['tax_amount'] ?? 0));
            $printer->text(sprintf("الخدمة: %-20.2f\n", $billData['summary']['delivery_fee'] ?? 0));
            $printer->text(sprintf("الخصم: %-20.2f\n", $billData['summary']['discount'] ?? 0));
            $printer->text(sprintf("الحد الأدنى: %-20.2f\n", $billData['summary']['minimum'] ?? 0));
            $printer->text(sprintf("الصافي: %-20.2f\n", $billData['summary']['total_amount'] ?? 0));
            $printer->setEmphasis(false); // Unbold
            $printer->feed(2);

            $printer->text("--------------------------------\n");

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("شكراً لتعاملكم معنا!\n");

            // Add QR Code
            $printer->qrCode($billData['project_link']);

            // Cut the paper
            $printer->cut();

        } catch (Exception $e) {
            // Log the error or return a response
            if (request('fromJs')) {
                return response()->json([
                    'success' => false , 
                    "error" => $e->getMessage(),
                ]);
            }
            return "Couldn't print to this printer: " . $e->getMessage() . "\n";
        } finally {
            // Close the connection
            if (isset($printer)) {
                $printer->close();
            }
        }

        // #endregion
        if (request()->has('fromJs')) {
            return response()->json(
                [
                    'success' => true,
                    'bill' => $bill,
                ]
            );
        }

        return redirect()->route('bills.show', $bill->id);
    }


    public function directPrint()
    {
        try {
            // Enter the IP address of your printer
            $connector = new NetworkPrintConnector("192.168.1.100", 9100);

            // Make the printer object
            $printer = new Printer($connector);

            // --- Start Printing ---
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("أهلاً بكم في متجرنا\n");
            $printer->feed(); // New line

            $printer->setJustification(Printer::JUSTIFY_RIGHT); // Align right for Arabic
            $printer->text("فاتورة رقم: 123\n");
            $printer->text("--------------------------------\n");
            $printer->text("الصنف    الكمية    السعر\n");
            $printer->text("--------------------------------\n");

            // Add items from your database
            $printer->text("خبز      2        4.00\n");
            $printer->text("بيبسي    1        8.00\n");

            $printer->feed();
            $printer->setEmphasis(true); // Bold
            $printer->text("الإجمالي: 12.00 جنيه\n");
            $printer->setEmphasis(false); // Unbold
            $printer->feed(2);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("شكراً لزيارتكم!\n");

            // Add QR Code
            $printer->qrCode("https://your-website.com");

            // Cut the paper
            $printer->cut();

        } catch (Exception $e) {
            // Log the error or return a response
            return "Couldn't print to this printer: " . $e->getMessage() . "\n";
        } finally {
            // Close the connection
            if (isset($printer)) {
                $printer->close();
            }
        }

        return "Print job sent successfully!";
    }

    public function show($id)
    {
        $bill = Bill::with('order.client')->findOrFail($id);
        $billData = json_decode($bill->bill_data, true);
        return view('bills.show', compact('bill', 'billData'));
    }
}
