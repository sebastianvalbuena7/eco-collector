<?php

namespace App\Services\Impact;

class TreeEquivalentCalculator implements ImpactCalculatorStrategy
{
    public function calculate(float $weight): array
    {
        $treesPerKg = 0.001; // ejemplo
        return ['trees' => (int) round($weight * $treesPerKg)];
    }
}
