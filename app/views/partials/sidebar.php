<?php $currentUri = $_SERVER['REQUEST_URI'] ?? '/'; ?>
<aside id="sidebar" class="absolute left-0 top-0 z-9999 flex h-screen w-64 flex-col overflow-y-hidden border-r border-slate-200 bg-white duration-300 ease-linear lg:static lg:translate-x-0 -translate-x-full">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-6 lg:py-8">
        <a href="/dashboard" class="flex items-center gap-3">
            <div class="bg-primary rounded-lg p-1.5 flex items-center justify-center">
                <i class='bx bx-wallet text-2xl text-white'></i>
            </div>
            <span class="text-xl font-bold text-slate-800">Gesfin</span>
        </a>

        <button id="sidebarClose" class="block lg:hidden text-slate-500 hover:text-slate-800">
            <i class='bx bx-x text-3xl'></i>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav class="mt-2 py-4 px-4 lg:px-6">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 ml-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">MENU</h3>

                <ul class="mb-6 flex flex-col gap-2">
                    <!-- Menu Item Dashboard -->
                    <li>
                        <a href="/dashboard" class="group relative flex items-center gap-3 rounded-lg py-2.5 px-3 font-medium text-slate-600 duration-300 ease-in-out hover:bg-slate-50 hover:text-primary <?php echo ($currentUri === '/' || $currentUri === '/dashboard') ? 'bg-slate-50 text-primary' : ''; ?>">
                            <div class="flex items-center justify-center rounded-lg p-1.5 <?php echo ($currentUri === '/' || $currentUri === '/dashboard') ? 'bg-blue-500 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-500 group-hover:text-white'; ?> transition-colors">
                                <i class='bx bx-grid-alt text-lg'></i>
                            </div>
                            Dashboard
                        </a>
                    </li>

                    <!-- Menu Item Lançamentos -->
                    <li>
                        <a href="/entries" class="group relative flex items-center gap-3 rounded-lg py-2.5 px-3 font-medium text-slate-600 duration-300 ease-in-out hover:bg-slate-50 hover:text-primary <?php echo (strpos($currentUri, '/entries') === 0) ? 'bg-slate-50 text-primary' : ''; ?>">
                            <div class="flex items-center justify-center rounded-lg p-1.5 <?php echo (strpos($currentUri, '/entries') === 0) ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-green-500 group-hover:text-white'; ?> transition-colors">
                                <i class='bx bx-list-ul text-lg'></i>
                            </div>
                            Lançamentos
                        </a>
                    </li>

                    <!-- Menu Item Categorias -->
                    <li>
                        <a href="/categories" class="group relative flex items-center gap-3 rounded-lg py-2.5 px-3 font-medium text-slate-600 duration-300 ease-in-out hover:bg-slate-50 hover:text-primary <?php echo (strpos($currentUri, '/categories') === 0) ? 'bg-slate-50 text-primary' : ''; ?>">
                            <div class="flex items-center justify-center rounded-lg p-1.5 <?php echo (strpos($currentUri, '/categories') === 0) ? 'bg-purple-500 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-purple-500 group-hover:text-white'; ?> transition-colors">
                                <i class='bx bx-category text-lg'></i>
                            </div>
                            Categorias
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Sidebar Menu -->
    </div>
</aside>