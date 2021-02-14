<?php
declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Interface HeroInterface
 *
 * @package Tests\Unit
 * @author GeorgII-web <george.webfullstack@gmail.com>
 */
interface HeroInterface
{
    /**
     * Get hero attack points.
     *
     * @return int
     */
    public function getAttack(): int;

    /**
     * Get hero defence points.
     *
     * @return int
     */
    public function getDefence(): int;

    /**
     * Get hero health points.
     *
     * @return int
     */
    public function getHealthPoints(): int;

    /**
     * Set hero health points.
     *
     * @param int $healthPoints New health points
     * @return void
     */
    public function setHealthPoints(int $healthPoints): void;
}

/**
 * Class DamageCalculator
 *
 * @package Tests\Unit
 */
class DamageCalculator
{
    /**
     * DamageCalculator constructor.
     *
     * @param float $damageRandFactor Randomizing damage factor, bigger - more random
     */
    public function __construct(protected float $damageRandFactor = 0.2)
    {
    }

    /**
     * Randomizing damage factor getter.
     *
     * @return float
     */
    public function getDamageRandFactor(): float
    {
        return $this->damageRandFactor;
    }

    /**
     * Calculate damage in the fight of 2 heroes.
     *
     * @param HeroInterface $attacker 'Attacker' hero
     * @param HeroInterface $defender 'Defender' hero
     * @return int Damage points, 0 default
     */
    public function calculateDamage(HeroInterface $attacker, HeroInterface $defender): int
    {
        $damage = 0; // Default damage value

        $attackPoints = $attacker->getAttack();
        $defencePoints = $defender->getDefence();

        // Attacker may damage defender
        if ($attackPoints > $defencePoints) {
            $baseDamage = $attackPoints - $defencePoints;

            $factor = $baseDamage * $this->getDamageRandFactor();

            // Set the damage range a little lesser (nearest int values)
            $minDamage = (int)ceil($baseDamage - $factor);
            $maxDamage = (int)floor($baseDamage + $factor);

            try {
                // mt_rand() is faster, but predictable
                // random_int() is cryptographically secure, but slower
                $damage = random_int($minDamage, $maxDamage);
            } catch (Throwable) {

                // Default 0 damage on errors
                return 0;
            }
        }

        return $damage;
    }
}

/**
 * Class FightService
 *
 * @package Tests\Unit
 */
class FightService
{
    /**
     * FightService constructor.
     *
     * @param DamageCalculator $damageCalculator Expect damage calculator class
     */
    public function __construct(private DamageCalculator $damageCalculator)
    {
    }

    /**
     * Fight - calculate damage and increase defender health on it.
     *
     * @param HeroInterface $attacker 'Attacker' hero
     * @param HeroInterface $defender 'Defender' hero
     */
    public function fight(HeroInterface $attacker, HeroInterface $defender): void
    {
        $damage = $this->damageCalculator->calculateDamage(attacker: $attacker, defender: $defender);

        $defender->setHealthPoints(healthPoints: $defender->getHealthPoints() - $damage);
    }
}

/**
 * Class FightServiceTest
 *
 * @package Tests\Unit
 */
class FightServiceTest extends TestCase
{
    /**
     * Test fight result - defender health in range.
     */
    public function testFight()
    {
        // Init
        $attackPoints = 3;
        $defendPoints = 1;
        $healthPoints = 5;
        $damageRandFactor = 0.2;

        // Calculate fight values
        $damageCalculator = new DamageCalculator(damageRandFactor: $damageRandFactor);
        $baseDamage = $attackPoints - $defendPoints;
        $baseHealth = $healthPoints - $baseDamage;
        // Get health smaller range (nearest int values)
        $minHealth = ceil($baseHealth - $baseDamage * $damageCalculator->getDamageRandFactor());
        $maxHealth = floor($baseHealth + $baseDamage * $damageCalculator->getDamageRandFactor());

        // Attacker mock asserts
        $attacker = $this->createMock(HeroInterface::class);

        $attacker
            ->expects($this->once())
            ->method('getAttack')
            ->willReturn($attackPoints);

        // Defender mock asserts
        $defender = $this->createMock(HeroInterface::class);

        $defender
            ->expects($this->once())
            ->method('getDefence')
            ->willReturn($defendPoints);

        $defender
            ->expects($this->once())
            ->method('getHealthPoints')
            ->willReturn($healthPoints);

        // Expect that defender health after the fight will be between $minHealth and $maxHealth
        $defender
            ->expects($this->once())
            ->method('setHealthPoints')
            ->with($this->logicalAnd(
                $this->greaterThanOrEqual($minHealth),
                $this->lessThanOrEqual($maxHealth)
            ));

        // Init heroes fight
        $fightService = new FightService(damageCalculator: $damageCalculator);
        $fightService->fight(attacker: $attacker, defender: $defender);
    }

}
