<?php

namespace SimplexSolver\Rule;

class FreieVariableErsetzen
{
    public function apply(array $lp, string $variablenName): array
    {
        $newLp = $lp;

        if (isset($lp['zf']['x'][$variablenName])){
            $newLp['zf']['x'][$variablenName.'~'] = (-1) * $lp['zf']['x'][$variablenName];
            ksort($newLp['zf']['x'], SORT_STRING);
        }


        for ($i=0; $i<sizeof($lp['st']); $i++) {
            if (!isset($lp['st'][$i]['x'][$variablenName])) continue;

            $newLp['st'][$i]['x'][$variablenName.'~'] = (-1) * $lp['st'][$i]['x'][$variablenName];
            ksort($newLp['st'][$i]['x'], SORT_STRING);
        }

        return $newLp;
    }
}
