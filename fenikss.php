<?php

$payout = [
    "A" => 10,
    "B" => 20,
    "C" => 30,
    "D" => 40,
    "E" => 50
];
$symbols = array_keys($payout);
$validBets = [10, 20, 40, 80];
$cash = (int) readline("Insert coins: ");
$gameIsLive = true;

while($gameIsLive) {
    $bet = (int)readline("Enter bet amount (10, 20, 40, 80): ");
    if ($cash < $bet) {
        echo "Not enough balance for bet! Try sufficient amount!" . PHP_EOL;
        continue;
    }
    if (!in_array($bet, $validBets)) {
        echo "Bet not valid! Valid bets are $validBets[0], $validBets[1], $validBets[2], $validBets[3]" . PHP_EOL;
        continue;
    }
    $multiplier = $bet / 10;

    $board = [];
    $rows = 3;
    $columns = 4;

    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $columns; $c++) {
            $board[$r][$c] = $symbols[array_rand($symbols)];
        }
    }

    foreach ($board as $row) {
        foreach ($row as $symbol) {
            echo $symbol . ' ';
        }
        echo PHP_EOL;
    }

    $conditions = [
        [
            [0, 0], [0, 1], [0, 2], [0, 3]
        ],
        [
            [1, 0], [1, 1], [1, 2], [1, 3]
        ],
        [
            [2, 0], [2, 1], [2, 2], [2, 3]
        ],
        [
            [0, 0], [0, 1], [1, 2], [2, 3]
        ],
        [
            [2, 0], [2, 1], [1, 2], [0, 3]
        ],
        [
            [0, 0], [1, 1], [2, 2], [2, 3]
        ],
        [
            [2, 0], [1, 1], [0, 2], [0, 3]
        ],
        [
            [2, 0], [1, 1], [0, 2], [0, 3]
        ],
        [
            [0, 0], [1, 0], [2, 0]
        ],
        [
            [0, 1], [1, 1], [2, 1]
        ],
        [
            [0, 2], [1, 2], [2, 2]
        ],
        [
            [0, 3], [1, 3], [2, 3]
        ]
    ];

    $win = 0;

    foreach ($conditions as $condition) {
        $x = [];
        foreach ($condition as $positions) {
            $row = $positions[0];
            $column = $positions[1];
            $x[] = $board[$row][$column];
        }
        if (count(array_unique($x)) == 1) {
            $win += $payout[$x[0]] * $multiplier;
        }
    }

    echo "You won " . $win . PHP_EOL;
    echo "Balance : " . ($cash = $cash - $bet + $win) . PHP_EOL;
    if  ($cash < 1) {
        $gameIsLive = false;
        echo "Your balance has run out!" . PHP_EOL;
        exit;
    }
    $playAgain = readline("Play again? (y/n)  ");
    if ($playAgain === 'n') {
        $gameIsLive = false;
        echo "Thank you for playing! Paying out: $cash rupees!" . PHP_EOL;
    }
}