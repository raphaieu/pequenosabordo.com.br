<?php
$title = ($produto ? 'Editar' : 'Novo') . ' Produto - Admin';
ob_start();
?>

<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl lg:text-3xl font-heading font-semibold mb-6 text-primary">
        <?= $produto ? 'Editar Produto' : 'Novo Produto' ?>
    </h1>

    <?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-md p-6 lg:p-8">
        <form method="POST" action="<?= $action ?>" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input 
                    type="text" 
                    id="nome" 
                    name="nome" 
                    required 
                    value="<?= htmlspecialchars($produto['nome'] ?? $data['nome'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label for="imagem" class="block text-sm font-medium text-gray-700 mb-1">Imagem <?= $produto ? '(deixe em branco para manter)' : '*' ?></label>
                <?php if ($produto && isset($produto['imagem'])): ?>
                <div class="mb-2">
                    <img src="<?= htmlspecialchars(imageUrl($produto['imagem'])) ?>" alt="Imagem atual" class="h-32 w-32 object-cover rounded">
                </div>
                <?php endif; ?>
                <input 
                    type="file" 
                    id="imagem" 
                    name="imagem" 
                    <?= $produto ? '' : 'required' ?>
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
                <p class="text-xs text-gray-500 mt-1">Formatos aceitos: JPG, PNG, WEBP (máx. 5MB)</p>
            </div>

            <div>
                <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">Marca *</label>
                <input 
                    type="text" 
                    id="marca" 
                    name="marca" 
                    required 
                    value="<?= htmlspecialchars($produto['marca'] ?? $data['marca'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label for="tipoInstalacao" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Instalação</label>
                <input 
                    type="text" 
                    id="tipoInstalacao" 
                    name="tipoInstalacao" 
                    value="<?= htmlspecialchars($produto['tipoInstalacao'] ?? $data['tipoInstalacao'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label for="orientacao" class="block text-sm font-medium text-gray-700 mb-1">Orientação</label>
                <input 
                    type="text" 
                    id="orientacao" 
                    name="orientacao" 
                    value="<?= htmlspecialchars($produto['orientacao'] ?? $data['orientacao'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="preco1" class="block text-sm font-medium text-gray-700 mb-1">Preço 1 (0 a 5 dias) *</label>
                    <input 
                        type="number" 
                        id="preco1" 
                        name="preco1" 
                        step="0.01" 
                        min="0" 
                        required 
                        value="<?= htmlspecialchars($produto['preco1'] ?? $produto['precoCurto'] ?? $data['preco1'] ?? $data['precoCurto'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    >
                </div>

                <div>
                    <label for="preco2" class="block text-sm font-medium text-gray-700 mb-1">Preço 2 (6 a 15 dias) *</label>
                    <input 
                        type="number" 
                        id="preco2" 
                        name="preco2" 
                        step="0.01" 
                        min="0" 
                        required 
                        value="<?= htmlspecialchars($produto['preco2'] ?? $produto['precoLongo'] ?? $data['preco2'] ?? $data['precoLongo'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    >
                </div>

                <div>
                    <label for="preco3" class="block text-sm font-medium text-gray-700 mb-1">Preço 3 (16 a 30 dias) *</label>
                    <input 
                        type="number" 
                        id="preco3" 
                        name="preco3" 
                        step="0.01" 
                        min="0" 
                        required 
                        value="<?= htmlspecialchars($produto['preco3'] ?? $produto['precoLongo'] ?? $data['preco3'] ?? $data['precoLongo'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    >
                </div>
            </div>

            <div>
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição *</label>
                <textarea 
                    id="descricao" 
                    name="descricao" 
                    rows="4" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                ><?= htmlspecialchars($produto['descricao'] ?? $data['descricao'] ?? '') ?></textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-medium"
                >
                    <?= $produto ? 'Atualizar' : 'Criar' ?> Produto
                </button>
                <a 
                    href="/admin/produtos" 
                    class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors text-center font-medium"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>

