<?php

require_once 'src/Simplex2Solver.php';
require_once 'src/LpPrinter.php';
require_once 'src/Rule/FreieVariableErsetzen.php';
require_once 'src/Rule/GleichungenZuUngleichungen.php';
require_once 'src/Rule/MinToMaxZielfunktion.php';
require_once 'src/Rule/Schlupfvariablen.php';
require_once 'src/Rule/BasisloesungHerstellen.php';
require_once 'src/Rule/Simplex2Iteration.php';

$lpPrinter = new LpPrinter();

$freieVariableErsetzenRule = new \Rule\FreieVariableErsetzen();
$gleichungenZuUngleichungenRule = new \Rule\GleichungenZuUngleichungen();
$minToMaxRule = new \Rule\MinToMaxZielfunktion();
$schlupfvariablenRule = new \Rule\Schlupfvariablen();
$basisloesungRule = new \Rule\BasisloesungHerstellen();
$simplexIterationRule = new \Rule\Simplex2Iteration();

$solver = new Simplex2Solver(
    $lpPrinter,
    $freieVariableErsetzenRule,
    $gleichungenZuUngleichungenRule,
    $minToMaxRule,
    $schlupfvariablenRule,
    $basisloesungRule,
    $simplexIterationRule
);

$lp = require 'lp.php';
$solver->run($lp);
