<?php

namespace App\Filament\Widgets;

use App\Models\LegalQuestion;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnswerSpeedChartWidget extends Widget
{
    protected string $view = 'filament.widgets.answer-speed-chart';

    protected static ?int $sort = 8;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // Son 30 gün içinde cevaplanmış soruların ortalama cevaplanma sürelerini hesapla
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $dailyData = LegalQuestion::query()
            ->where('status', 'answered')
            ->whereNotNull('asked_at')
            ->whereNotNull('answered_at')
            ->whereBetween('answered_at', [$startDate, $endDate])
            ->selectRaw('
                DATE(answered_at) as date,
                AVG(TIMESTAMPDIFF(HOUR, asked_at, answered_at)) as avg_hours
            ')
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
            
            if ($dailyData->has($dateKey)) {
                $avgHours = (float) $dailyData->get($dateKey)->avg_hours;
                // Saat cinsinden göster (ondalık kısım dakika olarak)
                $data[] = round($avgHours, 1);
            } else {
                $data[] = 0;
            }
            
            $currentDate->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}

