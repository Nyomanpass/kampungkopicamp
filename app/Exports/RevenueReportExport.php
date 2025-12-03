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
    protected $month;
    protected $year;

    public function __construct($topProducts, $metrics, $startDate, $endDate, $month = null, $year = null)
    {
        $this->topProducts = $topProducts;
        $this->metrics = $metrics;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        $data = collect();

        // Add Summary Section
        $data->push(['LAPORAN PENDAPATAN']);
        if ($this->month && $this->year) {
            $data->push(['Periode:', $this->month . ' ' . $this->year]);
        }
        $data->push(['Tanggal:', \Carbon\Carbon::parse($this->startDate)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($this->endDate)->format('d M Y')]);
        $data->push(['Dibuat:', now()->format('d M Y H:i:s')]);
        $data->push(['']);

        // Metrics
        $data->push(['RINGKASAN']);
        $data->push(['Total Pendapatan', 'Rp ' . number_format($this->metrics['totalRevenue'])]);
        $data->push(['Total Transaksi', number_format($this->metrics['totalTransactions'])]);
        $data->push(['Rata-rata Nilai Transaksi', 'Rp ' . number_format($this->metrics['averageTransactionValue'])]);
        $data->push(['Total Refund', 'Rp ' . number_format($this->metrics['totalRefunded'])]);
        $data->push(['Pendapatan Bersih', 'Rp ' . number_format($this->metrics['netRevenue'])]);
        $data->push(['']);

        // Top Products Header
        $data->push(['PRODUK TERATAS BERDASARKAN PENDAPATAN']);
        $data->push(['#', 'Nama Produk', 'Tipe', 'Jumlah Booking', 'Qty Terjual', 'Total Pendapatan']);

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
        if ($this->month && $this->year) {
            return 'Laporan ' . $this->month . ' ' . $this->year;
        }
        return 'Laporan Pendapatan';
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
