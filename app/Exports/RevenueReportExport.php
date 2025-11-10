<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class RevenueReportExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $topProducts;
    protected $metrics;
    protected $startDate;
    protected $endDate;

    public function __construct($topProducts, $metrics, $startDate, $endDate)
    {
        $this->topProducts = $topProducts;
        $this->metrics = $metrics;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $data = collect();

        // Add Summary Section
        $data->push(['REVENUE REPORT SUMMARY']);
        $data->push(['Period:', \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y')]);
        $data->push(['Generated:', now()->format('d M Y H:i:s')]);
        $data->push(['']);

        // Metrics
        $data->push(['METRICS']);
        $data->push(['Total Revenue', 'Rp ' . number_format($this->metrics['totalRevenue'])]);
        $data->push(['Total Transactions', number_format($this->metrics['totalTransactions'])]);
        $data->push(['Average Transaction Value', 'Rp ' . number_format($this->metrics['averageTransactionValue'])]);
        $data->push(['Total Refunded', 'Rp ' . number_format($this->metrics['totalRefunded'])]);
        $data->push(['Net Revenue', 'Rp ' . number_format($this->metrics['netRevenue'])]);
        $data->push(['']);

        // Top Products Header
        $data->push(['TOP PRODUCTS BY REVENUE']);
        $data->push(['#', 'Product Name', 'Type', 'Bookings', 'Qty Sold', 'Total Revenue']);

        // Top Products Data
        foreach ($this->topProducts as $index => $product) {
            $data->push([
                $index + 1,
                $product->name,
                ucfirst($product->type),
                $product->bookings_count,
                $product->total_qty,
                'Rp ' . number_format($product->total_revenue),
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
                'font' => [
                    'bold' => true,
                    'size' => 16,
                    'color' => ['rgb' => 'FFFFFF'],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F46E5']],
                ],
            ],
            5 => ['font' => ['bold' => true, 'size' => 14]],
            13 => ['font' => ['bold' => true, 'size' => 14]],
            14 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E5E7EB']],
            ],
        ];
    }

    public function title(): string
    {
        return 'Revenue Report';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 30,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 20,
        ];
    }
}
