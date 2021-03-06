<?php

namespace Printer;

class LpPrinter
{
    public const PRINT_DIRECTION_FORWARD = 1;
    public const PRINT_DIRECTION_REVERSE = 2;

    public function print(array $lp, $printDirection = self::PRINT_DIRECTION_FORWARD): void
    {
        if (isset($lp['szf'])) {
            $this->printZf($lp['szf'], 's');
        }

        $this->printZf($lp['zf']);

        switch ($printDirection) {
            case self::PRINT_DIRECTION_FORWARD:
                $this->printStForward($lp['st']);
                break;
            case self::PRINT_DIRECTION_REVERSE:
                $this->printStReverse($lp['st']);
                break;
        }

        echo PHP_EOL;
    }

    private function printZf(array $zf, string $varName = 'z'): void
    {
        echo $zf['typ'] . ' ' . $varName . ' = ' . $this->runden($zf['b']);
        foreach ($zf['x'] as $variable => $koeff) {
            echo ($koeff >= 0 ? ' +' : ' ') . $this->runden($koeff) . $variable;
        }
        echo PHP_EOL;
    }

    private function printStForward(array $st): void
    {
        foreach ($st as $restriktionszeile) {
            $first = true;
            foreach ($restriktionszeile['x'] as $variable => $koeff) {
                echo ($first ? '' : ($koeff >= 0 ? ' +' : ' ')) . $this->runden($koeff) . $variable;
                $first = false;
            }

            if (isset($restriktionszeile['b'])) {
                echo ($restriktionszeile['b'] >= 0 ? ' +' : ' ') . $this->runden($restriktionszeile['b']);
            }

            echo ' ' . $restriktionszeile['operator'] . ' ' . $restriktionszeile['schranke'] . PHP_EOL;
        }
    }

    private function printStReverse(array $st): void
    {
        foreach ($st as $restriktionszeile) {
            echo $restriktionszeile['schranke'] . ' ' . $restriktionszeile['operator'];

            if (isset($restriktionszeile['b'])) {
                echo ' ' . $this->runden($restriktionszeile['b']);
            } else {
                echo ' 0';
            }

            foreach ($restriktionszeile['x'] as $variable => $koeff) {
                echo ($koeff >= 0 ? ' +' : ' ') . $this->runden($koeff) . $variable;
            }

            echo PHP_EOL;
        }
    }

    private function runden($zahl): string
    {
        if (!is_numeric($zahl)) return $zahl;

        if ((int)$zahl == $zahl) return $zahl;

        return number_format(
            $zahl, // zu konvertierende zahl
            2,     // Anzahl an Nochkommastellen
            ",",   // Dezimaltrennzeichen
            "."    // 1000er-Trennzeichen
        );
    }
}
