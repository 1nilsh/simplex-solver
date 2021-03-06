<?php

namespace SimplexSolver\Rule;

class Basistausch
{
    /**
     * @param array $lp LP, auf das der Basistausch angewandt wird.
     * @param string $reinVariable Name der Variablen, die in die Basis geht
     * @param string $rausVariable Name der Variablen, die die Basis verlässt
     * @return array Ein neues LP mit getauschter Basis
     */
    public function apply(array $lp, string $reinVariable, string $rausVariable): array
    {
        $rausIndex = -1;
        foreach ($lp['st'] as $key => $restriktionszeile) {
            if ($restriktionszeile['schranke'] === $rausVariable) {
                $rausIndex = $key;
            }
        }

        $alteRestriktionszeile = $lp['st'][$rausIndex];

        $reinVariableKoeffizient = $alteRestriktionszeile['x'][$reinVariable];
        $reinVariableVorzeichen = ($reinVariableKoeffizient > 0 ? 1 : -1);

        $neueRestriktionszeile = [
            'x' => [],
            'operator' => '=',
            'schranke' => $reinVariable,
            'b' => 0,
        ];

        if ($reinVariableVorzeichen > 0) {
            $neueRestriktionszeile['b'] = $alteRestriktionszeile['b'] / ((-1) * $reinVariableKoeffizient);

            foreach ($alteRestriktionszeile['x'] as $variable => $koeffizient) {
                if ($variable === $reinVariable) continue;

                $neueRestriktionszeile['x'][$variable] = $koeffizient / ((-1) * $reinVariableKoeffizient);
            }

            $neueRestriktionszeile['x'][$rausVariable] = -1 / ((-1) * $reinVariableKoeffizient);
        }

        if ($reinVariableVorzeichen < 0) {
            $neueRestriktionszeile['b'] = $alteRestriktionszeile['b'] / $reinVariableKoeffizient;

            foreach ($alteRestriktionszeile['x'] as $variable => $koeffizient) {
                if ($variable === $reinVariable) continue;

                $neueRestriktionszeile['x'][$variable] = $koeffizient / $reinVariableKoeffizient;
            }

            $neueRestriktionszeile['x'][$rausVariable] = -1 / ((-1) * $reinVariableKoeffizient);
        }

        unset($lp['st'][$rausIndex]); // raus restriktion entfernen
        $lp['st'] = array_values($lp['st']);

        $lp['zf'] = $this->termumformung($lp['zf'], $rausVariable, $reinVariable, $neueRestriktionszeile);
        ksort($lp['zf']['x']);

        foreach ($lp['st'] as $key => $restriktionszeile) {
            $lp['st'][$key] = $this->termumformung($lp['st'][$key], $rausVariable, $reinVariable, $neueRestriktionszeile);
        }

        if (isset($lp['szf'])) {
            $lp['szf'] = $this->termumformung($lp['szf'], $rausVariable, $reinVariable, $neueRestriktionszeile);
            ksort($lp['szf']['x']);
        }

        $lp['st'][] = $neueRestriktionszeile; // rein restriktion einfügen

        usort($lp['st'], function (array $a, array $b) {
            return strcmp($a['schranke'], $b['schranke']);
        });

        return $lp;
    }

    private function termumformung(array $term, string $rausVar, string $reinVar, array $neueRestriktionszeile): array
    {
        $reinKoeff = $term['x'][$reinVar];
        unset($term['x'][$reinVar]);

        foreach ($neueRestriktionszeile['x'] as $variable => $koeffizient) {
            if (!isset($term['x'][$variable])) {
                $term['x'][$variable] = 0;
            }
        }

        $term['b'] += $reinKoeff * $neueRestriktionszeile['b'];
        foreach ($term['x'] as $variable => $koeffizient) {
            if (!isset($neueRestriktionszeile['x'][$variable])) continue;

            $term['x'][$variable] += $reinKoeff * $neueRestriktionszeile['x'][$variable];

            if ($term['x'][$variable] == 0) {
                unset($term['x'][$variable]);
            }
        }

        return $term;
    }
}
