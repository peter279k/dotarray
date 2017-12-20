<?php
    /**
     * @Author  Anton Zinovyev
     */

    namespace xobotyi\benchmarks;

    include_once __DIR__ . '/../vendor/autoload.php';

    use Arrayy\Arrayy;
    use xobotyi\A;

    $arr = [
        "this" => [
            "is" => [
                "quite" => [
                    "simple"     => [
                        "benchmark" => "yeee!",
                        "nullval"   => null,
                    ],
                    "hard"       => function () { },
                    "super.hard" => "benchmark",
                ],
            ],
        ],
    ];

    echo "Test array:\n" . print_r($arr, true);

    echo "\n\n\n# voku/arrayy: \n";
    echo "\nGet result [this.is.quite.simple.benchmark]: " . Arrayy::create($arr)
                                                                   ->get('this.is.quite.simple.benchmark', 'default value');
    echo "\nGet result [this.is.quite.simple.nullval]: " . Arrayy::create($arr)
                                                                 ->get('this.is.quite.simple.nullval', 'default value');
    echo "\nGet result [this.is.quite.hard.benchmark]: FAILS WITH FATAL ERROR";
    # Id you'll uncomment it it will fail with fatal
    // . Arrayy::create($arr)->get('this.is.quite.hard.benchmark', 'default value');
    echo "\nGet result [this.is.quite.super\\.hard]: " . Arrayy::create($arr)
                                                               ->get('this.is.quite.super\\.hard', 'default value');

    #bench
    echo "\n" . 'GET with Arrayy\\Arrayy object prepared [$arrayy->get(\'this.is.quite.simple.benchmark\')]: ';
    $arrayy = Arrayy::create($arr);
    $start  = microtime(true);
    for ($i = 0; $i < 100000; $i++) {
        $arrayy->get('this.is.quite.simple.benchmark');
    }
    echo(microtime(true) - $start);
    echo "\n" . 'SET with Arrayy\\Arrayy object prepared [$arrayy->set(\'this.is.quite.simple.benchmark\', \'test!\')]: ';
    $arrayy = Arrayy::create($arr);
    $start  = microtime(true);
    for ($i = 0; $i < 100000; $i++) {
        $arrayy->set('this.is.quite.simple.benchmark', 'test!');
    }
    echo(microtime(true) - $start);

    echo "\n\n\n# adbario/php-dot-notation: \n";
    echo "\nGet result [this.is.quite.simple.benchmark]: " . dot($arr)->get('this.is.quite.simple.benchmark', 'default value');
    echo "\nGet result [this.is.quite.simple.nullval]: " . dot($arr)->get('this.is.quite.simple.nullval', 'default value');
    echo "\nGet result [this.is.quite.hard.benchmark]: " . dot($arr)->get('this.is.quite.hard.benchmark', 'default value');
    echo "\nGet result [this.is.quite.super\\.hard]: " . dot($arr)->get('this.is.quite.super\\.hard', 'default value');

    #bench
    echo "\n" . 'GET with Adbar\\Dot object prepared [$dot->get($arr, \'this.is.quite.simple.benchmark\')]: ';
    $start = microtime(true);
    $dot   = dot($arr);
    for ($i = 0; $i < 100000; $i++) {
        $dot->get('this.is.quite.simple.benchmark');
    }
    echo(microtime(true) - $start);
    echo "\n" . 'SET with Adbar\\Dot object prepared [$dot->set($arr, \'this.is.quite.simple.benchmark\', \'test!\')]: ';
    $start = microtime(true);
    $dot   = dot($arr);
    for ($i = 0; $i < 100000; $i++) {
        $dot->set('this.is.quite.simple.benchmark', 'test!');
    }
    echo(microtime(true) - $start);

    echo "\n\n\n# xobotyi/dotarray: \n";
    echo "\nGet result [this.is.quite.simple.benchmark]: " . A::get($arr, 'this.is.quite.simple.benchmark', 'default value');
    echo "\nGet result [this.is.quite.simple.nullval]: " . A::get($arr, 'this.is.quite.simple.nullval', 'default value');
    echo "\nGet result [this.is.quite.hard.benchmark]: " . A::get($arr, 'this.is.quite.hard.benchmark', 'default value');
    echo "\nGet result [this.is.quite.super\\.hard]: " . A::get($arr, 'this.is.quite.super\\.hard', 'default value');

    #bench
    echo "\n" . 'GET with tatic A::get [A::get($arr, \'this.is.quite.simple.benchmark\')]: ';
    $start = microtime(true);
    for ($i = 0; $i < 100000; $i++) {
        A::get($arr, 'this.is.quite.simple.benchmark');
    }
    echo(microtime(true) - $start);
    echo "\n" . 'SET with tatic A::get [A::set($arr, \'this.is.quite.simple.benchmark\', \'test!\')]: ';
    $start = microtime(true);
    for ($i = 0; $i < 100000; $i++) {
        A::set($arr, 'this.is.quite.simple.benchmark', 'test!');
    }
    echo(microtime(true) - $start);