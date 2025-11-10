<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FinancialReportExport implements WithMultipleSheets
{
      protected $recentInvoices;
      protected $recentPayments;
      protected $metrics;
      protected $startDate;
      protected $endDate;

      public function __construct($recentInvoices, $recentPayments, $metrics, $startDate, $endDate)
      {
            $this->recentInvoices = $recentInvoices;
            $this->recentPayments = $recentPayments;
            $this->metrics = $metrics;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
      }

      public function sheets(): array
      {
            return [
                  new FinancialSummarySheet($this->metrics, $this->startDate, $this->endDate),
                  new FinancialInvoicesSheet($this->recentInvoices),
                  new FinancialPaymentsSheet($this->recentPayments),
            ];
      }
}

// Summary Sheet
class FinancialSummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
      protected $metrics;
      protected $startDate;
      protected $endDate;

      public function __construct($metrics, $startDate, $endDate)
      {
            $this->metrics = $metrics;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
      }

      public function collection()
      {
            return collect([
                  ['FINANCIAL REPORT SUMMARY'],
                  ['Period', \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y')],
                  ['Generated', now()->format('d M Y H:i:s')],
                  [''],
                  ['METRICS', ''],
                  ['Total Invoices', number_format($this->metrics['totalInvoices'])],
                  ['Total Revenue', 'Rp ' . number_format($this->metrics['totalRevenue'], 0, ',', '.')],
                  ['Total Paid', 'Rp ' . number_format($this->metrics['totalPaid'], 0, ',', '.')],
                  ['Total Pending', 'Rp ' . number_format($this->metrics['totalPending'], 0, ',', '.')],
                  ['Total Refunded', 'Rp ' . number_format($this->metrics['totalRefunded'], 0, ',', '.')],
                  ['Total Tax', 'Rp ' . number_format($this->metrics['totalTax'], 0, ',', '.')],
                  [''],
                  ['NET REVENUE', 'Rp ' . number_format($this->metrics['totalRevenue'] - $this->metrics['totalRefunded'], 0, ',', '.')],
            ]);
      }

      public function headings(): array
      {
            return [];
      }

      public function styles(Worksheet $sheet)
      {
            return [
                  1 => [
                        'font' => ['bold' => true, 'size' => 18, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5b7042']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                  ],
                  2 => ['font' => ['italic' => true, 'color' => ['rgb' => '666666']]],
                  3 => ['font' => ['italic' => true, 'color' => ['rgb' => '666666'], 'size' => 9]],
                  5 => [
                        'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '8ca67a']],
                  ],
                  'A6:A11' => ['font' => ['bold' => true]],
                  13 => [
                        'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5b7042']],
                  ],
            ];
      }

      public function title(): string
      {
            return 'Summary';
      }

      public function columnWidths(): array
      {
            return [
                  'A' => 25,
                  'B' => 25,
            ];
      }
}

// Invoices Sheet
class FinancialInvoicesSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
      protected $invoices;

      public function __construct($invoices)
      {
            $this->invoices = $invoices;
      }

      public function collection()
      {
            $data = collect();

            foreach ($this->invoices as $invoice) {
                  $data->push([
                        $invoice->invoice_number,
                        $invoice->booking?->customer_name ?? 'N/A',
                        $invoice->booking?->customer_email ?? '-',
                        'Rp ' . number_format($invoice->amount, 0, ',', '.'),
                        ucfirst($invoice->status),
                        ucfirst(str_replace('_', ' ', $invoice->type)),
                        $invoice->created_at->format('d M Y H:i'),
                  ]);
            }

            return $data;
      }

      public function headings(): array
      {
            return [
                  'Invoice Number',
                  'Customer',
                  'Email',
                  'Amount',
                  'Status',
                  'Type',
                  'Date',
            ];
      }

      public function styles(Worksheet $sheet)
      {
            return [
                  1 => [
                        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5b7042']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                  ],
            ];
      }

      public function title(): string
      {
            return 'Recent Invoices';
      }

      public function columnWidths(): array
      {
            return [
                  'A' => 18,
                  'B' => 25,
                  'C' => 30,
                  'D' => 18,
                  'E' => 12,
                  'F' => 15,
                  'G' => 18,
            ];
      }
}

// Payments Sheet
class FinancialPaymentsSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
      protected $payments;

      public function __construct($payments)
      {
            $this->payments = $payments;
      }

      public function collection()
      {
            $data = collect();

            foreach ($this->payments as $payment) {
                  $data->push([
                        $payment->order_id,
                        $payment->booking?->customer_name ?? 'N/A',
                        $payment->booking?->customer_email ?? '-',
                        'Rp ' . number_format($payment->amount, 0, ',', '.'),
                        strtoupper($payment->provider),
                        ucfirst($payment->status),
                        $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') : '-',
                  ]);
            }

            return $data;
      }

      public function headings(): array
      {
            return [
                  'Order ID',
                  'Customer',
                  'Email',
                  'Amount',
                  'Provider',
                  'Status',
                  'Paid At',
            ];
      }

      public function styles(Worksheet $sheet)
      {
            return [
                  1 => [
                        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '5b7042']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                  ],
            ];
      }

      public function title(): string
      {
            return 'Recent Payments';
      }

      public function columnWidths(): array
      {
            return [
                  'A' => 20,
                  'B' => 25,
                  'C' => 30,
                  'D' => 18,
                  'E' => 15,
                  'F' => 12,
                  'G' => 18,
            ];
      }
}
