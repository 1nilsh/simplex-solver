<?php

namespace SimplexSolver\Rule;

class GleichungenZuUngleichungen
{
    public function apply(array $lp): array
    {
        $newLp = $lp;

        for ($i=0; $i<sizeof($lp['st']); $i++) {
            if ($lp['st'][$i]['operator'] !== '=') continue;

            array_splice($newLp['st'], $i, 1, [
                $lp['st'][$i],
                $lp['st'][$i],
            ]);

            $newLp['st'][$i]['operator'] = '>=';
            $newLp['st'][$i+1]['operator'] = '<=';
        }

        $newLp['st'] = array_values($newLp['st']);

        return $newLp;
    }
}
