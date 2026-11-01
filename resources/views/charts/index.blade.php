<x-mainpage>
    <h1>Tanulmányi diagram</h1>

    <p>
        A diagram az adatbázisban szereplő jegyek alapján
        mutatja az egyes tantárgyak átlagát.
    </p>

    @if ($labels->isEmpty())
        <p>Még nincs elegendő adat a diagram megjelenítéséhez.</p>
    @else
        <div style="max-width: 900px; margin: 0 auto;">
            <canvas id="gradeChart"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>

        <script>
            const labels = @json($labels);
            const averages = @json($averages);

            const ctx = document.getElementById('gradeChart');

            new Chart(ctx, {
                type: 'bar',

                data: {
                    labels: labels,

                    datasets: [{
                        label: 'Átlagos osztályzat',
                        data: averages,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,

                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: 5,
                            ticks: {
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: 'Átlag'
                            }
                        },

                        x: {
                            title: {
                                display: true,
                                text: 'Tantárgy'
                            }
                        }
                    },

                    plugins: {
                        legend: {
                            display: true
                        },

                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Átlag: ' + context.raw;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endif
</x-mainpage>