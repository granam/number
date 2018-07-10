<?php
declare(strict_types=1);

namespace Granam\Tests\Number;

use Granam\Number\NumberInterface;
use Granam\Number\NegativeNumber;
use PHPUnit\Framework\TestCase;

class NegativeNumberTest extends TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_as_number_interface(): void
    {
        self::assertTrue(is_a(NegativeNumber::class, NumberInterface::class, true));
    }
}