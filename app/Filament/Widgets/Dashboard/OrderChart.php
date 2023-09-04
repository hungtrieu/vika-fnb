<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use App\Enums\OrderStatuses;
use DB;
use Carbon\Carbon;

class OrderChart extends ChartWidget
{
    protected static ?string $heading;
    
    protected static ?int $sort = 2;

    protected static string $color = 'info';

    protected static ?string $pollingInterval = null;

    public function __construct() {
        self::$heading = __('Order per day');
    }

    protected function getData(): array
    {
        if(!auth()->user()->hasRole('super_admin')) {
            $order_stats = Order::select(
                DB::raw("(count(id)) as total_orders"),
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
                DB::raw("(count(id)) as total_orders"),
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
            $data[] = $stat['total_orders'];
            $labels[] = $stat['created_date'];
        }

        return [
            'datasets' => [
                [
                    'label' => __('Order created'),
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
