<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CustomerReportExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
      protected $topSpenders;
      protected $recentCustomers;
      protected $metrics;
      protected $startDate;
      protected $endDate;

      public function __construct($topSpenders, $recentCustomers, $metrics, $startDate, $endDate)
      {
            $this->topSpenders = $topSpenders;
            $this->recentCustomers = $recentCustomers;
            $this->metrics = $metrics;
            $this->startDate = $startDate;
            $this->endDate = $endDate;
      }

      public function collection()
      {
            $data = collect();

            // Summary
            $data->push(['CUSTOMER REPORT SUMMARY']);
            $data->push(['Period:', \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y')]);
            $data->push(['Generated:', now()->format('d M Y H:i:s')]);
            $data->push(['']);

            // Metrics
            $data->push(['METRICS']);
            $data->push(['Total Customers', number_format($this->metrics['totalCustomers'])]);
            $data->push(['New Customers', number_format($this->metrics['newCustomers'])]);
            $data->push(['Active Customers', number_format($this->metrics['activeCustomers'])]);
            $data->push(['Returning Customers', number_format($this->metrics['returningCustomers'])]);
            $data->push(['Retention Rate', number_format($this->metrics['customerRetentionRate'], 1) . '%']);
            $data->push(['Average Lifetime Value', 'Rp ' . number_format($this->metrics['averageLifetimeValue'])]);
            $data->push(['']);

            // Top Spenders
            $data->push(['TOP 10 SPENDERS']);
            $data->push(['#', 'Customer Name', 'Email', 'Total Bookings', 'Total Spent']);

            foreach ($this->topSpenders as $index => $customer) {
                  $data->push([
                        $index + 1,
                        $customer->name,
                        $customer->email,
                        $customer->total_bookings,
                        'Rp ' . number_format($customer->total_spent ?? 0),
                  ]);
            }

            $data->push(['']);

            // Recent Customers
            $data->push(['RECENT CUSTOMERS']);
            $data->push(['Customer Name', 'Email', 'Joined Date', 'Bookings', 'Total Spent']);

            foreach ($this->recentCustomers as $customer) {
                  $data->push([
                        $customer->name,
                        $customer->email,
                        $customer->created_at->format('d M Y'),
                        $customer->bookings_count,
                        'Rp ' . number_format($customer->total_spent ?? 0),
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
            return 'Customer Report';
      }

      public function columnWidths(): array
      {
            return [
                  'A' => 8,
                  'B' => 25,
                  'C' => 30,
                  'D' => 15,
                  'E' => 20,
            ];
      }
}
