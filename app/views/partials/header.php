<header class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1 dark:bg-boxdark dark:drop-shadow-none">
    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
        
        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
            <!-- Hamburger Toggle BTN -->
            <button id="sidebarToggle" class="z-99999 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-boxdark lg:hidden">
                <i class='bx bx-menu text-2xl text-slate-600'></i>
            </button>
            <!-- Hamburger Toggle BTN -->
            
            <a href="/dashboard" class="block flex-shrink-0 lg:hidden">
                <i class='bx bx-wallet text-3xl text-primary'></i>
            </a>
        </div>

        <div class="hidden sm:block">
            <h2 class="text-xl font-semibold text-slate-800">
                <?php 
                    $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
                    // Título dinâmico da página baseado na rota
                    $pageTitle = 'Dashboard';
                    if (strpos($currentUri, '/categories') === 0) $pageTitle = 'Categorias';
                    if (strpos($currentUri, '/entries') === 0) $pageTitle = 'Lançamentos';
                    echo $pageTitle;
                ?>
            </h2>
        </div>

        <div class="flex items-center gap-3 2xsm:gap-7">
            <!-- User Area -->
            <div class="relative flex items-center gap-4">
                <span class="hidden text-right lg:block">
                    <span class="block text-sm font-medium text-black dark:text-white">
                        <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuário'); ?>
                    </span>
                    <span class="block text-xs">Administrador</span>
                </span>
                
                <span class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                    <i class='bx bx-user text-xl'></i>
                </span>

                <form action="/logout" method="POST" class="ml-2">
                    <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition flex items-center gap-1">
                        <i class='bx bx-log-out'></i> Sair
                    </button>
                </form>
            </div>
            <!-- User Area -->
        </div>
    </div>
</header>