<?php
$title = ($reserva ? 'Editar' : 'Nova') . ' Reserva - Admin';
ob_start();
$produtosSelecionados = [];
if (isset($reserva['produtos_selecionados']) && is_array($reserva['produtos_selecionados'])) {
    foreach ($reserva['produtos_selecionados'] as $prod) {
        $produtosSelecionados[] = [
            'id' => $prod['produto_id'],
            'valor_cobrado' => $prod['valor_cobrado']
        ];
    }
}
?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl lg:text-3xl font-heading font-semibold mb-6 text-primary">
        <?= $reserva ? 'Editar Reserva' : 'Nova Reserva' ?>
    </h1>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= $action ?>" id="reserva-form">
        <div class="space-y-6">

            <!-- SEÇÃO 1: PERÍODO (NO TOPO) -->
            <div class="bg-white rounded-lg shadow-md p-6 lg:p-8 border-t-4 border-primary">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Período da Locação
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-1">Data de Início
                            *</label>
                        <input type="date" id="data_inicio" name="data_inicio" required
                            value="<?= htmlspecialchars($reserva['data_inicio'] ?? $data['data_inicio'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-1">Data de Término
                            *</label>
                        <input type="date" id="data_fim" name="data_fim" required
                            value="<?= htmlspecialchars($reserva['data_fim'] ?? $data['data_fim'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                </div>
                <div id="info-periodo" class="mt-3 text-sm text-primary font-medium hidden">
                    Duração: <span id="label-dias">0</span> dias (Tier: <span id="label-tier">-</span>)
                </div>
            </div>

            <!-- SEÇÃO 4: PRODUTOS E VALORES -->
            <div class="bg-white rounded-lg shadow-md p-6 lg:p-8">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    Produtos e Valores
                </h2>

                <div id="produtos-container" class="space-y-4">
                    <!-- Produto será adicionado aqui via JavaScript -->
                </div>

                <button type="button" id="adicionar-produto"
                    class="mt-4 bg-gray-100 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-200 transition-colors text-sm font-bold flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4"></path>
                    </svg>
                    ADICIONAR PRODUTO
                </button>

                <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="valor_total_previsto" class="block text-sm font-medium text-gray-700 mb-1">Valor Total Previsto (R$)</label>
                        <input type="text" id="valor_total_previsto" readonly value="0.00"
                            class="w-full px-4 py-2 border border-gray-200 rounded-md bg-gray-50 font-bold text-lg text-primary outline-none">
                    </div>
                    <div>
                        <label for="forma_pagamento" class="block text-sm font-medium text-gray-700 mb-1">Forma de Pagamento
                            *</label>
                        <select id="forma_pagamento" name="forma_pagamento" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                            <option value="PIX" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'PIX') ? 'selected' : '' ?>>PIX</option>
                            <option value="Cartão de Crédito (máquininha)" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'Cartão de Crédito (máquininha)') ? 'selected' : '' ?>>Cartão
                                de Crédito (máquininha)</option>
                            <option value="Espécie" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'Espécie') ? 'selected' : '' ?>>Espécie</option>
                            <option value="Link de Pagamento" <?= (isset($reserva['forma_pagamento']) && $reserva['forma_pagamento'] == 'Link de Pagamento') ? 'selected' : '' ?>>Link de Pagamento
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SEÇÃO 2: DADOS DO CLIENTE -->
            <div class="bg-white rounded-lg shadow-md p-6 lg:p-8">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informações do Cliente
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="nome_completo" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo
                            *</label>
                        <input type="text" id="nome_completo" name="nome_completo" required
                            value="<?= htmlspecialchars($reserva['nome_completo'] ?? $data['nome_completo'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone /
                            WhatsApp</label>
                        <input type="text" id="telefone" name="telefone"
                            value="<?= htmlspecialchars($reserva['telefone'] ?? $data['telefone'] ?? '') ?>"
                            placeholder="(00) 00000-0000"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                        <input type="text" id="cpf" name="cpf"
                            value="<?= htmlspecialchars($reserva['cpf'] ?? $data['cpf'] ?? '') ?>"
                            placeholder="000.000.000-00"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label for="endereco" class="block text-sm font-medium text-gray-700 mb-1">Endereço
                            Residencial</label>
                        <textarea id="endereco" name="endereco" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"><?= htmlspecialchars($reserva['endereco'] ?? $data['endereco'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SEÇÃO 3: LOGÍSTICA -->
            <div class="bg-white rounded-lg shadow-md p-6 lg:p-8">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Logística (Entrega e Devolução)
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="local_entrega" class="block text-sm font-medium text-gray-700 mb-1">Local de
                            Entrega</label>
                        <input type="text" id="local_entrega" name="local_entrega"
                            value="<?= htmlspecialchars($reserva['local_entrega'] ?? $data['local_entrega'] ?? '') ?>"
                            placeholder="Ex: Aeroporto, Hotel, Locadora..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="horario_entrega" class="block text-sm font-medium text-gray-700 mb-1">Horário
                            Previsto</label>
                        <input type="time" id="horario_entrega" name="horario_entrega"
                            value="<?= htmlspecialchars($reserva['horario_entrega'] ?? $data['horario_entrega'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="local_devolucao" class="block text-sm font-medium text-gray-700 mb-1">Local de
                            Devolução</label>
                        <input type="text" id="local_devolucao" name="local_devolucao"
                            value="<?= htmlspecialchars($reserva['local_devolucao'] ?? $data['local_devolucao'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="horario_devolucao" class="block text-sm font-medium text-gray-700 mb-1">Horário
                            Previsto</label>
                        <input type="time" id="horario_devolucao" name="horario_devolucao"
                            value="<?= htmlspecialchars($reserva['horario_devolucao'] ?? $data['horario_devolucao'] ?? '') ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label for="obs_logistica" class="block text-sm font-medium text-gray-700 mb-1">Observações de
                            Logística</label>
                        <textarea id="obs_logistica" name="obs_logistica" rows="2"
                            placeholder="Ex: Devolução na Unidas, buscar com fulano..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"><?= htmlspecialchars($reserva['obs_logistica'] ?? $data['obs_logistica'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>


            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit"
                    class="flex-1 bg-primary text-white py-3 px-6 rounded-md hover:bg-opacity-90 transition-colors font-bold text-lg">
                    <?= $reserva ? 'Atualizar' : 'Criar' ?> Reserva
                </button>
                <a href="/admin/reservas"
                    class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-md hover:bg-gray-300 transition-colors text-center font-bold text-lg">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const produtosContainer = document.getElementById('produtos-container');
        const adicionarBtn = document.getElementById('adicionar-produto');
        const dataInicioInput = document.getElementById('data_inicio');
        const dataFimInput = document.getElementById('data_fim');
        const labelDias = document.getElementById('label-dias');
        const labelTier = document.getElementById('label-tier');
        const infoPeriodo = document.getElementById('info-periodo');
        const inputValorTotal = document.getElementById('valor_total_previsto');

        const produtosData = <?= json_encode($produtos) ?>;
        const produtosSelecionados = <?= json_encode($produtosSelecionados) ?>;

        let tierAtual = 1;
        let diasTotais = 0;

        function calcularDias() {
            if (dataInicioInput.value && dataFimInput.value) {
                const inicio = new Date(dataInicioInput.value);
                const fim = new Date(dataFimInput.value);
                const diffTime = Math.abs(fim - inicio);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Inclui o dia da entrega
                
                diasTotais = diffDays;
                labelDias.innerText = diffDays;
                infoPeriodo.classList.remove('hidden');

                if (diffDays <= 5) {
                    tierAtual = 1;
                    labelTier.innerText = '3 a 5 dias';
                } else if (diffDays <= 15) {
                    tierAtual = 2;
                    labelTier.innerText = '6 a 15 dias';
                } else {
                    tierAtual = 3;
                    labelTier.innerText = '16 a 30 dias';
                }

                // Atualiza preços sugeridos para produtos já na lista
                atualizarPrecosSugeridos();
            }
        }

        function atualizarPrecosSugeridos() {
            const items = produtosContainer.querySelectorAll('.produto-item');
            items.forEach(item => {
                const select = item.querySelector('.produto-select');
                const inputPreco = item.querySelector('.preco-input');

                if (select.value && !inputPreco.dataset.manual) {
                    const p = produtosData.find(prod => prod.id == select.value);
                    if (p) {
                        inputPreco.value = parseFloat(p['preco' + tierAtual]).toFixed(2);
                    }
                }
            });
            calcularTotal();
        }

        function calcularTotal() {
            const inputs = produtosContainer.querySelectorAll('.preco-input');
            let totalDiaria = 0;
            inputs.forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    totalDiaria += val;
                }
            });
            
            const totalGeral = totalDiaria * diasTotais;
            inputValorTotal.value = totalGeral.toFixed(2);
        }

        function criarCampoProduto(produtoId = '', valor = '') {
            const div = document.createElement('div');
            div.className = 'produto-item bg-gray-50 p-4 rounded-md border border-gray-200';
            div.innerHTML = `
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                <div class="sm:col-span-7">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Produto</label>
                    <select name="produtos[]" class="produto-select w-full px-3 py-2 border border-gray-300 rounded focus:ring-primary" required>
                        <option value="">Selecione um produto</option>
                        ${produtosData.map(p => `<option value="${p.id}" ${p.id == produtoId ? 'selected' : ''}>${p.nome}</option>`).join('')}
                    </select>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Preço / Dia (R$)</label>
                    <input type="number" step="0.01" name="valores[]" value="${valor}" 
                           class="preco-input w-full px-3 py-2 border border-gray-300 rounded focus:ring-primary" 
                           ${valor ? 'data-manual="true"' : ''} required>
                </div>
                <div class="sm:col-span-2">
                    <button type="button" class="remover-produto w-full bg-red-100 text-red-600 py-2 rounded hover:bg-red-200 transition-colors">
                        Remover
                    </button>
                </div>
            </div>
        `;

            const select = div.querySelector('.produto-select');
            const inputPreco = div.querySelector('.preco-input');

            select.addEventListener('change', function () {
                const p = produtosData.find(prod => prod.id == this.value);
                if (p) {
                    inputPreco.value = parseFloat(p['preco' + tierAtual]).toFixed(2);
                    inputPreco.dataset.manual = ""; // Reseta flag manual ao mudar produto
                    calcularTotal();
                }
            });

            inputPreco.addEventListener('input', function () {
                this.dataset.manual = "true"; // Marca como manual se o usuário editar
                calcularTotal();
            });

            div.querySelector('.remover-produto').addEventListener('click', () => {
                div.remove();
                calcularTotal();
            });

            return div;
        }

        dataInicioInput.addEventListener('change', calcularDias);
        dataFimInput.addEventListener('change', calcularDias);

        adicionarBtn.addEventListener('click', () => produtosContainer.appendChild(criarCampoProduto()));

        // Carrega produtos existentes
        if (produtosSelecionados.length > 0) {
            produtosSelecionados.forEach(p => {
                produtosContainer.appendChild(criarCampoProduto(p.id, p.valor_cobrado));
            });
        } else {
            produtosContainer.appendChild(criarCampoProduto());
        }

        calcularDias();
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>