<?php

namespace SimplexSolver\Rule;

use Exception;

class SimplexIteration
{
    private Basistausch $basistauschRule;

    public function __construct(Basistausch $basistauschRule)
    {
        $this->basistauschRule = $basistauschRule;
    }


    public function apply(array $lp, string $zfName = 'zf'): array
    {
        $newLp = $lp;

        $groessterKoeff = 0;
        $groessterKoeffBei = null;
        foreach ($lp[$zfName]['x'] as $variable => $koeffizient) {
            if ($koeffizient > $groessterKoeff) {
                $groessterKoeff = $koeffizient;
                $groessterKoeffBei = $variable;
            }
        }

        echo 'größter koeff: ' . $groessterKoeffBei . PHP_EOL;

        if ($groessterKoeff === 0) {
            throw new Exception('Keine Simplex Iteration mehr möglich.');
        }

        $minBeschraenkung = PHP_INT_MAX;
        $minBeschraenkungBei = null;
        foreach ($lp['st'] as $restriktionszeile) {
            if(!isset($restriktionszeile['x'][$groessterKoeffBei]) || $restriktionszeile['x'][$groessterKoeffBei] == 0) continue;
            $beschr = $restriktionszeile['b'] / ($restriktionszeile['x'][$groessterKoeffBei] * (-1));
            if ($beschr >= 0 && $beschr < $minBeschraenkung) {
                $minBeschraenkung = $beschr;
                $minBeschraenkungBei = $restriktionszeile['schranke'];
            }
        }

        echo 'min beschr: ' . $minBeschraenkungBei . PHP_EOL . PHP_EOL;

        return $this->basistauschRule->apply($newLp, $groessterKoeffBei, $minBeschraenkungBei);
    }


}
