<?php
$title = ($reserva ? 'Editar' : 'Nova') . ' Reserva - Admin';
ob_start();
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
        <form method="POST" action="<?= $action ?>" class="space-y-4">
            <div>
                <label for="produto_id" class="block text-sm font-medium text-gray-700 mb-1">Produto *</label>
                <select 
                    id="produto_id" 
                    name="produto_id" 
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
                    <option value="">Selecione um produto</option>
                    <?php foreach ($produtos as $produto): ?>
                    <option value="<?= $produto['id'] ?>" 
                        <?= (isset($reserva['produto_id']) && $reserva['produto_id'] == $produto['id']) || (isset($data['produto_id']) && $data['produto_id'] == $produto['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($produto['nome']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
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
                <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF *</label>
                <input 
                    type="text" 
                    id="cpf" 
                    name="cpf" 
                    required 
                    value="<?= htmlspecialchars($reserva['cpf'] ?? $data['cpf'] ?? '') ?>"
                    placeholder="000.000.000-00"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label for="endereco" class="block text-sm font-medium text-gray-700 mb-1">Endereço *</label>
                <textarea 
                    id="endereco" 
                    name="endereco" 
                    rows="3" 
                    required 
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

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>

