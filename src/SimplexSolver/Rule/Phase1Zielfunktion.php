<?php

namespace SimplexSolver\Rule;

class Phase1Zielfunktion
{
    public function apply(array $lp): array
    {
        $sZielfunktion = [
            'typ' => 'max',
            'b' => 0,
            'x' => [
            ]
        ];

        for ($i = 0; $i < sizeof($lp['st']); $i++) {
            if ($lp['st'][$i]['b'] > 0) continue;

            $sZielfunktion['b'] += $lp['st'][$i]['b'];
            $sZielfunktion['x'] = $this->mergeX($sZielfunktion['x'], $lp['st'][$i]['x']);
        }

        $lp['szf'] = $sZielfunktion;

        return $lp;
    }

    private function mergeX(array $xArray1, array $xArray2): array
    {
        $neuXArray = $xArray1;

        foreach ($xArray2 as $variable => $koeffizient) {
            if(!isset($neuXArray[$variable])) {
                $neuXArray[$variable] = $koeffizient;
            } else {
                $neuXArray[$variable] += $koeffizient;
            }
        }

        foreach ($neuXArray as $variable => $koeffizient) {
            if ($koeffizient == 0) {
                unset($neuXArray[$variable]);
            }
        }

        return $neuXArray;
    }
}
