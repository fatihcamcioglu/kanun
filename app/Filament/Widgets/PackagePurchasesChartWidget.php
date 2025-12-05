<?php

namespace App\Filament\Widgets;

use App\Models\CustomerPackageOrder;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class PackagePurchasesChartWidget extends Widget
{
    protected string $view = 'filament.widgets.package-purchases-chart';

    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // Son 30 günün verilerini al
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Günlük paket satış sayılarını hesapla (sadece ödenmiş paketler)
        $dailyData = CustomerPackageOrder::query()
            ->where('status', 'paid')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->selectRaw('DATE(paid_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Eksik günleri 0 ile doldur
        $labels = [];
        $data = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dateKey = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('d.m');
            $data[] = $dailyData->has($dateKey) ? (int) $dailyData->get($dateKey)->count : 0;
            $currentDate->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}

