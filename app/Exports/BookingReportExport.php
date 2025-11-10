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

      public function __construct($topProducts, $statusBreakdown, $metrics, $startDate, $endDate)
      {
            $this->topProducts = $topProducts;
            $this->statusBreakdown = $statusBreakdown;
            $this->metrics = $metrics;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
      }

      public function collection()
      {
            $data = collect();

            // Summary
            $data->push(['BOOKING REPORT SUMMARY']);
            $data->push(['Period:', \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y')]);
            $data->push(['Generated:', now()->format('d M Y H:i:s')]);
            $data->push(['']);

            // Metrics
            $data->push(['METRICS']);
            $data->push(['Total Bookings', number_format($this->metrics['totalBookings'])]);
            $data->push(['Completed Bookings', number_format($this->metrics['completedBookings'])]);
            $data->push(['Cancelled Bookings', number_format($this->metrics['cancelledBookings'])]);
            $data->push(['Conversion Rate', number_format($this->metrics['conversionRate'], 1) . '%']);
            $data->push(['Average Booking Value', 'Rp ' . number_format($this->metrics['averageBookingValue'])]);
            $data->push(['No-Show Rate', number_format($this->metrics['noShowRate'], 1) . '%']);
            $data->push(['']);

            // Top Products
            $data->push(['TOP PRODUCTS BY BOOKINGS']);
            $data->push(['#', 'Product Name', 'Type', 'Bookings', 'Qty Sold']);

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
            $data->push(['BOOKING STATUS BREAKDOWN']);
            $data->push(['Status', 'Count', 'Total Value']);

            foreach ($this->statusBreakdown as $status) {
                  $data->push([
                        ucfirst(str_replace('_', ' ', $status->status)),
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
            return 'Booking Report';
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
