<?php
$title = 'Reservas - Admin';
ob_start();
?>

<div class="max-w-8xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl lg:text-3xl font-heading font-semibold text-primary">Reservas</h1>
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="/admin/logistica" class="flex-1 sm:flex-none bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium text-center text-sm">
                Ver Logística
            </a>
            <a href="/admin/reservas/create" class="flex-1 sm:flex-none bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-medium text-center text-sm">
                + Nova Reserva
            </a>
        </div>
    </div>

    <!-- Abas -->
    <div class="flex border-b border-gray-200 mb-6 overflow-x-auto">
        <a href="/admin/reservas" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap <?= $currentTab === 'ativas' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
            Ativas (<?= $currentTab === 'ativas' ? $totalReservas : '...' ?>)
        </a>
        <a href="/admin/reservas?tab=arquivadas" class="py-2 px-4 border-b-2 font-medium text-sm whitespace-nowrap <?= $currentTab === 'arquivadas' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
            Arquivadas (<?= $currentTab === 'arquivadas' ? $totalReservas : '...' ?>)
        </a>
    </div>

    <!-- Cards Mobile -->
    <div class="grid grid-cols-1 lg:hidden gap-4">
        <?php foreach ($reservas as $reserva): ?>
        <div class="rounded-lg shadow-md p-4 bg-white border-t-4 <?= $reserva['status'] === 'concluido' ? 'border-green-500' : ($reserva['status'] === 'entregue' ? 'border-blue-500' : 'border-yellow-500') ?>">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-gray-900"><?= htmlspecialchars($reserva['nome_completo']) ?></h3>
                <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/update-status" class="inline-block">
                    <select name="status" onchange="this.form.submit()" class="text-xs px-2 py-1 rounded-full outline-none cursor-pointer appearance-none text-center font-bold <?= $reserva['status'] === 'concluido' ? 'bg-green-100 text-green-700' : ($reserva['status'] === 'entregue' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') ?>">
                        <option value="pendente" <?= $reserva['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="entregue" <?= $reserva['status'] === 'entregue' ? 'selected' : '' ?>>Entregue</option>
                        <option value="concluido" <?= $reserva['status'] === 'concluido' ? 'selected' : '' ?>>Concluído</option>
                    </select>
                </form>
            </div>
            
            <p class="text-xs text-gray-500 mb-2">
                <strong>Produtos:</strong> 
                <?php foreach ($reserva['produtos'] as $p) echo htmlspecialchars($p['produto_nome']) . '; '; ?>
            </p>

            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                <div>
                    <span class="block text-xs uppercase font-bold text-gray-400">Início</span>
                    <?= date('d/m/Y', strtotime($reserva['data_inicio'])) ?>
                </div>
                <div>
                    <span class="block text-xs uppercase font-bold text-gray-400">Fim</span>
                    <?= date('d/m/Y', strtotime($reserva['data_fim'])) ?>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100">
                <a href="/admin/reservas/<?= $reserva['id'] ?>/edit" class="flex-1 bg-gray-100 text-gray-700 py-2 rounded text-center text-xs font-bold">EDITAR</a>
                <a href="/admin/reservas/<?= $reserva['id'] ?>/pdf" class="flex-1 bg-green-50 text-green-700 py-2 rounded text-center text-xs font-bold">PDF</a>
                
                <?php if ($reserva['arquivado']): ?>
                    <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/unarchive" class="flex-1">
                        <button type="submit" class="w-full bg-blue-50 text-blue-700 py-2 rounded text-xs font-bold">DESARQUIVAR</button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/archive" class="flex-1">
                        <button type="submit" class="w-full bg-gray-100 text-gray-700 py-2 rounded text-xs font-bold">ARQUIVAR</button>
                    </form>
                <?php endif; ?>
                
                <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/delete" class="w-full" onsubmit="return confirm('Enviar para a lixeira?');">
                    <button type="submit" class="w-full text-red-500 py-2 text-xs font-bold">EXCLUIR</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tabela Desktop -->
    <div class="hidden lg:block bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Cliente / Contato</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Produtos</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Período</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pagamento</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($reservas as $reserva): ?>
                <tr class="<?= $reserva['expirada'] && $reserva['status'] !== 'concluido' ? 'bg-red-50' : '' ?>">
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900"><?= htmlspecialchars($reserva['nome_completo']) ?></div>
                        <div class="text-xs text-gray-500"><?= htmlspecialchars($reserva['telefone'] ?: 'Sem telefone') ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/update-status">
                            <select name="status" onchange="this.form.submit()" class="px-2 py-1 text-xs font-bold rounded-full outline-none cursor-pointer appearance-none text-center <?= $reserva['status'] === 'concluido' ? 'bg-green-100 text-green-700' : ($reserva['status'] === 'entregue' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') ?>">
                                <option value="pendente" <?= $reserva['status'] === 'pendente' ? 'selected' : '' ?>>PENDENTE</option>
                                <option value="entregue" <?= $reserva['status'] === 'entregue' ? 'selected' : '' ?>>ENTREGUE</option>
                                <option value="concluido" <?= $reserva['status'] === 'concluido' ? 'selected' : '' ?>>CONCLUÍDO</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-700">
                            <?php foreach ($reserva['produtos'] as $p) echo "• " . htmlspecialchars($p['produto_nome']) . "<br>"; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">
                            <?= date('d/m/y', strtotime($reserva['data_inicio'])) ?> a <?= date('d/m/y', strtotime($reserva['data_fim'])) ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs font-medium"><?= htmlspecialchars($reserva['forma_pagamento']) ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-4">
                            <a href="/admin/reservas/<?= $reserva['id'] ?>/edit" class="text-blue-600 hover:text-blue-900" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <a href="/admin/reservas/<?= $reserva['id'] ?>/pdf" class="text-green-600 hover:text-green-900" title="Contrato PDF">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </a>
                            
                            <?php if ($reserva['arquivado']): ?>
                                <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/unarchive" class="inline">
                                    <button type="submit" class="text-blue-500 hover:text-blue-700" title="Desarquivar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/archive" class="inline">
                                    <button type="submit" class="text-gray-400 hover:text-gray-600" title="Arquivar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/delete" class="inline" onsubmit="return confirm('Excluir esta reserva?');">
                                <button type="submit" class="text-red-400 hover:text-red-600" title="Excluir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($reservas)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center mt-6">
        <p class="text-gray-500 text-lg">Nenhuma reserva encontrada nesta aba.</p>
    </div>
    <?php endif; ?>

    <!-- Paginação -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php
    $buildPageUrl = function($page) {
        $queryParams = $_GET;
        $queryParams['page'] = $page;
        return '/admin/reservas?' . http_build_query($queryParams);
    };
    ?>
    <div class="mt-8 flex justify-center">
        <div class="flex gap-1">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= $buildPageUrl($i) ?>" class="px-4 py-2 <?= $currentPage == $i ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?> border border-gray-300 rounded-md text-sm font-bold">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
