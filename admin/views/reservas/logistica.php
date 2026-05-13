<?php
$title = 'Logística - Admin';
ob_start();

// Tradução manual dos dias da semana
$diasSemana = [
    'Sunday' => 'Domingo',
    'Monday' => 'Segunda-feira',
    'Tuesday' => 'Terça-feira',
    'Wednesday' => 'Quarta-feira',
    'Thursday' => 'Quinta-feira',
    'Friday' => 'Sexta-feira',
    'Saturday' => 'Sábado'
];

$mesesAno = [
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
];

// Agrupar por data para facilitar a leitura
$agrupado = [];
foreach ($logistica as $item) {
    $dataInicio = $item['data_inicio'];
    $dataFim = $item['data_fim'];
    
    // Entrega: Só mostra se estiver PENDENTE
    if ($item['status'] === 'pendente') {
        $agrupado[$dataInicio]['entregas'][] = $item;
    }
    
    // Devolução: Só mostra se estiver ENTREGUE (com o cliente)
    if ($item['status'] === 'entregue') {
        $agrupado[$dataFim]['devolucoes'][] = $item;
    }
}

ksort($agrupado);
?>

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl lg:text-3xl font-heading font-semibold text-primary">Logística Próximos Dias</h1>
        <a href="/admin/reservas/create" class="bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors text-sm font-medium">
            + Nova Reserva
        </a>
    </div>

    <?php if (empty($agrupado)): ?>
        <div class="bg-white rounded-lg shadow-md p-8 text-center border-2 border-dashed border-gray-200">
            <p class="text-gray-500">Nenhuma entrega ou devolução pendente para os próximos dias.</p>
            <p class="text-sm text-gray-400 mt-2">As tarefas concluídas são removidas desta lista automaticamente.</p>
        </div>
    <?php else: ?>
        <div class="space-y-8">
            <?php foreach ($agrupado as $data => $atividades): ?>
                <div class="relative">
                    <div class="sticky top-0 bg-gray-50 py-2 z-10 border-b border-gray-200 mb-4">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <span class="<?= $data === $hoje ? 'bg-red-500' : 'bg-primary' ?> text-white px-3 py-1 rounded-full text-sm mr-3">
                                <?= $data === $hoje ? 'HOJE: ' : '' ?><?= date('d', strtotime($data)) ?> de <?= $mesesAno[date('m', strtotime($data))] ?>
                            </span>
                            <?= $diasSemana[date('l', strtotime($data))] ?>
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ENTREGAS -->
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-blue-600 uppercase tracking-widest flex items-center px-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                Entregas <?= isset($atividades['entregas']) ? '('.count($atividades['entregas']).')' : '(0)' ?>
                            </h3>
                            
                            <?php if (isset($atividades['entregas'])): ?>
                                <?php foreach ($atividades['entregas'] as $reserva): ?>
                                    <div class="bg-white border-l-4 border-blue-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow border border-gray-100">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-black text-gray-900 text-lg"><?= $reserva['horario_entrega'] ? date('H:i', strtotime($reserva['horario_entrega'])) : 'A combinar' ?></span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-50 text-blue-600 uppercase">Pendente</span>
                                        </div>
                                        
                                        <h4 class="font-bold text-gray-800 leading-tight"><?= htmlspecialchars($reserva['nome_completo']) ?></h4>
                                        
                                        <div class="mt-2 flex items-start text-sm">
                                            <svg class="w-4 h-4 text-blue-500 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="text-blue-700 font-medium"><?= htmlspecialchars($reserva['local_entrega'] ?: 'A combinar') ?></span>
                                        </div>

                                        <div class="mt-3 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                            <strong class="text-gray-700">Produtos:</strong><br>
                                            <?php foreach ($reserva['produtos'] as $p) echo "• " . htmlspecialchars($p['produto_nome']) . "<br>"; ?>
                                        </div>

                                        <?php if ($reserva['obs_logistica']): ?>
                                            <div class="mt-3 p-2 bg-yellow-50 border border-yellow-100 rounded text-xs italic text-yellow-800">
                                                "<?= htmlspecialchars($reserva['obs_logistica']) ?>"
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-4 flex gap-2">
                                            <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/update-status" class="flex-1">
                                                <input type="hidden" name="status" value="entregue">
                                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded text-xs font-black hover:bg-blue-700 transition-colors uppercase tracking-tighter">Marcar como Entregue</button>
                                            </form>
                                            <?php if ($reserva['telefone']): ?>
                                                <a href="https://wa.me/<?= preg_replace('/\D/', '', $reserva['telefone']) ?>" target="_blank" class="p-2 bg-green-100 text-green-600 rounded hover:bg-green-200">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-xs text-gray-400 italic px-1">Sem entregas pendentes.</p>
                            <?php endif; ?>
                        </div>

                        <!-- DEVOLUÇÕES -->
                        <div class="space-y-4">
                            <h3 class="text-xs font-bold text-orange-600 uppercase tracking-widest flex items-center px-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                Devoluções <?= isset($atividades['devolucoes']) ? '('.count($atividades['devolucoes']).')' : '(0)' ?>
                            </h3>

                            <?php if (isset($atividades['devolucoes'])): ?>
                                <?php foreach ($atividades['devolucoes'] as $reserva): ?>
                                    <div class="bg-white border-l-4 border-orange-500 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow border border-gray-100">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-black text-gray-900 text-lg"><?= $reserva['horario_devolucao'] ? date('H:i', strtotime($reserva['horario_devolucao'])) : 'A combinar' ?></span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-orange-50 text-orange-600 uppercase">Com Cliente</span>
                                        </div>
                                        
                                        <h4 class="font-bold text-gray-800 leading-tight"><?= htmlspecialchars($reserva['nome_completo']) ?></h4>
                                        
                                        <div class="mt-2 flex items-start text-sm">
                                            <svg class="w-4 h-4 text-orange-500 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="text-orange-700 font-medium"><?= htmlspecialchars($reserva['local_devolucao'] ?: 'A combinar') ?></span>
                                        </div>

                                        <div class="mt-3 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                            <strong class="text-gray-700">Produtos:</strong><br>
                                            <?php foreach ($reserva['produtos'] as $p) echo "• " . htmlspecialchars($p['produto_nome']) . "<br>"; ?>
                                        </div>

                                        <?php if ($reserva['obs_logistica']): ?>
                                            <div class="mt-3 p-2 bg-yellow-50 border border-yellow-100 rounded text-xs italic text-yellow-800">
                                                "<?= htmlspecialchars($reserva['obs_logistica']) ?>"
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-4 flex gap-2">
                                            <form method="POST" action="/admin/reservas/<?= $reserva['id'] ?>/update-status" class="flex-1">
                                                <input type="hidden" name="status" value="concluido">
                                                <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded text-xs font-black hover:bg-orange-700 transition-colors uppercase tracking-tighter">Confirmar Recebimento</button>
                                            </form>
                                            <?php if ($reserva['telefone']): ?>
                                                <a href="https://wa.me/<?= preg_replace('/\D/', '', $reserva['telefone']) ?>" target="_blank" class="p-2 bg-green-100 text-green-600 rounded hover:bg-green-200">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-xs text-gray-400 italic px-1">Sem devoluções pendentes.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
