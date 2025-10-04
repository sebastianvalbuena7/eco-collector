<?php
namespace App\Services\Impact;

interface ImpactCalculatorStrategy
{
    public function calculate(float $weight): array;
}
