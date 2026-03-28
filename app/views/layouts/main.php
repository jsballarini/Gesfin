<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Financeiro Simples</title>
    
    <!-- Configuração do Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3C50E0',
                        success: '#219653',
                        danger: '#D34053',
                        warning: '#FFA70B',
                    }
                }
            }
        }
    </script>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="bg-[#F1F5F9] text-slate-600 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

        <!-- Content Area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            <!-- Header -->
            <?php require_once __DIR__ . '/../partials/header.php'; ?>

            <!-- Main Content -->
            <main>
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                    <?php 
                        if (isset($contentView)) {
                            require_once $contentView;
                        }
                    ?>
                </div>
            </main>

        </div>
    </div>

    <!-- Scripts interativos -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                });
            }

            if (sidebarClose && sidebar) {
                sidebarClose.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                });
            }
        });
    </script>
</body>
</html>