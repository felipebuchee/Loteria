<?php

$loterias = [
    'Mega-Sena' => [
        'valoresAposta' => [
            6 => 5.00,
            7 => 35.00,
            8 => 140.00,
            9 => 420.00,
            10 => 1050.00,
            11 => 2310.00,
            12 => 4620.00,
            13 => 8580.00,
            14 => 15015.00,
            15 => 25025.00,
            16 => 40040.00,
            17 => 61880.00,
            18 => 92820.00,
            19 => 135660.00,
            20 => 193800.00,
        ],
        'minDezenas' => 6,
        'maxDezenas' => 20,
        'minNum' => 1,
        'maxNum' => 60,
    ],
    'Quina' => [
        'valoresAposta' => [
            5 => 2.50,
            6 => 15.00,
            7 => 52.50,
            8 => 140.00,
            9 => 315.00,
            10 => 630.00,
            11 => 1155.00,
            12 => 1980.00,
            13 => 3217.50,
            14 => 5005.00,
            15 => 7507.50,
        ],
        'minDezenas' => 5,
        'maxDezenas' => 15,
        'minNum' => 1,
        'maxNum' => 80,
    ],
    'Lotofácil' => [
        'valoresAposta' => [
            15 => 3.00,
            16 => 48.00,
            17 => 408.00,
            18 => 2448.00,
            19 => 11628.00,
            20 => 46512.00,
        ],
        'minDezenas' => 15,
        'maxDezenas' => 20,
        'minNum' => 1,
        'maxNum' => 25,
    ],
    'Lotomania' => [
        'valoresAposta' => [
            50 => 3.00,
        ],
        'minDezenas' => 50,
        'maxDezenas' => 50,
        'minNum' => 1,
        'maxNum' => 100,
    ],
    // Adicione outras loterias conforme necessário
];

function geraApostaAleatoria($minNum, $maxNum, $numDezenas) {
    $aposta = [];

    while (count($aposta) < $numDezenas) {
        $dezena = rand($minNum, $maxNum);
        if (!in_array($dezena, $aposta)) {
            $aposta[] = $dezena;
        }
    }
    sort($aposta);
    return $aposta;
}

function calculaTotalGasto($quantidade, $precoPorAposta) {
    return $quantidade * $precoPorAposta;
}

function exibeNumerosPossiveis($minNum, $maxNum) {
    
    echo "Números possíveis: ";
    for ($i = $minNum; $i <= $maxNum; $i++) {
        echo "$i ";
    }
    echo "\n";
}

function verificaResultado($numerosSorteados, $nossaAposta) {
    
    $numerosJogados = count($nossaAposta);
    $numerosAcertados = 0;
    
    for($i=0;$i<$numerosJogados;$i++){

        if(in_array($nossaAposta[$i], $numerosSorteados)){
            $numerosAcertados++;
        }
    }

    if ($numerosAcertados === count($numerosSorteados)) {
        
        echo "Parabéns! Você ganhou!\n";
        exibeSurpresa();

    } else if ($numerosAcertados === 0){
       
        echo "Eu sinto muito, mas você não acertou nenhuma dezena";

    } else {
        
        echo "Você não ganhou, mas você acertou $numerosAcertados dezenas. Mas quem sabe da próxima né?\n";

    }
}

function exibeSurpresa() {
    echo "Surpresa para você!\n";
    echo "  O \n";
    echo " /|\ \n";
    echo "  | \n";
    echo " / \ \n";
    echo "/   \ \n";
}



echo "Escolha a loteria:\n";
foreach ($loterias as $loteria => $params) {
    echo "- $loteria (Mínimo: {$params['minDezenas']}, Máximo: {$params['maxDezenas']})\n";
}

$jogoEscolhido = readline("Digite o nome da loteria desejada: ");
if (!isset($loterias[$jogoEscolhido])) {
    echo "Loteria não encontrada.\n";
    exit();
}

$params = $loterias[$jogoEscolhido];

echo "\nNúmeros possíveis para $jogoEscolhido: ";
exibeNumerosPossiveis($params['minNum'], $params['maxNum']);

$opcaoApostaAleatoria = readline("Deseja criar uma aposta aleatória? (s/n): ");
if (strtolower($opcaoApostaAleatoria) === 's') {
    
    do {
        $numDezenas = intval(readline("Quantos números você quer na aposta? "));

    } while ($numDezenas < $params['minDezenas'] || $numDezenas > $params['maxDezenas']);


    $numerosEscolhidos = geraApostaAleatoria($params['minNum'], $params['maxNum'], $params['minDezenas']);
    
    echo "Quantidade de apostas desejadas: ";
    $quantidadeApostas = intval(readline());

    $numerosSorteados = geraApostaAleatoria($params['minNum'], $params['maxNum'], $params['minDezenas']);
    
    echo "\nNúmeros sorteados: " . join(' ', $numerosSorteados) . "\n";
    
    if ($quantidadeApostas > 1) {
        echo "\nApostas aleatórias geradas pelo sistema:\n";
        for ($i = 0; $i < $quantidadeApostas; $i++) {
            $apostaAleatoria = geraApostaAleatoria($params['minNum'], $params['maxNum'], $params['minDezenas']);
            echo "Aposta " . ($i + 1) . ": " . join(' ', $apostaAleatoria) . "\n";

            verificaResultado($numerosSorteados, $apostaAleatoria);
            echo "\n";
        }
    } else if ($quantidadeApostas == 1){
        echo "\nAposta aleatória gerada pelo sistema:\n";
        for ($i = 0; $i < $quantidadeApostas; $i++) {
            $apostaAleatoria = geraApostaAleatoria($params['minNum'], $params['maxNum'], $params['minDezenas']);
            echo "Aposta " . ($i + 1) . ": " . join(' ', $apostaAleatoria) . "\n";

            verificaResultado($numerosSorteados, $apostaAleatoria);
            echo "\n";
        }
    }
} else if (strtolower($opcaoApostaAleatoria) === 'n'){ //Aqui começa a aposta gerada pelo usuario ----------------------------------------
    
    $numDezenas = explode(',', readline("Digite os números da(s) sua(s) aposta(s): "));
    $numerosEscolhidos = array_map('intval', $numDezenas);
    
    $quantidadeApostas = intval(readline("Quantidade de apostas que serão realizadas: \n"));

    if (count($numerosEscolhidos) < $params['minDezenas'] || count($numerosEscolhidos) > $params['maxDezenas']) {
        echo "Quantidade inválida de números para esta loteria.\n";
        exit();
    }

    foreach ($numerosEscolhidos as $numero) {
        if ($numero < $params['minNum'] || $numero > $params['maxNum']) {
            echo "Número fora do intervalo permitido para esta loteria.\n";
            exit();
        }
    }
    
    $numerosSorteados = geraApostaAleatoria($params['minNum'], $params['maxNum'], $params['minDezenas']);
    
    echo "\nNúmeros sorteados: " . join(' ', $numerosSorteados) . "\n";
    
    echo "\nAposta escolhida:\n";
    echo join(' ', $numerosEscolhidos) . "\n";
    verificaResultado($numerosSorteados, $numerosEscolhidos);
    echo "\n";

    //converte o tipo da variavel de array para inteiro
    $numDezenas = count($numDezenas);

} else {
    echo "Opção inválida.\n";
    exit();
}

$totalGasto = calculaTotalGasto($quantidadeApostas, $params['valoresAposta'][$numDezenas]);
echo "Total gasto em reais: R$ $totalGasto\n";
