<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    public function generateContract($reserva, $produtos)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);

        if (!is_array($produtos)) {
            $produtos = [$produtos];
        }

        // Calcula dias (incluindo o dia inicial)
        $dataInicio = new \DateTime($reserva['data_inicio']);
        $dataFim = new \DateTime($reserva['data_fim']);
        $dias = $dataInicio->diff($dataFim)->days + 1;
        
        $produtosCalculados = [];
        $valorTotal = 0;
        
        foreach ($produtos as $produto) {
            // Usa o valor cobrado salvo na reserva como Preço por Dia
            $precoPorDia = $produto['valor_cobrado'] ?? 0;
            $valorProduto = $precoPorDia * $dias;
            $valorTotal += $valorProduto;
            
            $produtosCalculados[] = [
                'produto' => $produto,
                'precoFinal' => $valorProduto,
                'precoPorDia' => $precoPorDia
            ];
        }

        $formaPagamento = $reserva['forma_pagamento'] ?? 'PIX';
        $html = $this->getContractHtml($reserva, $produtosCalculados, $dias, $valorTotal, $formaPagamento);

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    private function getContractHtml($reserva, $produtosCalculados, $dias, $valorTotal, $formaPagamento)
    {
        $dataAtual = date('d/m/Y');
        $dataInicio = date('d/m/Y', strtotime($reserva['data_inicio']));
        $dataFim = date('d/m/Y', strtotime($reserva['data_fim']));
        
        $valorTotalFormatado = number_format($valorTotal, 2, ',', '.');
        
        // Monta tabela de produtos
        $produtosHtml = '';
        foreach ($produtosCalculados as $item) {
            $produto = $item['produto'];
            $precoPorDia = $item['precoPorDia'];
            $valorProduto = $item['precoFinal'];
            $tipoInstalacao = isset($produto['tipoInstalacao']) && $produto['tipoInstalacao'] ? $produto['tipoInstalacao'] : 'N/A';
            $orientacao = isset($produto['orientacao']) && $produto['orientacao'] ? $produto['orientacao'] : 'N/A';
            $precoPorDiaFormatado = number_format($precoPorDia, 2, ',', '.');
            $valorProdutoFormatado = number_format($valorProduto, 2, ',', '.');
            
            $produtosHtml .= <<<HTML
        <tr>
            <td colspan="2" style="background-color: #f5f5f5; font-weight: bold; padding: 8px;">
                {$produto['produto_nome']} - {$produto['produto_marca']}
            </td>
        </tr>
        <tr>
            <td>Tipo de Instalação:</td>
            <td>{$tipoInstalacao}</td>
        </tr>
        <tr>
            <td>Orientação:</td>
            <td>{$orientacao}</td>
        </tr>
        <tr>
            <td>Preço por dia:</td>
            <td>R$ {$precoPorDiaFormatado}</td>
        </tr>
        <tr>
            <td>Valor deste produto ({$dias} dias):</td>
            <td><strong>R$ {$valorProdutoFormatado}</strong></td>
        </tr>
HTML;
        }

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        h2 {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        p {
            font-size: 12px;
        }
        .contract-info {
            margin: 50px auto 0;
            text-align: center;
        }
        .contract-info p {
            margin: 4px 0;
        }
        .signature-section {
            margin: 12px auto 0;
            display: flex;
            justify-content: center;
        }
        .signature-box {
            width: 100%;
            padding-top: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table td {
            padding: 6px;
            border: 1px solid #ddd;
        }
        table td:first-child {
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <h1>CONTRATO DE LOCAÇÃO DE EQUIPAMENTOS INFANTIS</h1>
    
    <h2>DADOS DO LOCADOR</h2>
    <table>
        <tr>
            <td>Nome Completo:</td>
            <td>Pequenos a Bordo - Priscila Martins Pimenta</td>
        </tr>
        <tr>
            <td>CPF:</td>
            <td>008.158.635-35</td>
        </tr>
        <tr>
            <td>Endereço:</td>
            <td>Rua Edmundo Loureiro, 02 - Itapuã, Salvador/BA, CEP 41.630-395</td>
        </tr>
    </table>

    <h2>DADOS DO LOCATÁRIO</h2>
    <table>
        <tr>
            <td>Nome Completo:</td>
            <td>{$reserva['nome_completo']}</td>
        </tr>
        <tr>
            <td>CPF:</td>
            <td>{$reserva['cpf']}</td>
        </tr>
        <tr>
            <td>Endereço:</td>
            <td>{$reserva['endereco']}</td>
        </tr>
    </table>

    <h2>CLÁUSULA 1 - OBJETO</h2>
    <p>O presente contrato tem por objeto a locação do(s) seguinte(s) item(ns) infantil(is):</p>
    <table>
{$produtosHtml}
    </table>

    <h2>CLÁUSULA 2 - PRAZO</h2>
    <p>A locação será realizada no período de {$dataInicio} a {$dataFim}, totalizando {$dias} dia(s).</p>
    
    <h2>CLÁUSULA 3 - VALOR E PAGAMENTO</h2>
    <p>O LOCATÁRIO pagará ao LOCADOR o valor total de R$ {$valorTotalFormatado} pela locação, via {$formaPagamento}, até o momento da entrega.</p>
    <table>
        <tr>
            <td>Total de dias:</td>
            <td>{$dias} dia(s)</td>
        </tr>
        <tr>
            <td><strong>Valor Total (todos os produtos):</strong></td>
            <td><strong>R$ {$valorTotalFormatado}</strong></td>
        </tr>
        <tr>
            <td><strong>Forma de Pagamento:</strong></td>
            <td><strong>{$formaPagamento}</strong></td>
        </tr>
    </table>

    <h2>CLÁUSULA 4 - ENTREGA E DEVOLUÇÃO</h2>
    <p>4.1 A entrega será realizada no endereço acordado.</p>
    <p>4.2 A devolução deverá ocorrer até o final do dia acordado.</p>
    <p>4.3 Em caso de atraso, será cobrada multa de R$ 20,00 por dia.</p>
    
    <h2>CLÁUSULA 5 - CONSERVAÇÃO E USO</h2>
    <p>O LOCATÁRIO se compromete a zelar pelos itens. Em caso de danos ou perda, será cobrado o valor de reposição.</p>
    
    <h2>CLÁUSULA 6 - CANCELAMENTO</h2>
    <p>Cancelamento com menos de 24h: retenção de 50%.</p>
    <p>Com mais de 24h: reembolso integral.</p>
    
    <h2>CLÁUSULA 7 - RESPONSABILIDADE</h2>
    <p>O LOCADOR não se responsabiliza por acidentes causados por uso inadequado dos itens.</p>

    <h2>CLÁUSULA 8 - FORO</h2>
    <p>Fica eleito o foro da Comarca de Salvador/BA.</p>

    <div class="contract-info">
        <p><strong>Salvador/BA, {$dataAtual}</strong></p>
        <div class="signature-section">
            <div class="signature-box">
                <p style="margin-top: 40px;">______________________________________</p>
                <p><strong>Pequenos a Bordo<br>LOCADOR</strong></p>
            </div>
            <p>&nbsp;</p>
            <div class="signature-box">
                <p style="margin-top: 40px;">______________________________________</p>
                <p><strong>{$reserva['nome_completo']}<br>LOCATÁRIO</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
