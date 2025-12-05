@php
    $data = $this->getViewData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="fi-section-content-ctn">
            <h3 class="text-lg font-semibold mb-4">Avukat Performansı (Son 30 Gün)</h3>
            <div class="relative" style="height: 400px;">
                <canvas id="lawyerPerformanceChart-{{ $this->getId() }}"></canvas>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

@push('scripts')
    @if(!isset($chartJsLoaded))
        @php $chartJsLoaded = true; @endphp
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('lawyerPerformanceChart-{{ $this->getId() }}');
            if (ctx && typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($data['labels']),
                        datasets: [{
                            label: 'Cevaplanan Soru Sayısı',
                            data: @json($data['data']),
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.5)',
                                'rgba(59, 130, 246, 0.5)',
                                'rgba(168, 85, 247, 0.5)',
                                'rgba(236, 72, 153, 0.5)',
                                'rgba(251, 191, 36, 0.5)',
                                'rgba(249, 115, 22, 0.5)',
                                'rgba(239, 68, 68, 0.5)',
                                'rgba(107, 114, 128, 0.5)',
                                'rgba(20, 184, 166, 0.5)',
                                'rgba(139, 92, 246, 0.5)',
                            ],
                            borderColor: [
                                'rgb(34, 197, 94)',
                                'rgb(59, 130, 246)',
                                'rgb(168, 85, 247)',
                                'rgb(236, 72, 153)',
                                'rgb(251, 191, 36)',
                                'rgb(249, 115, 22)',
                                'rgb(239, 68, 68)',
                                'rgb(107, 114, 128)',
                                'rgb(20, 184, 166)',
                                'rgb(139, 92, 246)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush

