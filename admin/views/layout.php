<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Admin - Pequenos a Bordo' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#D16806',
                    },
                    fontFamily: {
                        heading: ['Cormorant Upright', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@400;600&family=Sora:wght@300;400;500;600&display=swap');
        .font-heading { font-family: 'Cormorant Upright', serif; }
        body { font-family: 'Sora', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
    <!-- Menu Mobile -->
    <nav class="bg-white shadow-md lg:hidden">
        <div class="px-4 py-3 flex items-center justify-between">
            <h1 class="text-xl font-heading font-semibold text-primary">Pequenos a Bordo</h1>
            <button id="menuToggle" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div id="mobileMenu" class="hidden px-4 pb-4">
            <a href="/admin/dashboard" class="block py-2 text-gray-700 hover:text-primary">Dashboard</a>
            <a href="/admin/produtos" class="block py-2 text-gray-700 hover:text-primary">Produtos</a>
            <a href="/admin/reservas" class="block py-2 text-gray-700 hover:text-primary">Reservas</a>
            <a href="/admin/logout" class="block py-2 text-red-600 hover:text-red-800">Sair</a>
        </div>
    </nav>

    <!-- Menu Desktop -->
    <nav class="hidden lg:block bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <h1 class="text-2xl font-heading font-semibold text-primary">Pequenos a Bordo</h1>
                <div class="flex space-x-6">
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-primary font-medium">Dashboard</a>
                    <a href="/admin/produtos" class="text-gray-700 hover:text-primary font-medium">Produtos</a>
                    <a href="/admin/reservas" class="text-gray-700 hover:text-primary font-medium">Reservas</a>
                    <a href="/admin/logout" class="text-red-600 hover:text-red-800 font-medium">Sair</a>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Alerts -->
    <?php if (isset($_GET['success'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 mx-4 lg:mx-auto lg:max-w-6xl mt-4" role="alert">
        <span class="block sm:inline"><?= htmlspecialchars($_GET['success']) ?></span>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-4 lg:mx-auto lg:max-w-6xl mt-4" role="alert">
        <span class="block sm:inline"><?= htmlspecialchars($_GET['error']) ?></span>
    </div>
    <?php endif; ?>

    <!-- Conteúdo -->
    <main class="container mx-auto px-4 py-6 lg:py-8">
        <?= isset($content) ? $content : '' ?>
    </main>

    <script>
        // Menu mobile toggle
        var menuToggle = document.getElementById('menuToggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                var menu = document.getElementById('mobileMenu');
                if (menu) {
                    menu.classList.toggle('hidden');
                }
            });
        }
    </script>
</body>
</html>

