<?php

require_once 'src/Simplex2Solver.php';
require_once 'src/LpPrinter.php';
require_once 'src/Rule/MinToMaxZielfunktion.php';
require_once 'src/Rule/Schlupfvariablen.php';
require_once 'src/Rule/BasisloesungHerstellen.php';
require_once 'src/Rule/SimplexIteration.php';

$lpPrinter = new LpPrinter();

$minToMaxRule = new \Rule\MinToMaxZielfunktion();
$schlupfvariablenRule = new \Rule\Schlupfvariablen();
$basisloesungRule = new \Rule\BasisloesungHerstellen();
$simplexIterationRule = new \Rule\SimplexIteration();

$solver = new Simplex2Solver(
    $lpPrinter,
    $minToMaxRule,
    $schlupfvariablenRule,
    $basisloesungRule,
    $simplexIterationRule
);

$lp = require 'lp.php';
$solver->run($lp);
