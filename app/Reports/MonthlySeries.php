<?php

namespace App\Reports;

class MonthlySeries
{
    private array $series = [];

    public function declare(string $key, string $label): void
    {
        $this->series[$key] ??= [
            'key' => $key,
            'label' => $label,
            'values' => array_fill(0, 12, 0.0),
        ];
    }

    public function add(string $key, string $label, int $month, float $amount): void
    {
        $this->declare($key, $label);
        $this->series[$key]['values'][$month - 1] += $amount;
    }

    public function toArray(?callable $compare = null): array
    {
        $series = array_values($this->series);

        if (null !== $compare) {
            usort($series, $compare);
        }

        return array_map(function (array $row) {
            $row['values'] = array_map(fn (float $value) => round($value, 2), $row['values']);

            return $row;
        }, $series);
    }
}
