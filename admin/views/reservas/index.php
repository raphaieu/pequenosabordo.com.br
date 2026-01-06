<?php
$title = 'Reservas - Admin';
ob_start();
?>

<div class="max-w-8xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl lg:text-3xl font-heading font-semibold text-primary">Reservas</h1>
        <a href="/admin/reservas/create" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-medium">
            + Nova Reserva
        </a>
    </div>

    <!-- Cards Mobile -->
    <div class="grid grid-cols-1 lg:hidden gap-4">
        <?php foreach ($reservas as $reserva): ?>
        <div class="rounded-lg shadow-md p-4 <?= isset($reserva['devolvida']) && $reserva['devolvida'] ? 'bg-gray-50' : 'bg-white' ?>">
            <h3 class="font-semibold text-lg mb-2"><?= htmlspecialchars($reserva['nome_completo']) ?></h3>
            <p class="text-sm text-gray-600 mb-1">Observações: <?= htmlspecialchars($reserva['endereco'] ?? '') ?></p>
            <p class="text-sm text-gray-600 mb-1">
                Produto(s): 
                <?php 
                if (isset($reserva['produtos']) && is_array($reserva['produtos']) && count($reserva['produtos']) > 0) {
                    $nomes = array_map(function($p) { return htmlspecialchars($p['produto_nome']); }, $reserva['produtos']);
                    echo implode(', ', $nomes);
                } else {
                    echo 'N/A';
                }
                ?>
            </p>
            <p class="text-sm text-gray-600 mb-1">
                Período: <?= date('d/m/Y', strtotime($reserva['data_inicio'])) ?><br>
                <?= date('d/m/Y', strtotime($reserva['data_fim'])) ?>
            </p>
            <p class="text-sm text-gray-600 mb-1">PGTO: <?= htmlspecialchars($reserva['forma_pagamento'] ?? 'PIX') ?></p>
            <div class="flex gap-2 mt-4">
                <a href="/admin/reservas/<?= $reserva['id'] ?>/edit" class="flex-1 bg-blue-500 text-white py-2 px-4 rounded text-center text-sm hover:bg-blue-600">
                    Editar
                </a>
                <a href="/admin/reservas/<?= $reserva['id'] ?>/pdf" class="flex-1 bg-green-500 text-white py-2 px-4 rounded text-center text-sm hover:bg-green-600">
                    Contrato
                </a>
                <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/delete" class="flex-1" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?');">
                    <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded text-sm hover:bg-red-600">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tabela Desktop -->
    <div class="hidden lg:block bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observações</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PGTO</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($reservas as $reserva): ?>
                <tr class="<?= isset($reserva['devolvida']) && $reserva['devolvida'] ? 'bg-gray-50' : '' ?>">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($reserva['nome_completo']) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($reserva['endereco'] ?? '') ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            <?php 
                            if (isset($reserva['produtos']) && is_array($reserva['produtos']) && count($reserva['produtos']) > 0) {
                                $nomes = array_map(function($p) { return htmlspecialchars($p['produto_nome']); }, $reserva['produtos']);
                                echo implode('<br>', $nomes);
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            <?= date('d/m/Y', strtotime($reserva['data_inicio'])) ?><br>
                            <?= date('d/m/Y', strtotime($reserva['data_fim'])) ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?= htmlspecialchars($reserva['forma_pagamento'] ?? 'PIX') ?></div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <div class="flex flex-col gap-1">
                            <a href="/admin/reservas/<?= $reserva['id'] ?>/edit" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <a href="/admin/reservas/<?= $reserva['id'] ?>/pdf" class="text-green-600 hover:text-green-900">Contrato</a>
                            <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/delete" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?');">
                                <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($reservas)): ?>
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <p class="text-gray-500">Nenhuma reserva cadastrada.</p>
        <a href="/admin/reservas/create" class="mt-4 inline-block text-primary hover:underline">Criar primeira reserva</a>
    </div>
    <?php endif; ?>

    <!-- Paginação -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php
    // Função helper para construir URL de paginação preservando query params
    $buildPageUrl = function($page) {
        $queryParams = $_GET;
        $queryParams['page'] = $page;
        return '/admin/reservas?' . http_build_query($queryParams);
    };
    ?>
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-700">
            Mostrando <?= count($reservas) ?> de <?= $totalReservas ?> reserva(s)
        </div>
        <div class="flex gap-2">
            <?php if ($currentPage > 1): ?>
                <a href="<?= $buildPageUrl($currentPage - 1) ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Anterior
                </a>
            <?php else: ?>
                <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm font-medium text-gray-400 cursor-not-allowed">
                    Anterior
                </span>
            <?php endif; ?>

            <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            
            if ($startPage > 1): ?>
                <a href="<?= $buildPageUrl(1) ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                <?php if ($startPage > 2): ?>
                    <span class="px-4 py-2 text-gray-500">...</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <?php if ($i == $currentPage): ?>
                    <span class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium">
                        <?= $i ?>
                    </span>
                <?php else: ?>
                    <a href="<?= $buildPageUrl($i) ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <?= $i ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($endPage < $totalPages): ?>
                <?php if ($endPage < $totalPages - 1): ?>
                    <span class="px-4 py-2 text-gray-500">...</span>
                <?php endif; ?>
                <a href="<?= $buildPageUrl($totalPages) ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?= $totalPages ?>
                </a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= $buildPageUrl($currentPage + 1) ?>" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Próxima
                </a>
            <?php else: ?>
                <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm font-medium text-gray-400 cursor-not-allowed">
                    Próxima
                </span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>

