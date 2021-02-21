<?php

namespace Printer;

class LpPrinter
{
    public function print(array $lp): void
    {
        if (isset($lp['szf'])) {
            echo $lp['szf']['typ'] . ' s = ' . $this->runden($lp['szf']['b']);
            foreach ($lp['szf']['x'] as $variable => $koeff) {
                echo ($koeff >= 0 ? ' +' : ' ') . $this->runden($koeff) . $variable;
            }
            echo PHP_EOL;
        }

        echo $lp['zf']['typ'] . ' z = ' . $this->runden($lp['zf']['b']);
        foreach ($lp['zf']['x'] as $variable => $koeff) {
            echo ($koeff >= 0 ? ' +' : ' ') . $this->runden($koeff) . $variable;
        }
        echo PHP_EOL;

        foreach ($lp['st'] as $restriktionszeile) {
            $first = true;
            foreach ($restriktionszeile['x'] as $variable => $koeff) {
                echo ($first ? '' : ($koeff >= 0 ? ' +' : ' ')) . $this->runden($koeff) . $variable;
                $first = false;
            }

            if (isset($restriktionszeile['b'])) {
                echo($restriktionszeile['b'] >= 0 ? ' +' . $this->runden($restriktionszeile['b']) : ' ' . $this->runden($restriktionszeile['b']));
            }

            echo ' ' . $restriktionszeile['operator'] . ' ' . $restriktionszeile['schranke'] . PHP_EOL;
        }

        echo PHP_EOL;
    }

    private function runden($zahl): string
    {
        if(!is_numeric($zahl)) return $zahl;

        if ((int) $zahl == $zahl) return $zahl;

        return number_format(
            $zahl, // zu konvertierende zahl
            2,     // Anzahl an Nochkommastellen
            ",",   // Dezimaltrennzeichen
            "."    // 1000er-Trennzeichen
        );
    }
}
