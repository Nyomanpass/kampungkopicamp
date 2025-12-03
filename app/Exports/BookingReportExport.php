<?php
// filepath: app/Exports/BookingReportExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BookingReportExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
      protected $topProducts;
      protected $statusBreakdown;
      protected $metrics;
      protected $startDate;
      protected $endDate;
      protected $month;
      protected $year;

      public function __construct($topProducts, $statusBreakdown, $metrics, $startDate, $endDate, $month = null, $year = null)
      {
            $this->topProducts = $topProducts;
            $this->statusBreakdown = $statusBreakdown;
            $this->metrics = $metrics;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
            $this->month = $month;
            $this->year = $year;
      }

      public function collection()
      {
            $data = collect();

            // Summary
            $data->push(['LAPORAN BOOKING']);
            if ($this->month && $this->year) {
                  $data->push(['Periode:', $this->month . ' ' . $this->year]);
            } else {
                  $data->push(['Periode:', \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y')]);
            }
            $data->push(['Dibuat:', now()->format('d M Y H:i:s')]);
            $data->push(['']);

            // Metrics
            $data->push(['METRIK']);
            $data->push(['Total Booking', number_format($this->metrics['totalBookings'])]);
            $data->push(['Booking Selesai', number_format($this->metrics['completedBookings'])]);
            $data->push(['Booking Dibatalkan', number_format($this->metrics['cancelledBookings'])]);
            $data->push(['Tingkat Konversi', number_format($this->metrics['conversionRate'], 1) . '%']);
            $data->push(['Nilai Rata-Rata Booking', 'Rp ' . number_format($this->metrics['averageBookingValue'])]);
            $data->push(['No-Show Rate', number_format($this->metrics['noShowRate'], 1) . '%']);
            $data->push(['']);

            // Top Products
            $data->push(['PRODUK TERPOPULER BERDASARKAN BOOKING']);
            $data->push(['#', 'Nama Produk', 'Tipe', 'Jumlah Booking', 'Qty Terjual']);

            foreach ($this->topProducts as $index => $product) {
                  $data->push([
                        $index + 1,
                        $product->name,
                        ucfirst($product->type),
                        $product->bookings_count,
                        $product->total_qty,
                  ]);
            }

            $data->push(['']);

            // Status Breakdown
            $data->push(['RINCIAN STATUS BOOKING']);
            $data->push(['Status', 'Jumlah', 'Total Nilai']);

            foreach ($this->statusBreakdown as $status) {
                  $statusLabels = [
                        'draft' => 'Draft',
                        'pending_payment' => 'Menunggu Pembayaran',
                        'paid' => 'Dibayar',
                        'checked_in' => 'Check In',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        'refunded' => 'Dikembalikan',
                        'no_show' => 'Tidak Hadir',
                        'expired' => 'Kedaluwarsa',
                  ];
                  $data->push([
                        $statusLabels[$status->status] ?? ucfirst(str_replace('_', ' ', $status->status)),
                        $status->count,
                        'Rp ' . number_format($status->total_value),
                  ]);
            }

            return $data;
      }

      public function headings(): array
      {
            return [];
      }

      public function styles(Worksheet $sheet)
      {
            return [
                  1 => [
                        'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F46E5']],
                  ],
                  5 => ['font' => ['bold' => true, 'size' => 14]],
                  14 => [
                        'font' => ['bold' => true],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E5E7EB']],
                  ],
            ];
      }

      public function title(): string
      {
            if ($this->month && $this->year) {
                  return 'Laporan ' . $this->month . ' ' . $this->year;
            }
            return 'Laporan Booking';
      }

      public function columnWidths(): array
      {
            return [
                  'A' => 8,
                  'B' => 30,
                  'C' => 15,
                  'D' => 15,
                  'E' => 15,
            ];
      }
}
