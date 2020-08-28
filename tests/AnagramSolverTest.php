<?php

namespace App\Tests;

use App\Services\AnagramSolver;
use PHPUnit\Framework\TestCase;

class AnagramSolverTest extends TestCase
{
    private ?AnagramSolver $anagramSolver = null;

    public function test_if_the_size_of_the_first_string_is_not_equals_to_the_size_the_second_string_it_returns_minus_1(
    )
    {
        $number = $this->anagramSolver->getTheNumberOfMoves('toto', 'totot');
        $this->assertEquals(-1, $number);
    }

    public function test_if_the_first_string_doesnt_contains_exactly_the_whole_chars_of_second_string_it_returns_minus_1()
    {
        $number = $this->anagramSolver->getTheNumberOfMoves('toto', 'toti');
        $this->assertEquals(-1, $number);
    }

    public function test_if_the_first_string_equals_to_the_second_strings_it_returns_0()
    {
        $number = $this->anagramSolver->getTheNumberOfMoves('toto', 'toto');
        $this->assertEquals(0, $number);
    }

    public function test_if_the_first_can_be_reordered_when_it_returns_1()
    {
        $number = $this->anagramSolver->getTheNumberOfMoves('toot', 'toto');
        $this->assertEquals(1, $number);
    }

    public function test_if_the_first_can_be_reordered_in_exercise()
    {
        $number = $this->anagramSolver->getTheNumberOfMoves('eyssaasse', 'essayasse');
        $this->assertEquals(3, $number);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->anagramSolver = new AnagramSolver();
    }
}