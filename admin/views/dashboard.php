<?php
$title = 'Dashboard - Admin';
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl lg:text-3xl font-heading font-semibold mb-6 text-primary">Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total de Produtos</h3>
            <p class="text-3xl font-bold text-primary"><?= $produtosCount ?></p>
            <a href="/admin/produtos" class="text-primary hover:underline mt-2 inline-block">Ver produtos →</a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total de Reservas</h3>
            <p class="text-3xl font-bold text-primary"><?= $reservasCount ?></p>
            <a href="/admin/reservas" class="text-primary hover:underline mt-2 inline-block">Ver reservas →</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-heading font-semibold mb-4">Ações Rápidas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="/admin/produtos/create" class="bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition-colors text-center font-medium">
                Novo Produto
            </a>
            <a href="/admin/reservas/create" class="bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition-colors text-center font-medium">
                Nova Reserva
            </a>
            <a href="/admin/logistica" class="bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition-colors text-center font-medium">
                Ver Logística
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>

