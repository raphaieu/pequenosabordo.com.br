<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    public function generateContract($reserva, $produto)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);

        // Calcula dias e valor
        $dataInicio = new \DateTime($reserva['data_inicio']);
        $dataFim = new \DateTime($reserva['data_fim']);
        $dias = $dataInicio->diff($dataFim)->days;
        
        $precoPorDia = $dias <= 5 ? $produto['precoCurto'] : $produto['precoLongo'];
        $valorTotal = $dias * $precoPorDia;

        $html = $this->getContractHtml($reserva, $produto, $dias, $valorTotal, $precoPorDia);

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    private function getContractHtml($reserva, $produto, $dias, $valorTotal, $precoPorDia)
    {
        $dataAtual = date('d/m/Y');
        $dataInicio = date('d/m/Y', strtotime($reserva['data_inicio']));
        $dataFim = date('d/m/Y', strtotime($reserva['data_fim']));
        
        // Prepara valores que podem ser null
        $tipoInstalacao = isset($produto['tipoInstalacao']) && $produto['tipoInstalacao'] ? $produto['tipoInstalacao'] : 'N/A';
        $orientacao = isset($produto['orientacao']) && $produto['orientacao'] ? $produto['orientacao'] : 'N/A';

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            padding: 20px;
        }
        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        h2 {
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .contract-info {
            margin-bottom: 20px;
        }
        .contract-info p {
            margin: 5px 0;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
        }
        .signature-box {
            width: 45%;
            border-top: 1px solid #000;
            padding-top: 10px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        table td:first-child {
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <h1>CONTRATO DE LOCAÇÃO DE PRODUTO INFANTIL</h1>
    
    <div class="contract-info">
        <p><strong>Data do Contrato:</strong> {$dataAtual}</p>
    </div>

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

    <h2>DADOS DO PRODUTO</h2>
    <table>
        <tr>
            <td>Produto:</td>
            <td>{$produto['produto_nome']}</td>
        </tr>
        <tr>
            <td>Marca:</td>
            <td>{$produto['produto_marca']}</td>
        </tr>
        <tr>
            <td>Tipo de Instalação:</td>
            <td>{$tipoInstalacao}</td>
        </tr>
        <tr>
            <td>Orientação:</td>
            <td>{$orientacao}</td>
        </tr>
    </table>

    <h2>PERÍODO DE LOCAÇÃO</h2>
    <table>
        <tr>
            <td>Data de Início:</td>
            <td>{$dataInicio}</td>
        </tr>
        <tr>
            <td>Data de Término:</td>
            <td>{$dataFim}</td>
        </tr>
        <tr>
            <td>Período:</td>
            <td>{$dias} dia(s)</td>
        </tr>
    </table>

    <h2>VALORES</h2>
    <table>
        <tr>
            <td>Preço por dia:</td>
            <td>R$ " . number_format($precoPorDia, 2, ',', '.') . "</td>
        </tr>
        <tr>
            <td>Total de dias:</td>
            <td>{$dias} dia(s)</td>
        </tr>
        <tr>
            <td><strong>Valor Total:</strong></td>
            <td><strong>R$ " . number_format($valorTotal, 2, ',', '.') . "</strong></td>
        </tr>
    </table>

    <h2>TERMOS E CONDIÇÕES</h2>
    <p>1. O locatário se compromete a devolver o produto no prazo estabelecido e em perfeito estado de conservação.</p>
    <p>2. Em caso de atraso na devolução, será cobrada multa proporcional ao período excedente.</p>
    <p>3. Em caso de danos ao produto, o locatário será responsável pelo reparo ou substituição do mesmo.</p>
    <p>4. O produto deve ser usado exclusivamente para o fim a que se destina.</p>
    <p>5. Este contrato é regido pelas leis brasileiras e qualquer litígio será resolvido no foro da comarca de Salvador-BA.</p>

    <div class="signature-section">
        <div class="signature-box">
            <p><strong>LOCADOR</strong></p>
            <p>Pequenos a Bordo</p>
            <p style="margin-top: 40px;">_________________________________</p>
        </div>
        <div class="signature-box">
            <p><strong>LOCATÁRIO</strong></p>
            <p>{$reserva['nome_completo']}</p>
            <p style="margin-top: 40px;">_________________________________</p>
        </div>
    </div>
</body>
</html>
HTML;
    }
}

