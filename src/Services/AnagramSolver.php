<?php

namespace App\Services;


class AnagramSolver
{
    public function getTheNumberOfMoves(string $stringToHandle, string $string): int
    {
        if (!$this->canBeReordered($stringToHandle, $string)) {
            return -1;
        }

        if ($stringToHandle === $string) {
            return 0;
        }

        $stringLength = strlen($stringToHandle);
        $numberOfMoves = 0;
        for ($i = 0; $i < $stringLength; $i++) {
            if ($stringToHandle[$i] !== $string[$i]) {
                $stringToHandle = $this->move($stringToHandle, $string, $i);
                $numberOfMoves++;
            }
        }

        return $numberOfMoves;
    }

    private function canBeReordered(string $firstString, string $secondString): bool
    {
        if ($firstString === $secondString) {
            return true;
        }

        $stringLength = strlen($firstString);
        if ($stringLength !== strlen($secondString)) {
            return false;
        }

        for ($i = 0; $i < $stringLength; $i++) {
            $currentChar = $firstString[$i];
            $secondString = preg_replace("/$currentChar/", '', $secondString, 1);
        }

        return $secondString === '';
    }

    private function move(string $stringToHandle, string $string, int $currentIndex)
    {
        $charToDelete = $string[$currentIndex];
        $stringToConcatenate = preg_replace("/$charToDelete/", '', substr($stringToHandle, $currentIndex), 1);

        return substr($stringToHandle, 0, $currentIndex) . $charToDelete . $stringToConcatenate;
    }
}