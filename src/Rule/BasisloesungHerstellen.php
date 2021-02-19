<?php


namespace Rule;


class BasisloesungHerstellen
{
    public function apply(array $lp): array
    {
        $newLp = $lp;

        foreach ($lp['st'] as $key => $restriktionszeile) {
            $newLp['st'][$key]['b'] = $restriktionszeile['schranke'];

            end($restriktionszeile['x']);
            $newLp['st'][$key]['schranke'] = key($restriktionszeile['x']);
            reset($restriktionszeile['x']);

            array_pop($newLp['st'][$key]['x']);
            array_pop($restriktionszeile['x']);

            foreach ($restriktionszeile['x'] as $variable => $koeffizient) {
                $newLp['st'][$key]['x'][$variable] = (-1) * $koeffizient;
            }
        }

        return $newLp;
    }
}
