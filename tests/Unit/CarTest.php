<?php
declare(strict_types=1);

namespace Tests\Unit;

use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;

/**
 * Class Car.
 *
 * @author  GeorgII-web <george.webfullstack@gmail.com>
 * @package App\Library\Car
 */
class Car
{
    /**
     * @param CarDetail[] $details List of the car details
     */
    public function __construct(private array $details)
    {
    }

    /**
     * Is car broken.
     *
     * @return bool
     */
    #[Pure] public function isBroken(): bool
    {
        foreach ($this->details as $detail) {

            if ($detail->isBroken()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check car detail if it uses specified trait.
     *
     * @param CarDetail $carDetail    Car detail class
     * @param string    $propertyName Trait name to find in 'use' of the class
     * @return bool
     */
    private function isDetailHasProperty(CarDetail $carDetail, string $propertyName): bool
    {
        foreach (class_uses($carDetail::class) as $trait) {
            if (str_ends_with($trait, $propertyName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Is car painting damaged.
     *
     * @return bool
     */
    public function isPaintingDamaged(): bool
    {
        foreach ($this->details as $detail) {
            // Only paintable details has method 'isPaintDamaged'
            if (
                $this->isDetailHasProperty(carDetail: $detail, propertyName: 'Paintable') &&
                $detail->isPaintDamaged()
            ) {
                return true;
            }
        }

        return false;
    }
}

/**
 * Interface CarDetailInterface.
 *
 * @package App\Library\Car
 */
interface CarDetailInterface
{
    /**
     * Return - is detail broken.
     *
     * @return bool
     */
    public function isBroken(): bool;
}

/**
 * Class CarDetail.
 *
 * @package App\Library\Car
 */
abstract class CarDetail implements CarDetailInterface
{
    /**
     * CarDetail constructor.
     *
     * @param bool $isBroken Is detail broken
     */
    public function __construct(protected bool $isBroken)
    {
    }

    /**
     * Return - is detail broken.
     *
     * @return bool
     */
    public function isBroken(): bool
    {
        return $this->isBroken;
    }
}

/**
 * Trait Paintable.
 *
 * @package App\Library\Car
 */
trait Paintable
{
    /**
     * @var bool Is detail paint damaged
     */
    protected bool $isPaintDamaged;

    /**
     * Set detail paint damaged
     *
     * @param bool $isPaintDamaged Detail paint damaged
     */
    public function setIsPaintDamaged(bool $isPaintDamaged): void
    {
        $this->isPaintDamaged = $isPaintDamaged;
    }

    /**
     * Return - is detail paint damaged.
     *
     * @return bool
     */
    public function isPaintDamaged(): bool
    {
        return $this->isPaintDamaged;
    }
}

/**
 * Class Door.
 *
 * @package App\Library\Car
 */
final class Door extends CarDetail
{
    use Paintable;

    /**
     * Door constructor.
     *
     * @param bool $isBroken       Is detail broken
     * @param bool $isPaintDamaged Is detail paint damaged
     */
    public function __construct(bool $isBroken, bool $isPaintDamaged)
    {
        parent::__construct($isBroken);

        $this->setIsPaintDamaged($isPaintDamaged);
    }
}

/**
 * Class Tyre.
 *
 * @package App\Library\Car
 */
final class Tyre extends CarDetail
{
}

/**
 * Class CarTest.
 *
 * @package Tests\Unit
 */
class CarTest extends TestCase
{
    /**
     * Test car is broken.
     */
    public function testCarIsBroken()
    {
        $car = new Car([
            new Door(isBroken: false, isPaintDamaged: true),
            new Tyre(isBroken: true),
        ]);

        $this->assertTrue($car->isBroken());
    }

    /**
     * Test car painting is damaged.
     */
    public function testCarIsPaintingDamaged()
    {
        $car = new Car([
            new Door(isBroken: false, isPaintDamaged: true),
            new Tyre(isBroken: true),
        ]);

        $this->assertTrue($car->isPaintingDamaged());
    }

    /**
     * Test car painting is NOT damaged.
     */
    public function testCarIsPaintingNotDamaged()
    {
        $car = new Car([
            new Door(isBroken: false, isPaintDamaged: false),
            new Tyre(isBroken: true),
        ]);

        $this->assertFalse($car->isPaintingDamaged());
    }
}
