<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use App\Enums\OrderStatuses;
use DB;
use Carbon\Carbon;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue per day';

    protected static ?int $sort = 3;

    protected static string $color = 'success';

    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        if(!auth()->user()->hasRole('super_admin')) {
            $order_stats = Order::select(
                DB::raw("(sum(amount)) as total_amount"),
                DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as created_date")
                )
                ->where('status', '<>', OrderStatuses::Canceled)
                ->where('created_at', '>=', Carbon::today()->subDays(7))
                ->where('store_id', auth()->user()->store_id)
                ->orderBy('created_at')
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
                ->get();
        } else {
            $order_stats = Order::select(
                DB::raw("(sum(amount)) as total_amount"),
                DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as created_date")
                )
                ->where('status', '<>', OrderStatuses::Canceled)
                ->where('created_at', '>=', Carbon::today()->subDays(7))
                ->orderBy('created_at')
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
                ->get();
        }

        $data = [];
        $labels = [];
        foreach($order_stats as $stat) {
            $data[] = $stat['total_amount'];
            $labels[] = $stat['created_date'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue created',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
