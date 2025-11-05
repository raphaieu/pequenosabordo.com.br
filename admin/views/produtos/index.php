<?php
$title = 'Produtos - Admin';
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl lg:text-3xl font-heading font-semibold text-primary">Produtos</h1>
        <a href="/admin/produtos/create" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-medium">
            + Novo Produto
        </a>
    </div>

    <!-- Cards Mobile / Tabela Desktop -->
    <div class="grid grid-cols-1 lg:hidden gap-4">
        <?php foreach ($produtos as $produto): ?>
        <div class="bg-white rounded-lg shadow-md p-4">
            <img src="<?= htmlspecialchars(imageUrl($produto['imagem'])) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="w-full h-48 object-cover rounded mb-4">
            <h3 class="font-semibold text-lg mb-2"><?= htmlspecialchars($produto['nome']) ?></h3>
            <p class="text-sm text-gray-600 mb-2">Marca: <?= htmlspecialchars($produto['marca']) ?></p>
            <p class="text-sm text-gray-600 mb-4">Preço curto: R$ <?= number_format($produto['precoCurto'], 2, ',', '.') ?></p>
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
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Curto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Longo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($produtos as $produto): ?>
                <tr>
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
                        <div class="text-sm text-gray-900">R$ <?= number_format($produto['precoCurto'], 2, ',', '.') ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">R$ <?= number_format($produto['precoLongo'], 2, ',', '.') ?></div>
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

