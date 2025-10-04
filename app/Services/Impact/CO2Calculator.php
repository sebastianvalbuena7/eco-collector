<?php
namespace App\Services\Impact;

class CO2Calculator implements ImpactCalculatorStrategy
{
    public function calculate(float $weight): array
    {
        // ejemplo: kg * factor
        $co2PerKg = 0.2; // valores ejemplo
        return ['co2_kg' => $weight * $co2PerKg];
    }
}
