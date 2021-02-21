<?php

namespace SimplexSolver\Factory;

use DependencyInjection\DiContainer;
use Printer\LpPrinter;
use SimplexSolver\Rule\BasisloesungHerstellen;
use SimplexSolver\Rule\FreieVariableErsetzen;
use SimplexSolver\Rule\GleichungenZuUngleichungen;
use SimplexSolver\Rule\MinToMaxZielfunktion;
use SimplexSolver\Rule\Schlupfvariablen;
use SimplexSolver\Rule\Simplex1Iteration;
use SimplexSolver\Rule\SimplexIteration;
use SimplexSolver\SimplexSolver;

class SimplexSolverFactory
{
    private DiContainer $container;

    /**
     * SimplexSolverFactory constructor.
     * @param DiContainer $container
     */
    public function __construct(DiContainer $container)
    {
        $this->container = $container;
    }

    public function build(): SimplexSolver
    {
        return new SimplexSolver(
            $this->container->get(LpPrinter::class),
            $this->container->get(FreieVariableErsetzen::class),
            $this->container->get(GleichungenZuUngleichungen::class),
            $this->container->get(MinToMaxZielfunktion::class),
            $this->container->get(Schlupfvariablen::class),
            $this->container->get(BasisloesungHerstellen::class),
            $this->container->get(Simplex1Iteration::class),
            $this->container->get(SimplexIteration::class),
        );
    }
}
