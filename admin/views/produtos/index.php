<?php
$title = 'Produtos - Admin';
ob_start();
?>

<div class="max-w-8xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl lg:text-3xl font-heading font-semibold text-primary">Produtos</h1>
        <a href="/admin/produtos/create" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-medium">
            + Novo Produto
        </a>
    </div>

    <!-- Cards Mobile -->
    <div class="grid grid-cols-1 lg:hidden gap-4" id="produtos-mobile-list">
        <?php foreach ($produtos as $produto): ?>
        <div class="bg-white rounded-lg shadow-md p-4 produto-item" data-id="<?= $produto['id'] ?>">
            <img src="<?= htmlspecialchars(imageUrl($produto['imagem'])) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="w-full h-48 object-cover rounded mb-4">
            <h3 class="font-semibold text-lg mb-2"><?= htmlspecialchars($produto['nome']) ?></h3>
            <p class="text-sm text-gray-600 mb-2">Marca: <?= htmlspecialchars($produto['marca']) ?></p>
            <p class="text-sm text-gray-600 mb-1">Preço 1 (0-5 dias): R$ <?= number_format($produto['preco1'] ?? $produto['precoCurto'] ?? 0, 2, ',', '.') ?></p>
            <p class="text-sm text-gray-600 mb-1">Preço 2 (6-15 dias): R$ <?= number_format($produto['preco2'] ?? $produto['precoLongo'] ?? 0, 2, ',', '.') ?></p>
            <p class="text-sm text-gray-600 mb-4">Preço 3 (16-30 dias): R$ <?= number_format($produto['preco3'] ?? $produto['precoLongo'] ?? 0, 2, ',', '.') ?></p>
            <div class="flex gap-2">
                <a href="/admin/produtos/<?= $produto['id'] ?>/edit" class="flex-1 bg-blue-500 text-white py-2 px-4 rounded text-center text-sm hover:bg-blue-600">
                    Editar
                </a>
                <form method="POST" action="/admin/produtos/<?= $produto['id'] ?>/delete" class="flex-1" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
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
        <div class="px-4 py-2 bg-gray-50 border-b">
            <p class="text-sm text-gray-600">💡 <strong>Dica:</strong> Arraste as linhas para reordenar os produtos</p>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8"></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço 1 (0-5)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço 2 (6-15)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço 3 (16-30)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="produtos-table-body">
                <?php foreach ($produtos as $produto): ?>
                <tr class="produto-row cursor-move hover:bg-gray-50 transition-colors" data-id="<?= $produto['id'] ?>">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                        </svg>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="<?= htmlspecialchars(imageUrl($produto['imagem'])) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="h-16 w-16 object-cover rounded">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($produto['nome']) ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($produto['marca']) ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">R$ <?= number_format($produto['preco1'] ?? $produto['precoCurto'] ?? 0, 2, ',', '.') ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">R$ <?= number_format($produto['preco2'] ?? $produto['precoLongo'] ?? 0, 2, ',', '.') ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">R$ <?= number_format($produto['preco3'] ?? $produto['precoLongo'] ?? 0, 2, ',', '.') ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/produtos/<?= $produto['id'] ?>/edit" class="text-blue-600 hover:text-blue-900 mr-4">Editar</a>
                        <form method="POST" action="/admin/produtos/<?= $produto['id'] ?>/delete" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($produtos)): ?>
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <p class="text-gray-500">Nenhum produto cadastrado.</p>
        <a href="/admin/produtos/create" class="mt-4 inline-block text-primary hover:underline">Criar primeiro produto</a>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sortable para desktop (tabela)
    const tableBody = document.getElementById('produtos-table-body');
    if (tableBody) {
        new Sortable(tableBody, {
            animation: 150,
            ghostClass: 'opacity-50',
            chosenClass: 'bg-blue-50',
            filter: 'a, button, form',
            preventOnFilter: false,
            onEnd: function(evt) {
                updateOrder();
            }
        });
    }

    // Sortable para mobile (cards)
    const mobileList = document.getElementById('produtos-mobile-list');
    if (mobileList) {
        new Sortable(mobileList, {
            handle: '.produto-item',
            animation: 150,
            ghostClass: 'opacity-50',
            chosenClass: 'bg-blue-50',
            onEnd: function(evt) {
                updateOrder();
            }
        });
    }

    function updateOrder() {
        const orders = {};
        let index = 1;

        // Pega ordem da tabela desktop
        const rows = document.querySelectorAll('#produtos-table-body .produto-row');
        if (rows.length > 0) {
            rows.forEach(function(row) {
                const id = row.getAttribute('data-id');
                if (id) {
                    orders[id] = index++;
                }
            });
        } else {
            // Se não tiver tabela, pega dos cards mobile
            const items = document.querySelectorAll('#produtos-mobile-list .produto-item');
            items.forEach(function(item) {
                const id = item.getAttribute('data-id');
                if (id) {
                    orders[id] = index++;
                }
            });
        }

        // Envia para o servidor
        fetch('/admin/produtos/update-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ orders: orders })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Feedback visual opcional
                console.log('Ordem atualizada com sucesso');
            } else {
                console.error('Erro ao atualizar ordem:', data.message);
                alert('Erro ao atualizar ordem: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao atualizar ordem. Por favor, recarregue a página.');
        });
    }
});
</script>

