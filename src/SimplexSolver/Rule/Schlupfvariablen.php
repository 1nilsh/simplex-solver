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

            switch ($lp['st'][$key]['operator']) {
                case '>=':
                    $schlupfKoeff = -1;
                    break;
                case '<=':
                    $schlupfKoeff = 1;
                    break;
            }

            $newLp['st'][$key]['x']['x' . $n] = $schlupfKoeff;
            $newLp['st'][$key]['operator'] = '=';

            $n++;
        }

        return $newLp;
    }
}
