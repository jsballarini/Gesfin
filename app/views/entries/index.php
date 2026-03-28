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
        <h2 class="text-2xl font-bold text-slate-800">Lançamentos</h2>
        
        <!-- Navegação de Competência -->
        <div class="flex items-center bg-white rounded shadow-sm border border-slate-200 p-1">
            <?php 
                $prevMonth = $month - 1; $prevYear = $year;
                if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
                
                $nextMonth = $month + 1; $nextYear = $year;
                if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }
                
                $queryParams = '';
                if (!empty($_GET['status'])) $queryParams .= '&status=' . urlencode($_GET['status']);
                if (!empty($_GET['search'])) $queryParams .= '&search=' . urlencode($_GET['search']);
            ?>
            <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?><?= $queryParams ?>" class="p-1 hover:bg-slate-100 rounded text-slate-500">
                <i class='bx bx-chevron-left text-xl'></i>
            </a>
            <span class="px-4 font-medium text-slate-700 min-w-[140px] text-center">
                <?= $meses[(int)$month] ?> <?= $year ?>
            </span>
            <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?><?= $queryParams ?>" class="p-1 hover:bg-slate-100 rounded text-slate-500">
                <i class='bx bx-chevron-right text-xl'></i>
            </a>
        </div>
    </div>

    <button onclick="openModal('modalEntry')" class="flex items-center gap-2 rounded bg-primary py-2 px-4 font-medium text-white hover:bg-opacity-90">
        <i class='bx bx-plus text-xl'></i>
        Novo Lançamento
    </button>
</div>

<!-- Filtros e Busca -->
<div class="mb-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <form action="/entries" method="GET" class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <input type="hidden" name="month" value="<?= $month ?>">
        <input type="hidden" name="year" value="<?= $year ?>">
        
        <div class="flex-1">
            <label class="mb-1 block text-sm font-medium text-slate-700">Buscar</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class='bx bx-search text-lg'></i>
                </span>
                <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Descrição ou observação..." class="w-full rounded border border-slate-300 bg-transparent py-2 pl-10 pr-4 outline-none focus:border-primary">
            </div>
        </div>

        <div class="w-full sm:w-48">
            <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
            <select name="status" class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary">
                <option value="">Todos</option>
                <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : '' ?>>Pendentes</option>
                <option value="paid" <?= (isset($_GET['status']) && $_GET['status'] === 'paid') ? 'selected' : '' ?>>Pagos</option>
            </select>
        </div>

        <button type="submit" class="rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90 transition">
            Filtrar
        </button>
        
        <?php if (!empty($_GET['search']) || !empty($_GET['status'])): ?>
            <a href="/entries?month=<?= $month ?>&year=<?= $year ?>" class="rounded border border-slate-300 bg-white py-2 px-4 font-medium text-slate-600 hover:bg-slate-50 transition text-center">
                Limpar
            </a>
        <?php endif; ?>
    </form>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <i class='bx bx-check-circle text-green-500 text-xl'></i>
            <p class="ml-3 text-sm font-medium text-green-800"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        </div>
    </div>
<?php endif; ?>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-slate-50 text-left border-b border-slate-200">
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6">Status</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6">Descrição</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6">Categoria</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6 text-right">Valor</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6 text-center">Vencimento</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($entries)): ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">Nenhum lançamento encontrado para esta competência.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($entries as $entry): ?>
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-3 px-4 xl:px-6">
                            <!-- Toggle Rápido de Status -->
                            <form action="/entries/toggle-status" method="POST" class="m-0">
                                <input type="hidden" name="id" value="<?= $entry['id'] ?>">
                                <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full transition-colors <?= $entry['status'] === 'paid' ? 'bg-green-100 text-green-600 hover:bg-green-200' : 'bg-slate-100 text-slate-400 hover:bg-slate-200' ?>" title="<?= $entry['status'] === 'paid' ? 'Marcar como Pendente' : 'Marcar como Pago' ?>">
                                    <i class='bx <?= $entry['status'] === 'paid' ? 'bx-check' : 'bx-time' ?> text-xl'></i>
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-4 xl:px-6">
                            <p class="text-slate-800 font-medium"><?= htmlspecialchars($entry['description']) ?></p>
                            <?php if(!empty($entry['notes'])): ?>
                                <p class="text-xs text-slate-400 truncate max-w-[200px]"><?= htmlspecialchars($entry['notes']) ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 xl:px-6">
                            <span class="text-sm text-slate-500"><?= htmlspecialchars($entry['category_name']) ?></span>
                        </td>
                        <td class="py-3 px-4 xl:px-6 text-right">
                            <p class="font-medium <?= $entry['category_type'] === 'income' ? 'text-success' : 'text-danger' ?>">
                                <?= $entry['category_type'] === 'income' ? '+' : '-' ?> R$ <?= number_format($entry['amount'], 2, ',', '.') ?>
                            </p>
                        </td>
                        <td class="py-3 px-4 xl:px-6 text-center">
                            <span class="text-sm text-slate-600"><?= date('d/m/Y', strtotime($entry['due_date'])) ?></span>
                        </td>
                        <td class="py-3 px-4 xl:px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick='editEntry(<?= json_encode($entry) ?>)' class="text-slate-400 hover:text-primary transition-colors" title="Editar">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>

                                <?php if ($entry['recurrence_group_id']): ?>
                                    <!-- Exclusão de Recorrência -->
                                    <div class="relative group inline-block">
                                        <button type="button" class="text-slate-400 hover:text-danger transition-colors focus:outline-none" title="Excluir">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                        <div class="absolute right-0 bottom-full mb-2 hidden w-48 rounded bg-white shadow-lg border border-slate-200 group-hover:block z-50">
                                            <div class="p-2 flex flex-col gap-1">
                                                <form action="/entries/delete" method="POST" onsubmit="return confirm('Excluir apenas este lançamento?');" class="m-0">
                                                    <input type="hidden" name="id" value="<?= $entry['id'] ?>">
                                                    <button type="submit" class="w-full text-left text-sm px-2 py-1.5 hover:bg-slate-100 rounded text-slate-700">Apenas este</button>
                                                </form>
                                                <form action="/entries/delete-future" method="POST" onsubmit="return confirm('Excluir este e todos os próximos lançamentos desta série?');" class="m-0">
                                                    <input type="hidden" name="id" value="<?= $entry['id'] ?>">
                                                    <button type="submit" class="w-full text-left text-sm px-2 py-1.5 hover:bg-slate-100 rounded text-danger">Este e próximos</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <!-- Exclusão Simples -->
                                    <form action="/entries/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este lançamento?');" class="m-0 inline">
                                        <input type="hidden" name="id" value="<?= $entry['id'] ?>">
                                        <button type="submit" class="text-slate-400 hover:text-danger transition-colors" title="Excluir">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Lançamento -->
