<?php


namespace Rule;


class MinToMaxZielfunktion
{
    public function apply(array $lp): array
    {
        $newLp = $lp;

        $newLp['zf']['typ'] = 'max';
        $newLp['zf']['b'] = (-1) * $lp['zf']['b'];

        foreach ($lp['zf']['x'] as $key => $value) {
            $newLp['zf']['x'][$key] = (-1) * $value;
        }

        return $newLp;
    }
}
