<?php

namespace SimplexSolver;

use Printer\LpPrinter;
use SimplexSolver\Rule\BasisloesungHerstellen;
use SimplexSolver\Rule\FreieVariableErsetzen;
use SimplexSolver\Rule\GleichungenZuUngleichungen;
use SimplexSolver\Rule\MinToMaxZielfunktion;
use SimplexSolver\Rule\Phase1Zielfunktion;
use SimplexSolver\Rule\Schlupfvariablen;
use SimplexSolver\Rule\SimplexIteration;

class SimplexSolver
{
    private LpPrinter $printer;
    private FreieVariableErsetzen $freieVariableErsetzenRule;
    private GleichungenZuUngleichungen $gleichungenZuUngleichungenRule;
    private MinToMaxZielfunktion $minToMaxRule;
    private Schlupfvariablen $schlupfvariablenRule;
    private BasisloesungHerstellen $basisloesungRule;
    private Phase1Zielfunktion $phase1ZielfunktionRule;
    private SimplexIteration $simplexIterationRule;

    public function __construct(
        LpPrinter $printer,
        FreieVariableErsetzen $freieVariableErsetzenRule,
        GleichungenZuUngleichungen $gleichungenZuUngleichungenRule,
        MinToMaxZielfunktion $minToMaxRule,
        Schlupfvariablen $schlupfvariablenRule,
        BasisloesungHerstellen $basisloesungRule,
        Phase1Zielfunktion $phase1ZielfunktionRule,
        SimplexIteration $simplexIterationRule
    )
    {
        $this->printer = $printer;
        $this->freieVariableErsetzenRule = $freieVariableErsetzenRule;
        $this->gleichungenZuUngleichungenRule = $gleichungenZuUngleichungenRule;
        $this->minToMaxRule = $minToMaxRule;
        $this->schlupfvariablenRule = $schlupfvariablenRule;
        $this->basisloesungRule = $basisloesungRule;
        $this->phase1ZielfunktionRule = $phase1ZielfunktionRule;
        $this->simplexIterationRule = $simplexIterationRule;
    }

    public function run(array $lp): void
    {
        $this->executeSteps(
            [
                'Ausgangsmodell',
                'Schlupfvariablen',
                'Basislösung',
                'Phase1 Zielfunktion',
                'Simplex1 Iteration',
                'Simplex1 Iteration',
            ],
            $lp
        );
    }

    private function executeSteps(array $steps, array $lp): void
    {
        foreach ($steps as $step) {
            switch ($step) {
                case 'Ausgangsmodell':
                    echo 'Ausgansmodell:' . PHP_EOL;
                    $this->printer->print($lp);
                    break;

                case 'Freie Variablen ersetzen':
                    echo 'Freie Variablen ersetzen: ' . PHP_EOL;
                    $lp = $this->freieVariableErsetzenRule->apply($lp, 'x3');
                    $this->printer->print($lp);
                    break;

                case 'Gleichungen zu Ungleichungen':
                    echo 'Gleichungen zu Ungleichungen:' . PHP_EOL;
                    $lp = $this->gleichungenZuUngleichungenRule->apply($lp);
                    $this->printer->print($lp);
                    break;

                case 'Min zu Max':
                    echo 'Min zu Max:' . PHP_EOL;
                    $lp = $this->minToMaxRule->apply($lp);
                    $this->printer->print($lp);
                    break;

                case 'Schlupfvariablen':
                    echo 'Schlupfvariablen: ' . PHP_EOL;
                    $lp = $this->schlupfvariablenRule->apply($lp, 3);
                    $this->printer->print($lp);
                    break;

                case 'Basislösung':
                    echo 'Basislösung:' . PHP_EOL;
                    $lp = $this->basisloesungRule->apply($lp);
                    $this->printer->print($lp);
                    break;

                case 'Phase1 Zielfunktion':
                    echo 'Phase1 Zielfunktion:' . PHP_EOL;
                    $lp = $this->phase1ZielfunktionRule->apply($lp);
                    $this->printer->print($lp);
                    break;

                case 'Simplex1 Iteration':
                    echo 'Simplex1 Iteration:' . PHP_EOL;
                    $lp = $this->simplexIterationRule->apply($lp);
                    $this->printer->print($lp);
                    break;

                case 'Simplex2 Iteration':
                    echo 'Simplex2 Iteration:' . PHP_EOL;
                    $lp = $this->simplexIterationRule->apply($lp);
                    $this->printer->print($lp);
                    break;
            }
        }
    }
}
