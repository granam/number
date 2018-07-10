<?php
declare(strict_types=1);

namespace Granam\Tests\Number;

use Granam\Number\NumberInterface;
use Granam\Number\PositiveNumber;
use PHPUnit\Framework\TestCase;

class PositiveNumberTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_as_number_interface(): void
    {
        self::assertTrue(is_a(PositiveNumber::class, NumberInterface::class, true));
    }
}