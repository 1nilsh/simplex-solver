<?php

use Rule\BasisloesungHerstellen;
use Rule\MinToMaxZielfunktion;
use Rule\Schlupfvariablen;
use Rule\SimplexIteration;

class Simplex2Solver
{
    private LpPrinter $printer;
    private MinToMaxZielfunktion $minToMaxRule;
    private Schlupfvariablen $schlupfvariablenRule;
    private BasisloesungHerstellen $basisloesungRule;
    private SimplexIteration $simplexIterationRule;

    public function __construct(
        LpPrinter $printer,
        MinToMaxZielfunktion $minToMaxRule,
        Schlupfvariablen $schlupfvariablenRule,
        BasisloesungHerstellen $basisloesungRule,
        SimplexIteration $simplexIterationRule
    )
    {
        $this->printer = $printer;
        $this->minToMaxRule = $minToMaxRule;
        $this->schlupfvariablenRule = $schlupfvariablenRule;
        $this->basisloesungRule = $basisloesungRule;
        $this->simplexIterationRule = $simplexIterationRule;
    }

    public function run(array $lp): void
    {
        echo 'Ausgansmodell: ' . PHP_EOL;
        $this->printer->print($lp);

        echo 'Min zu Max: ' . PHP_EOL;
        $lp = $this->minToMaxRule->apply($lp);
        $this->printer->print($lp);

        echo 'Schlupfvariablen: ' . PHP_EOL;
        $lp = $this->schlupfvariablenRule->apply($lp, 3);
        $this->printer->print($lp);

        echo 'Basislösung: ' . PHP_EOL;
        $lp = $this->basisloesungRule->apply($lp);
        $this->printer->print($lp);

        echo 'Simplex Iteration 1: ' . PHP_EOL;
        $lp = $this->simplexIterationRule->apply($lp);
        $this->printer->print($lp);
    }
}
