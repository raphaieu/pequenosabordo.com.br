<?php
$title = ($reserva ? 'Editar' : 'Nova') . ' Reserva - Admin';
ob_start();
$produtosSelecionados = [];
if (isset($reserva['produtos_selecionados']) && is_array($reserva['produtos_selecionados'])) {
    foreach ($reserva['produtos_selecionados'] as $prod) {
        $produtosSelecionados[] = $prod['produto_id'];
    }
}
?>

<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl lg:text-3xl font-heading font-semibold mb-6 text-primary">
        <?= $reserva ? 'Editar Reserva' : 'Nova Reserva' ?>
    </h1>

    <?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-md p-6 lg:p-8">
        <form method="POST" action="<?= $action ?>" class="space-y-4" id="reserva-form">
            <!-- Seção de Produtos -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Produtos *</label>
                <div id="produtos-container" class="space-y-3">
                    <!-- Produto será adicionado aqui via JavaScript -->
                </div>
                <button 
                    type="button" 
                    id="adicionar-produto" 
                    class="mt-3 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium"
                >
                    + Adicionar Produto
                </button>
            </div>

            <div>
                <label for="nome_completo" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                <input 
                    type="text" 
                    id="nome_completo" 
                    name="nome_completo" 
                    required 
                    value="<?= htmlspecialchars($reserva['nome_completo'] ?? $data['nome_completo'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                <input 
                    type="text" 
                    id="cpf" 
                    name="cpf" 
                    value="<?= htmlspecialchars($reserva['cpf'] ?? $data['cpf'] ?? '') ?>"
                    placeholder="000.000.000-00"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label for="endereco" class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                <textarea 
                    id="endereco" 
                    name="endereco" 
                    rows="3" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                ><?= htmlspecialchars($reserva['endereco'] ?? $data['endereco'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-1">Data de Início *</label>
                    <input 
                        type="date" 
                        id="data_inicio" 
                        name="data_inicio" 
                        required 
                        value="<?= htmlspecialchars($reserva['data_inicio'] ?? $data['data_inicio'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    >
                </div>

                <div>
                    <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-1">Data de Término *</label>
                    <input 
                        type="date" 
                        id="data_fim" 
                        name="data_fim" 
                        required 
                        value="<?= htmlspecialchars($reserva['data_fim'] ?? $data['data_fim'] ?? '') ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    >
                </div>
            </div>

            <div>
                <label for="forma_pagamento" class="block text-sm font-medium text-gray-700 mb-1">Forma de Pagamento *</label>
                <select 
                    id="forma_pagamento" 
                    name="forma_pagamento" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
                    <option value="PIX" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'PIX') || (!isset($reserva['forma_pagamento']) && (!isset($data['forma_pagamento']) || $data['forma_pagamento'] == 'PIX')) ? 'selected' : '' ?>>
                        PIX
                    </option>
                    <option value="Cartão de Crédito (máquininha)" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'Cartão de Crédito (máquininha)') || (isset($data['forma_pagamento']) && $data['forma_pagamento'] == 'Cartão de Crédito (máquininha)') ? 'selected' : '' ?>>
                        Cartão de Crédito (máquininha)
                    </option>
                    <option value="Espécie" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'Espécie') || (isset($data['forma_pagamento']) && $data['forma_pagamento'] == 'Espécie') ? 'selected' : '' ?>>
                        Espécie
                    </option>
                    <option value="Link de Pagamento" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'Link de Pagamento') || (isset($data['forma_pagamento']) && $data['forma_pagamento'] == 'Link de Pagamento') ? 'selected' : '' ?>>
                        Link de Pagamento
                    </option>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors font-medium"
                >
                    <?= $reserva ? 'Atualizar' : 'Criar' ?> Reserva
                </button>
                <a 
                    href="/admin/reservas" 
                    class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors text-center font-medium"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const produtosContainer = document.getElementById('produtos-container');
    const adicionarBtn = document.getElementById('adicionar-produto');
    const produtos = <?= json_encode($produtos) ?>;
    const produtosSelecionados = <?= json_encode($produtosSelecionados) ?>;
    let produtoCounter = 0;

    // Template para um campo de produto
    function criarCampoProduto(produtoIdSelecionado = '') {
        const index = produtoCounter++;
        const div = document.createElement('div');
        div.className = 'produto-item flex gap-2 items-end';
        div.innerHTML = `
            <div class="flex-1">
                <select 
                    name="produtos[]" 
                    class="produto-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                    required
                >
                    <option value="">Selecione um produto</option>
                    ${produtos.map(p => `
                        <option value="${p.id}" ${p.id == produtoIdSelecionado ? 'selected' : ''}>
                            ${p.nome}
                        </option>
                    `).join('')}
                </select>
            </div>
            <button 
                type="button" 
                class="remover-produto bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 transition-colors text-sm"
                ${produtoCounter === 1 ? 'style="display:none;"' : ''}
            >
                Remover
            </button>
        `;
        
        // Adiciona evento de remoção
        div.querySelector('.remover-produto').addEventListener('click', function() {
            div.remove();
            atualizarBotoesRemover();
        });
        
        return div;
    }

    function atualizarBotoesRemover() {
        const items = produtosContainer.querySelectorAll('.produto-item');
        items.forEach((item, index) => {
            const btn = item.querySelector('.remover-produto');
            if (items.length === 1) {
                btn.style.display = 'none';
            } else {
                btn.style.display = 'block';
            }
        });
    }

    // Adiciona primeiro produto
    if (produtosSelecionados.length > 0) {
        produtosSelecionados.forEach(prodId => {
            produtosContainer.appendChild(criarCampoProduto(prodId));
        });
    } else {
        produtosContainer.appendChild(criarCampoProduto());
    }
    atualizarBotoesRemover();

    // Adiciona novo produto
    adicionarBtn.addEventListener('click', function() {
        produtosContainer.appendChild(criarCampoProduto());
        atualizarBotoesRemover();
    });

    // Validação antes de enviar
    document.getElementById('reserva-form').addEventListener('submit', function(e) {
        const selects = produtosContainer.querySelectorAll('.produto-select');
        const valores = Array.from(selects).map(s => s.value).filter(v => v);
        
        if (valores.length === 0) {
            e.preventDefault();
            alert('Selecione pelo menos um produto');
            return false;
        }
        
        // Remove duplicatas
        const unicos = [...new Set(valores)];
        if (unicos.length !== valores.length) {
            e.preventDefault();
            alert('Não é possível selecionar o mesmo produto mais de uma vez');
            return false;
        }
    });
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
