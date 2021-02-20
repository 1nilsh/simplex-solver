<?php

namespace SimplexSolver\Rule;

class Schlupfvariablen
{
    public function apply(array $lp, int $startname): array
    {
        $newLp = $lp;

        $n = $startname;
        foreach ($lp['st'] as $key => $value) {
            $schlupfKoeff = 0;
            if ($lp['st'][$key]['operator'] === '<=') {
                $schlupfKoeff = 1;
            }
            if ($lp['st'][$key]['operator'] === '>=') {
                $schlupfKoeff = -1;
            }

            $newLp['st'][$key]['x']['x' . $n] = $schlupfKoeff;
            $newLp['st'][$key]['operator'] = '=';

            $n++;
        }

        return $newLp;
    }
}
