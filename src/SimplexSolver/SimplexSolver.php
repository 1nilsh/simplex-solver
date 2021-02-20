<?php

namespace SimplexSolver;

use Printer\LpPrinter;
use SimplexSolver\Rule\BasisloesungHerstellen;
use SimplexSolver\Rule\FreieVariableErsetzen;
use SimplexSolver\Rule\GleichungenZuUngleichungen;
use SimplexSolver\Rule\MinToMaxZielfunktion;
use SimplexSolver\Rule\Schlupfvariablen;
use SimplexSolver\Rule\Simplex2Iteration;

class SimplexSolver
{
    private LpPrinter $printer;
    private FreieVariableErsetzen $freieVariableErsetzenRule;
    private GleichungenZuUngleichungen $gleichungenZuUngleichungenRule;
    private MinToMaxZielfunktion $minToMaxRule;
    private Schlupfvariablen $schlupfvariablenRule;
    private BasisloesungHerstellen $basisloesungRule;
    private Simplex2Iteration $simplexIterationRule;

    public function __construct(
        LpPrinter $printer,
        FreieVariableErsetzen $freieVariableErsetzenRule,
        GleichungenZuUngleichungen $gleichungenZuUngleichungenRule,
        MinToMaxZielfunktion $minToMaxRule,
        Schlupfvariablen $schlupfvariablenRule,
        BasisloesungHerstellen $basisloesungRule,
        Simplex2Iteration $simplexIterationRule
    )
    {
        $this->printer = $printer;
        $this->freieVariableErsetzenRule = $freieVariableErsetzenRule;
        $this->gleichungenZuUngleichungenRule = $gleichungenZuUngleichungenRule;
        $this->minToMaxRule = $minToMaxRule;
        $this->schlupfvariablenRule = $schlupfvariablenRule;
        $this->basisloesungRule = $basisloesungRule;
        $this->simplexIterationRule = $simplexIterationRule;
    }

    public function run(array $lp): void
    {
        echo 'Ausgansmodell: ' . PHP_EOL;
        $this->printer->print($lp);

        echo 'Freie Variablen ersetzen: ' . PHP_EOL;
        $lp = $this->freieVariableErsetzenRule->apply($lp, 'x3');
        $this->printer->print($lp);

        echo 'Gleichungen zu Ungleichungen: ' . PHP_EOL;
        $lp = $this->gleichungenZuUngleichungenRule->apply($lp);
        $this->printer->print($lp);

        echo 'Min zu Max: ' . PHP_EOL;
        $lp = $this->minToMaxRule->apply($lp);
        $this->printer->print($lp);

        echo 'Schlupfvariablen: ' . PHP_EOL;
        $lp = $this->schlupfvariablenRule->apply($lp, 4);
        $this->printer->print($lp);

//        echo 'Basislösung: ' . PHP_EOL;
//        $lp = $this->basisloesungRule->apply($lp);
//        $this->printer->print($lp);
//
//        echo 'Simplex Iteration 1: ' . PHP_EOL;
//        $lp = $this->simplexIterationRule->apply($lp);
//        $this->printer->print($lp);
    }
}
