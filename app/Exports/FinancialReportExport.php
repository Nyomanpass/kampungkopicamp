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
      protected $month;
      protected $year;

      public function __construct($recentInvoices, $recentPayments, $metrics, $startDate, $endDate, $month = null, $year = null)
      {
            $this->recentInvoices = $recentInvoices;
            $this->recentPayments = $recentPayments;
            $this->metrics = $metrics;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
            $this->month = $month;
            $this->year = $year;
      }

      public function sheets(): array
      {
            return [
                  new FinancialSummarySheet($this->metrics, $this->startDate, $this->endDate, $this->month, $this->year),
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
      protected $month;
      protected $year;

      public function __construct($metrics, $startDate, $endDate, $month = null, $year = null)
      {
            $this->metrics = $metrics;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
            $this->month = $month;
            $this->year = $year;
      }

      public function collection()
      {
            return collect([
                  ['LAPORAN KEUANGAN'],
                  ['Periode', $this->month && $this->year ? $this->month . ' ' . $this->year : \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y')],
                  ['Dibuat', now()->format('d M Y H:i:s')],
                  [''],
                  ['METRIK', ''],
                  ['Total Invoice', number_format($this->metrics['totalInvoices'])],
                  ['Total Pendapatan', 'Rp ' . number_format($this->metrics['totalRevenue'], 0, ',', '.')],
                  ['Total Dibayar', 'Rp ' . number_format($this->metrics['totalPaid'], 0, ',', '.')],
                  ['Total Menunggu', 'Rp ' . number_format($this->metrics['totalPending'], 0, ',', '.')],
                  ['Total Dikembalikan', 'Rp ' . number_format($this->metrics['totalRefunded'], 0, ',', '.')],
                  ['Total Pajak', 'Rp ' . number_format($this->metrics['totalTax'], 0, ',', '.')],
                  [''],
                  ['PENDAPATAN BERSIH', 'Rp ' . number_format($this->metrics['totalRevenue'] - $this->metrics['totalRefunded'], 0, ',', '.')],
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
            if ($this->month && $this->year) {
                  return 'Ringkasan ' . $this->month . ' ' . $this->year;
            }
            return 'Ringkasan';
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
                  'Nomor Invoice',
                  'Pelanggan',
                  'Email',
                  'Jumlah',
                  'Status',
                  'Tipe',
                  'Tanggal',
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
            return 'Invoice Terkini';
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
                  'Pelanggan',
                  'Email',
                  'Jumlah',
                  'Provider',
                  'Status',
                  'Dibayar Pada',
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
            return 'Pembayaran Terkini';
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
