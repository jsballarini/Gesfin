<?php
// Configuração dos meses para a navegação
$meses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];
?>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
        
        <!-- Navegação de Competência -->
        <div class="flex items-center bg-white rounded shadow-sm border border-slate-200 p-1">
            <?php 
                $prevMonth = $month - 1; $prevYear = $year;
                if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
                
                $nextMonth = $month + 1; $nextYear = $year;
                if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
            ?>
            <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="p-1 hover:bg-slate-100 rounded text-slate-500">
                <i class='bx bx-chevron-left text-xl'></i>
            </a>
            <span class="px-4 font-medium text-slate-700 min-w-[140px] text-center">
                <?= $meses[(int)$month] ?> <?= $year ?>
            </span>
            <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="p-1 hover:bg-slate-100 rounded text-slate-500">
                <i class='bx bx-chevron-right text-xl'></i>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4 md:gap-6">
    
    <!-- Card Entradas -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-success">
            <i class='bx bx-trending-up text-2xl'></i>
        </div>
        <div class="mt-5 flex items-end justify-between">
            <div>
                <span class="text-sm font-medium text-slate-500">Entradas do Mês</span>
                <h4 class="mt-1 text-2xl font-bold text-slate-800">
                    R$ <?= number_format($stats['total_income'], 2, ',', '.') ?>
                </h4>
            </div>
        </div>
    </div>

    <!-- Card Saídas -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-danger">
            <i class='bx bx-trending-down text-2xl'></i>
        </div>
        <div class="mt-5 flex items-end justify-between">
            <div>
                <span class="text-sm font-medium text-slate-500">Saídas do Mês</span>
                <h4 class="mt-1 text-2xl font-bold text-slate-800">
                    R$ <?= number_format($stats['total_expense'], 2, ',', '.') ?>
                </h4>
            </div>
        </div>
    </div>

    <!-- Card Saldo Realizado -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-primary">
            <i class='bx bx-wallet-alt text-2xl'></i>
        </div>
        <div class="mt-5 flex items-end justify-between">
            <div>
                <span class="text-sm font-medium text-slate-500">Saldo Realizado (Pagos)</span>
                <h4 class="mt-1 text-2xl font-bold <?= $stats['realized_balance'] >= 0 ? 'text-slate-800' : 'text-danger' ?>">
                    R$ <?= number_format($stats['realized_balance'], 2, ',', '.') ?>
                </h4>
            </div>
        </div>
    </div>

    <!-- Card Saldo Projetado -->
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-warning">
            <i class='bx bx-line-chart text-2xl'></i>
        </div>
        <div class="mt-5 flex items-end justify-between">
            <div>
                <span class="text-sm font-medium text-slate-500">Saldo Projetado</span>
                <h4 class="mt-1 text-2xl font-bold <?= $stats['projected_balance'] >= 0 ? 'text-slate-800' : 'text-danger' ?>">
                    R$ <?= number_format($stats['projected_balance'], 2, ',', '.') ?>
                </h4>
            </div>
        </div>
    </div>

</div>

<!-- Gráfico Previsto x Realizado -->
<div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-4 flex justify-between items-center">
        <div>
            <h4 class="text-xl font-semibold text-slate-800">
                Evolução Financeira (12 meses)
            </h4>
            <span class="text-sm font-medium text-slate-500">A partir de <?= $meses[(int)$month] ?> <?= $year ?></span>
        </div>
    </div>
    <div id="chartOne" class="-ml-5"></div>
</div>

<!-- Listagem Resumida -->
<div class="mt-8 rounded-xl border border-slate-200 bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7 xl:pb-1">
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-xl font-semibold text-slate-800">
            Lançamentos Recentes
        </h4>
        <a href="/entries?month=<?= $month ?>&year=<?= $year ?>" class="text-sm text-primary hover:underline font-medium">Ver todos</a>
    </div>

    <div class="flex flex-col">
        <div class="grid grid-cols-3 rounded-sm bg-slate-100 sm:grid-cols-4">
            <div class="p-2.5 xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Descrição</h5></div>
            <div class="p-2.5 text-center xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Valor</h5></div>
            <div class="p-2.5 text-center xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Vencimento</h5></div>
            <div class="hidden p-2.5 text-center sm:block xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Status</h5></div>
        </div>

        <?php if(empty($recentEntries)): ?>
            <div class="p-5 text-center text-slate-500 border-b border-slate-100">
                Nenhum lançamento encontrado para este mês.
            </div>
        <?php else: ?>
            <?php foreach($recentEntries as $entry): ?>
                <div class="grid grid-cols-3 border-b border-slate-100 sm:grid-cols-4 hover:bg-slate-50 transition">
                    <div class="flex items-center gap-3 p-2.5 xl:p-5">
                        <p class="text-black font-medium"><?= htmlspecialchars($entry['description']) ?></p>
                    </div>
                    <div class="flex items-center justify-center p-2.5 xl:p-5">
                        <p class="font-medium <?= $entry['category_type'] === 'income' ? 'text-success' : 'text-danger' ?>">
                            <?= $entry['category_type'] === 'income' ? '+' : '-' ?> R$ <?= number_format($entry['amount'], 2, ',', '.') ?>
                        </p>
                    </div>
                    <div class="flex items-center justify-center p-2.5 xl:p-5">
                        <p class="text-slate-600 text-sm"><?= date('d/m/Y', strtotime($entry['due_date'])) ?></p>
                    </div>
                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                        <?php if($entry['status'] === 'paid'): ?>
                            <span class="inline-flex rounded-full bg-green-100 py-1 px-3 text-sm font-medium text-green-700">Pago</span>
                        <?php else: ?>
                            <span class="inline-flex rounded-full bg-slate-100 py-1 px-3 text-sm font-medium text-slate-500">Pendente</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = <?= json_encode($chartData) ?>;
    
    const chartOptions = {
        series: [
            {
                name: 'Saldo Projetado',
                data: chartData.projected
            },
            {
                name: 'Saldo Realizado',
                data: chartData.realized
            }
        ],
        chart: {
            fontFamily: 'Satoshi, sans-serif',
            height: 335,
            type: 'area',
            toolbar: {
                show: false
            }
        },
        colors: ['#FFA70B', '#3C50E0'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [2, 2],
            curve: 'smooth'
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: chartData.labels,
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            title: {
                style: {
                    fontSize: '0px'
                }
            },
            labels: {
                formatter: function (value) {
                    return "R$ " + value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right'
        },
        tooltip: {
            theme: 'light',
            y: {
                formatter: function (value) {
                    return "R$ " + value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
            }
        }
    };

    const chartSelector = document.querySelector('#chartOne');
    
    if (chartSelector) {
        const chartOne = new ApexCharts(chartSelector, chartOptions);
        chartOne.render();
    }
});
</script>