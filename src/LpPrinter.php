<?php


class LpPrinter
{
    public function print(array $lp): void
    {
        echo $lp['zf']['typ'] . ' z = ' . $lp['zf']['b'];
        foreach ($lp['zf']['x'] as $key => $value) {
            echo ($value >= 0 ? ' +' : ' ') . $value . $key;
        }
        echo PHP_EOL;

        foreach ($lp['st'] as $restriktionszeile) {
            $first = true;
            foreach ($restriktionszeile['x'] as $key => $value) {
                echo ($first ? '' : ($value >= 0 ? ' +' : ' ')) . $value . $key;
                $first = false;
            }

            if (isset($restriktionszeile['b'])) {
                echo($restriktionszeile['b'] >= 0 ? ' +' . $restriktionszeile['b'] : $restriktionszeile['b']);
            }

            echo ' ' . $restriktionszeile['operator'] . ' ' . $restriktionszeile['schranke'] . PHP_EOL;
        }

        echo PHP_EOL;
    }
}
