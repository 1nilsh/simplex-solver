<?php

namespace Rule;

class GleichungenZuUngleichungen
{
    public function apply(array $lp): array
    {
        $newLp = $lp;

        for ($i=0; $i<sizeof($lp['st']); $i++) {
            if ($lp['st'][$i]['operator'] !== '=') continue;

            unset($newLp['st'][$i]);

            $newLp['st'][] = $lp['st'][$i];
            $newLp['st'][array_key_last($newLp['st'])]['operator'] = '<=';

            $newLp['st'][] = $lp['st'][$i];
            $newLp['st'][array_key_last($newLp['st'])]['operator'] = '>=';
        }

        $newLp['st'] = array_values($newLp['st']);

        return $newLp;
    }
}
