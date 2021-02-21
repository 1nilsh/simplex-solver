<?php

namespace SimplexSolver\Rule;

class BasisloesungHerstellen
{
    public function apply(array $lp): array
    {
        $newLp = $lp;

        foreach ($lp['st'] as $key => $restriktionszeile) {
            end($restriktionszeile['x']);
            $schlupfvariable = key($restriktionszeile['x']);
            $newLp['st'][$key]['schranke'] = $schlupfvariable;
            $schlupfKoeffizient = $restriktionszeile['x'][$schlupfvariable];
            reset($restriktionszeile['x']);

            if ($schlupfKoeffizient < 0) {
                $newLp['st'][$key]['b'] = -$restriktionszeile['schranke'];
            } else{
                $newLp['st'][$key]['b'] = $restriktionszeile['schranke'];
            }

            array_pop($newLp['st'][$key]['x']);
            array_pop($restriktionszeile['x']);

            if ($schlupfKoeffizient > 0) {
                foreach ($restriktionszeile['x'] as $variable => $koeffizient) {
                    $newLp['st'][$key]['x'][$variable] = (-1) * $koeffizient;
                }
            }
        }

        return $newLp;
    }
}
