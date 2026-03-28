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
                <div class="flex items-center gap-4 cursor-pointer hover:opacity-80 transition" id="profileModalBtn">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-black dark:text-white">
                            <?php echo htmlspecialchars(!empty($_SESSION['user_name']) ? $_SESSION['user_name'] : ($_SESSION['username'] ?? 'Usuário')); ?>
                        </span>
                        <span class="block text-xs"><?php echo htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></span>
                    </span>
                    
                    <?php if (!empty($_SESSION['profile_pic'])): ?>
                        <img src="<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="User" class="h-10 w-10 rounded-full object-cover shadow-sm">
                    <?php else: ?>
                        <span class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 shadow-sm">
                            <i class='bx bx-user text-xl'></i>
                        </span>
                    <?php endif; ?>
                </div>

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

<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 hidden items-center justify-center overflow-y-auto bg-black/50 backdrop-blur-sm px-4 py-6" style="z-index: 999999;">
    <div class="relative w-full max-w-lg rounded-xl bg-white shadow-lg dark:bg-boxdark">
        <div class="flex items-center justify-between border-b border-stroke px-6 py-4 dark:border-strokedark">
            <h3 class="text-xl font-semibold text-black dark:text-white">
                Meu Perfil
            </h3>
            <button id="closeProfileModalBtn" class="text-slate-500 hover:text-black dark:hover:text-white transition">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <form action="/profile/update" method="POST" enctype="multipart/form-data" class="p-6">
            <div class="mb-5 flex items-center justify-center">
                <div class="relative group cursor-pointer">
                    <?php if (!empty($_SESSION['profile_pic'])): ?>
                        <img id="profilePreview" src="<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="Profile" class="h-24 w-24 rounded-full object-cover shadow-md border-2 border-primary/20">
                    <?php else: ?>
                        <div id="profilePreviewFallback" class="h-24 w-24 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 shadow-md border-2 border-transparent">
                            <i class='bx bx-user text-4xl'></i>
                        </div>
                        <img id="profilePreview" src="" alt="Profile" class="h-24 w-24 rounded-full object-cover shadow-md border-2 border-primary/20 hidden">
                    <?php endif; ?>
                    <label for="profile_pic" class="absolute bottom-0 right-0 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-primary text-white shadow-sm hover:bg-opacity-90 transition">
                        <i class='bx bx-camera'></i>
                        <input type="file" name="profile_pic" id="profile_pic" class="hidden" accept="image/png, image/jpeg, image/jpg, image/gif">
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-black dark:1text-white">Nome</label>
                <div class="relative">
                    <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>" placeholder="Seu nome completo" class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white" />
                </div>
            </div>

            <div class="mb-4">
                <label class="mb-2.5 block font-medium text-black dark:1text-white">Login (Usuário)</label>
                <div class="relative">
                    <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white" />
                </div>
            </div>

            <div class="mb-6">
                <label class="mb-2.5 block font-medium text-black dark:1text-white">Nova Senha</label>
                <div class="relative">
                    <input type="password" name="password" placeholder="Deixe em branco para manter a atual" class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white" />
                </div>
                <p class="text-xs text-slate-500 mt-1">Preencha apenas se desejar alterar a senha.</p>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" id="cancelProfileModalBtn" class="rounded-lg border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:1text-white transition">
                    Cancelar
                </button>
                <button type="submit" class="rounded-lg bg-primary px-6 py-2 font-medium text-white hover:bg-opacity-90 transition">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const profileModalBtn = document.getElementById('profileModalBtn');
        const profileModal = document.getElementById('profileModal');
        const closeProfileModalBtn = document.getElementById('closeProfileModalBtn');
        const cancelProfileModalBtn = document.getElementById('cancelProfileModalBtn');
        const profilePicInput = document.getElementById('profile_pic');
        const profilePreview = document.getElementById('profilePreview');
        const profilePreviewFallback = document.getElementById('profilePreviewFallback');

        const openModal = () => {
            profileModal.classList.remove('hidden');
            profileModal.classList.add('flex');
        };

        const closeModal = () => {
            profileModal.classList.add('hidden');
            profileModal.classList.remove('flex');
        };

        if (profileModalBtn) profileModalBtn.addEventListener('click', openModal);
        if (closeProfileModalBtn) closeProfileModalBtn.addEventListener('click', closeModal);
        if (cancelProfileModalBtn) cancelProfileModalBtn.addEventListener('click', closeModal);

        // Fechar ao clicar fora
        profileModal.addEventListener('click', (e) => {
            if (e.target === profileModal) {
                closeModal();
            }
        });

        // Preview da imagem
        if (profilePicInput) {
            profilePicInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePreview.src = e.target.result;
                        profilePreview.classList.remove('hidden');
                        if (profilePreviewFallback) {
                            profilePreviewFallback.classList.add('hidden');
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>