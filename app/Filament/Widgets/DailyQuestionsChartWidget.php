<?php

namespace App\Filament\Widgets;

use App\Models\LegalQuestion;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class DailyQuestionsChartWidget extends Widget
{
    protected string $view = 'filament.widgets.daily-questions-chart';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // Son 30 günün verilerini al
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Günlük soru sayılarını hesapla
        $dailyData = LegalQuestion::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
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

