<?php

namespace App\Interfaces;

interface NasaRepositoryInterface
{
    public function getInstruments(): array;
    public function getActivityIds(): array;
    public function getInstrumentUsage(): array;
    public function getInstrumentUsageByName(string $instrument): array;
}
