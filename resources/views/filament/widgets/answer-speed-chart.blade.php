@php
    $data = $this->getViewData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="fi-section-content-ctn">
            <h3 class="text-lg font-semibold mb-4">Cevaplanma Hızları (Ortalama Saat)</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="answerSpeedChart-{{ $this->getId() }}"></canvas>
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
            const ctx = document.getElementById('answerSpeedChart-{{ $this->getId() }}');
            if (ctx && typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($data['labels']),
                        datasets: [{
                            label: 'Ortalama Cevaplanma Süresi (Saat)',
                            data: @json($data['data']),
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
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
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.y;
                                        if (value === 0) {
                                            return 'Veri yok';
                                        }
                                        const hours = Math.floor(value);
                                        const minutes = Math.round((value - hours) * 60);
                                        if (hours > 0) {
                                            return hours + ' saat ' + (minutes > 0 ? minutes + ' dakika' : '');
                                        } else {
                                            return minutes + ' dakika';
                                        }
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Saat'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush

