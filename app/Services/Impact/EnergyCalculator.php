<?php

namespace App\Services\Impact;

class EnergyCalculator implements ImpactCalculatorStrategy
{
    public function calculate(float $weight): array
    {
        $energyPerKg = 0.05;
        return ['kwh' => $weight * $energyPerKg];
    }
}
