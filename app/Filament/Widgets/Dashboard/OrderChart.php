<?php

namespace App\Filament\Widgets\Dashboard;

use Filament\Widgets\ChartWidget;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Order per day';
    
    protected static ?int $sort = 2;

    protected static string $color = 'info';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Order created',
                    'data' => [10, 5, 2, 21, 32, 45, 74],
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
