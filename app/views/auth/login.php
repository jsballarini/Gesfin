<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - App Financeiro Simples</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">App Financeiro</h1>
            <p class="text-slate-500 mt-2">Acesse sua conta para continuar</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="/login" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-slate-700 text-sm font-bold mb-2">Usuário</label>
                <input type="text" id="username" name="username" required 
                    class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-slate-700 text-sm font-bold mb-2">Senha</label>
                <input type="password" id="password" name="password" required 
                    class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-slate-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Entrar
                </button>
            </div>
        </form>
    </div>

</body>
</html>