<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Enums\OrderStatuses;
use App\Helpers\VikaHelper;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $currency_symbol = config('app.currency_unit');

        $order_stats = $this->getOrderStats();

        return [
            Stat::make(__('Total orders'), $order_stats['total_orders']),
            Stat::make(__('Revenue'), VikaHelper::convertCurrency($order_stats['total_revenue'])),
            Stat::make(__('Average spending'),  VikaHelper::convertCurrency($order_stats['average_spending'])),
        ];
    }

    protected function getOrderStats() : array {
        $stats = [];

        $orders = Order::where('status', '<>', OrderStatuses::Canceled);

        if(!auth()->user()->hasRole('super_admin')) {
            $orders->where('store_id', auth()->user()->store_id);
        }

        $orders->get();

        $stats['total_orders'] = $orders->count();
        $stats['total_revenue'] = $orders->sum('amount');
        $stats['average_spending'] = round($stats['total_revenue'] / $stats['total_orders'], 2);

        return $stats;
    }
}
