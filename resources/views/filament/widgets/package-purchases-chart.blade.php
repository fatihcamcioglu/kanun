@php
    $data = $this->getViewData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="fi-section-content-ctn">
            <h3 class="text-lg font-semibold mb-4">Satın Alınan Paket Miktarı</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="packagePurchasesChart-{{ $this->getId() }}"></canvas>
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
            const ctx = document.getElementById('packagePurchasesChart-{{ $this->getId() }}');
            if (ctx && typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($data['labels']),
                        datasets: [{
                            label: 'Paket Satışı',
                            data: @json($data['data']),
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
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
                            }
                        },
                        scales: {
                            y: {
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

