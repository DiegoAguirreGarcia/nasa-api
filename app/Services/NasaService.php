<?php

namespace App\Services;

use App\Interfaces\NasaRepositoryInterface;

class NasaService
{
    protected NasaRepositoryInterface $nasaRepository;

    public function __construct(NasaRepositoryInterface $nasaRepository)
    {
        $this->nasaRepository = $nasaRepository;
    }

    public function getInstruments(): array
    {
        return $this->nasaRepository->getInstruments();
    }

    public function getActivityIds(): array
    {
        return $this->nasaRepository->getActivityIds();
    }

    public function getInstrumentUsage(): array
    {
        return $this->nasaRepository->getInstrumentUsage();
    }

    public function getInstrumentUsageByName(string $instrument): array
    {
        return $this->nasaRepository->getInstrumentUsageByName($instrument);
    }
}
