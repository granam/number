<?php declare(strict_types=1);

namespace Granam\Tests\Number;

use Granam\Scalar\ScalarInterface;
use Granam\Number\NumberInterface;
use PHPUnit\Framework\TestCase;

class NumberInterfaceTest extends TestCase
{

    /** @test */
    public function inherits_from_scalar_interface(): void
    {
        self::assertTrue(\is_a(
            NumberInterface::class,
            ScalarInterface::class,
            true /* accept class name instead of instance */
        ));
    }
}