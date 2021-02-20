<?php

namespace Rule;

use Exception;

class Simplex2Iteration
{
    public function apply(array $lp): array
    {
        $newLp = $lp;

        $groessterKoeff = 0;
        $groessterKoeffBei = null;
        foreach ($lp['zf']['x'] as $variable => $koeffizient) {
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
            $beschr = $restriktionszeile['b'] / ($restriktionszeile['x'][$groessterKoeffBei] * (-1));
            if ($beschr > 0 && $beschr < $minBeschraenkung) {
                $minBeschraenkung = $beschr;
                $minBeschraenkungBei = $restriktionszeile['schranke'];
            }
        }

        echo 'min beschr: ' . $minBeschraenkungBei . PHP_EOL . PHP_EOL;

        return $this->basistausch($newLp, $groessterKoeffBei, $minBeschraenkungBei);
    }

    private function basistausch(array $lp, string $rein, string $raus): array
    {
        $rausIndex = -1;
        foreach ($lp['st'] as $key => $restriktionszeile) {
            if ($restriktionszeile['schranke'] === $raus) {
                $rausIndex = $key;
            }
        }

        $neueRestriktionszeile = [
            'x' => $lp['st'][$rausIndex]['x'],
            'operator' => '=',
            'schranke' => $rein,
            'b' => $lp['st'][$rausIndex]['b'],
        ];

        $reinKoeff = $neueRestriktionszeile['x'][$rein];

        if ($reinKoeff > 0) {
            $neueRestriktionszeile['b'] = (-1) * $neueRestriktionszeile['b'];
            foreach ($neueRestriktionszeile['x'] as $variable => $koeffizient) {
                $neueRestriktionszeile['x'][$variable] = (-1) * $koeffizient;
            }
        }

        unset($neueRestriktionszeile['x'][$rein]);

        foreach ($neueRestriktionszeile['x'] as $variable => $koeffizient) {
            $neueRestriktionszeile['x'][$variable] = $koeffizient / abs($reinKoeff);
        }

        $neueRestriktionszeile['x'][$raus] = -1;

        unset($lp['st'][$rausIndex]); // raus restriktion entfernen
        $lp['st'] = array_values($lp['st']);

        $zfReinKoeff = $lp['zf']['x'][$rein];
        unset($lp['zf']['x'][$rein]);
        $lp['zf']['x'][$raus] = 0;

        $lp['zf']['b'] += $zfReinKoeff * $neueRestriktionszeile['b'];
        foreach ($lp['zf']['x'] as $variable => $koeffizient) {
            $lp['zf']['x'][$variable] += $zfReinKoeff * $neueRestriktionszeile['x'][$variable];
            if ($lp['zf']['x'][$variable] === 0) {
                unset($lp['zf']['x'][$variable]);
            }
        }

        foreach ($lp['st'] as $key => $restriktionszeile) {
            $restriktionReinKoeff = $lp['st'][$key]['x'][$rein];
            unset($lp['st'][$key]['x'][$rein]);
            $lp['st'][$key]['x'][$raus] = 0;

            $lp['st'][$key]['b'] += $restriktionReinKoeff * $neueRestriktionszeile['b'];
            foreach ($lp['st'][$key]['x'] as $variable => $koeffizient) {
                $lp['st'][$key]['x'][$variable] += $restriktionReinKoeff * $neueRestriktionszeile['x'][$variable];
                if ($lp['st'][$key]['x'][$variable] === 0) {
                    unset($lp['st'][$key]['x'][$variable]);
                }
            }
        }

        $lp['st'][] = $neueRestriktionszeile; // rein restriktion einfügen

        return $lp;
    }
}
