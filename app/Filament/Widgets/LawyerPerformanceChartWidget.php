<?php

namespace App\Filament\Widgets;

use App\Models\LegalQuestion;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class LawyerPerformanceChartWidget extends Widget
{
    protected string $view = 'filament.widgets.lawyer-performance-chart';

    protected static ?int $sort = 7;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // Son 30 gün içinde cevaplanmış soruları say
        $lawyerStats = LegalQuestion::query()
            ->where('status', 'answered')
            ->whereNotNull('assigned_lawyer_id')
            ->whereNotNull('answered_at')
            ->where('answered_at', '>=', now()->subDays(30))
            ->select('assigned_lawyer_id', DB::raw('COUNT(*) as answered_count'))
            ->groupBy('assigned_lawyer_id')
            ->orderByDesc('answered_count')
            ->limit(10)
            ->get();

        $labels = [];
        $data = [];

        foreach ($lawyerStats as $stat) {
            $lawyer = User::find($stat->assigned_lawyer_id);
            if ($lawyer) {
                $labels[] = $lawyer->name;
                $data[] = (int) $stat->answered_count;
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}

