<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AdminChart extends ChartWidget
{
    protected static ?string $heading = 'Orders';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
         $orders = DB::table('orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

      
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $orders[$i] ?? 0; 
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders created',
                    'data' => $data,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
