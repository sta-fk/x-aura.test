<?php

namespace App\Service;

use App\Repository\VacancyResumeRepository;

class StatisticsService
{
    public function __construct(
        private readonly VacancyResumeRepository $resumeRepository,
    ) {}

    public function getResumeRating(): array
    {
        $resumes = $this->resumeRepository->findAll();
        $resumesWithMarks = [];
        foreach ($resumes as $resume) {
            if ($resume->getAverageMark()) {
                $resumesWithMarks[] = $resume;
            }
        }

        usort($resumesWithMarks, function ($a, $b) {
            $markA = $a->getAverageMark();
            $markB = $b->getAverageMark();
            if ($markA === $markB) {
                return 0;
            }
            return ($markA > $markB) ? -1 : 1;
        });

        return $resumesWithMarks;
    }
}
