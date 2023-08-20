<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue per day';

    protected static ?int $sort = 3;

    protected static string $color = 'success';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Revenue created',
                    'data' => [32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
