<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-slate-800">
        Categorias
    </h2>

    <button onclick="openModal('modalCategory')" class="flex items-center gap-2 rounded bg-primary py-2 px-4 font-medium text-white hover:bg-opacity-90">
        <i class='bx bx-plus text-xl'></i>
        Nova Categoria
    </button>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-4 rounded-md bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class='bx bx-check-circle text-green-500 text-xl'></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class='bx bx-x-circle text-red-500 text-xl'></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </p>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6">Nome</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6">Tipo</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6">Status</th>
                    <th class="py-4 px-4 font-medium text-slate-600 xl:px-6 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr class="border-b border-slate-200">
                    <td class="py-4 px-4 xl:px-6">
                        <p class="text-slate-800 font-medium"><?php echo htmlspecialchars($cat['name']); ?></p>
                    </td>
                    <td class="py-4 px-4 xl:px-6">
                        <?php if ($cat['type'] === 'income'): ?>
                            <p class="inline-flex rounded-full bg-green-100 py-1 px-3 text-sm font-medium text-green-700">Entrada</p>
                        <?php else: ?>
                            <p class="inline-flex rounded-full bg-red-100 py-1 px-3 text-sm font-medium text-red-700">Saída</p>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 xl:px-6">
                        <?php if ($cat['is_active']): ?>
                            <p class="inline-flex rounded-full bg-blue-100 py-1 px-3 text-sm font-medium text-blue-700">Ativa</p>
                        <?php else: ?>
                            <p class="inline-flex rounded-full bg-slate-100 py-1 px-3 text-sm font-medium text-slate-500">Inativa</p>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 xl:px-6 text-center">
                        <button onclick='editCategory(<?php echo json_encode($cat); ?>)' class="text-slate-500 hover:text-primary transition-colors">
                            <i class='bx bx-edit text-xl'></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Overlay -->
<div id="modalCategory" class="fixed inset-0 z-99999 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity">
    
    <!-- Modal Content -->
    <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-default mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800" id="modalTitle">Nova Categoria</h3>
            <button onclick="closeModal('modalCategory')" class="text-slate-500 hover:text-slate-800">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <form id="formCategory" action="/categories/store" method="POST">
            <input type="hidden" name="id" id="cat_id" value="">
            
            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-slate-800">Nome</label>
                <input type="text" name="name" id="cat_name" required placeholder="Ex: Salário" class="w-full rounded border border-slate-300 bg-transparent py-3 px-4 outline-none focus:border-primary focus-visible:shadow-none">
            </div>

            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-slate-800">Tipo</label>
                <div class="relative z-20 bg-transparent">
                    <select name="type" id="cat_type" required class="relative z-20 w-full appearance-none rounded border border-slate-300 bg-transparent py-3 px-4 outline-none transition focus:border-primary">
                        <option value="income">Entrada (+)</option>
                        <option value="expense">Saída (-)</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active" id="cat_active" class="sr-only" checked>
                        <div class="block h-8 w-14 rounded-full bg-slate-300 transition" id="toggleBg"></div>
                        <div class="dot absolute left-1 top-1 h-6 w-6 rounded-full bg-white transition" id="toggleDot"></div>
                    </div>
                    <span class="ml-3 font-medium text-slate-800">Ativa</span>
                </label>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalCategory')" class="rounded border border-slate-300 py-2 px-6 font-medium text-slate-700 hover:bg-slate-50 transition">
                    Cancelar
                </button>
                <button type="submit" class="rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90 transition">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Toggle switch styles */
    input:checked ~ #toggleBg {
        background-color: #3C50E0;
    }
    input:checked ~ #toggleDot {
        transform: translateX(100%);
    }
</style>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
        
        // Reset form on close
        document.getElementById('formCategory').reset();
        document.getElementById('formCategory').action = '/categories/store';
        document.getElementById('modalTitle').innerText = 'Nova Categoria';
        document.getElementById('cat_id').value = '';
        document.getElementById('cat_active').checked = true;
    }

    function editCategory(cat) {
        document.getElementById('formCategory').action = '/categories/update';
        document.getElementById('modalTitle').innerText = 'Editar Categoria';
        
        document.getElementById('cat_id').value = cat.id;
        document.getElementById('cat_name').value = cat.name;
        document.getElementById('cat_type').value = cat.type;
        document.getElementById('cat_active').checked = cat.is_active == 1;
        
        openModal('modalCategory');
    }
</script>