<div id="modalEntry" class="fixed inset-0 z-99999 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity">
    <div class="w-full max-w-lg rounded-lg bg-white p-8 shadow-default mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800" id="modalTitle">Novo Lançamento</h3>
            <button onclick="closeModal('modalEntry')" class="text-slate-500 hover:text-slate-800">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <form id="formEntry" action="/entries/store" method="POST">
            <input type="hidden" name="id" id="entry_id" value="">
            
            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-slate-800">Descrição</label>
                <input type="text" name="description" id="entry_description" required class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="mb-2.5 block font-medium text-slate-800">Valor (R$)</label>
                    <input type="number" step="0.01" min="0.01" name="amount" id="entry_amount" required class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary">
                </div>
                <div>
                    <label class="mb-2.5 block font-medium text-slate-800">Vencimento</label>
                    <input type="date" name="due_date" id="entry_due_date" required class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="mb-2.5 block font-medium text-slate-800">Categoria</label>
                    <select name="category_id" id="entry_category_id" required class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary">
                        <option value="">Selecione...</option>
                        <?php foreach($activeCategories as $cat): ?>
                            <option value="<?= $cat['id'] ?>">
                                <?= $cat['type'] == 'income' ? '🟢' : '🔴' ?> <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="mb-2.5 block font-medium text-slate-800">Status</label>
                    <select name="status" id="entry_status" class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary">
                        <option value="pending">Pendente</option>
                        <option value="paid">Pago</option>
                    </select>
                </div>
            </div>

            <div class="mb-4" id="recurrence_section">
                <label class="flex items-center cursor-pointer mb-2">
                    <input type="checkbox" name="is_recurrent" id="is_recurrent" value="1" class="form-checkbox h-5 w-5 text-primary rounded border-slate-300" onchange="toggleRecurrenceMonths()">
                    <span class="ml-2 font-medium text-slate-800">Repetir lançamento (Recorrência)</span>
                </label>
                
                <div id="recurrence_months_container" class="hidden mt-2">
                    <label class="mb-2 block text-sm font-medium text-slate-600">Gerar por quantos meses?</label>
                    <select name="recurrence_months" id="recurrence_months" class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary">
                        <option value="2">2 meses</option>
                        <option value="3">3 meses</option>
                        <option value="6">6 meses</option>
                        <option value="12" selected>12 meses (1 ano)</option>
                        <option value="24">24 meses (2 anos)</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="mb-2.5 block font-medium text-slate-800">Observações (Opcional)</label>
                <textarea name="notes" id="entry_notes" rows="2" class="w-full rounded border border-slate-300 bg-transparent py-2 px-4 outline-none focus:border-primary"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalEntry')" class="rounded border border-slate-300 py-2 px-6 font-medium text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </button>
                <button type="submit" class="rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function toggleRecurrenceMonths() {
        const checkbox = document.getElementById('is_recurrent');
        const container = document.getElementById('recurrence_months_container');
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
        
        document.getElementById('formEntry').reset();
        document.getElementById('formEntry').action = '/entries/store';
        document.getElementById('modalTitle').innerText = 'Novo Lançamento';
        document.getElementById('entry_id').value = '';
        document.getElementById('recurrence_section').classList.remove('hidden');
        toggleRecurrenceMonths();
    }

    function editEntry(entry) {
        document.getElementById('formEntry').action = '/entries/update';
        document.getElementById('modalTitle').innerText = 'Editar Lançamento';
        
        document.getElementById('entry_id').value = entry.id;
        document.getElementById('entry_description').value = entry.description;
        document.getElementById('entry_amount').value = entry.amount;
        document.getElementById('entry_due_date').value = entry.due_date;
        document.getElementById('entry_category_id').value = entry.category_id;
        document.getElementById('entry_status').value = entry.status;
        document.getElementById('entry_notes').value = entry.notes || '';
        
        // Esconde a opção de criar recorrência ao editar um lançamento já existente
        document.getElementById('recurrence_section').classList.add('hidden');
        
        openModal('modalEntry');
    }
</script>