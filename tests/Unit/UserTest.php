<?php
declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;

/**
 * Class User.
 * Mutable.
 *
 * @package App\Library\User
 * @author GeorgII-web <george.webfullstack@gmail.com>
 */
class User
{
    /**
     * @var string First name
     */
    protected string $firstName;

    /**
     * @var string Last name
     */
    protected string $lastName;

    /**
     * @var string Email
     */
    protected string $email;

    /**
     * Validate email.
     *
     * @param string $email
     * @return bool
     */
    #[Pure] protected function isValidEmail(string $email = ''): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * First name setter.
     *
     * @param string $firstName First name
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setFirstName(string $firstName = ''): User
    {
        ($firstName) ?: throw new InvalidArgumentException('Invalid first name.');

        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Last name setter.
     *
     * @param string $lastName Last name
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setLastName(string $lastName = ''): User
    {
        ($lastName) ?: throw new InvalidArgumentException('Invalid last name.');

        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Email setter.
     *
     * @param string $email Email
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setEmail(string $email = ''): User
    {
        ($this->isValidEmail($email)) ?: throw new InvalidArgumentException('Invalid email.');

        $this->email = $email;

        return $this;
    }

    /**
     * Magical method.
     * Convert this class to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->firstName} {$this->lastName} <{$this->email}>";
    }

}

/**
 * Class UserTest.
 *
 * @package Tests\Unit
 */
class UserTest extends TestCase
{
    public function testMutableUserClass()
    {
        $user = new User;
        $user->setFirstName(firstName: 'John')
            ->setLastName(lastName: 'Doe')
            ->setEmail(email: 'john.doe@example.com');

        $this->assertEquals((string)$user, 'John Doe <john.doe@example.com>');
    }

    public function testMutableUserClassExceptonFirstName()
    {
        $this->expectExceptionMessage('Invalid first name.');

        $user = new User;
        $user->setFirstName(firstName: '')
            ->setLastName(lastName: 'Doe')
            ->setEmail(email: 'john.doe@example.com');
    }

    public function testMutableUserClassExceptonLastName()
    {
        $this->expectExceptionMessage('Invalid last name.');

        $user = new User;
        $user->setFirstName(firstName: 'John')
            ->setLastName(lastName: '')
            ->setEmail(email: 'john.doe@example.com');
    }

    public function testMutableUserClassExceptonEmail()
    {
        $this->expectExceptionMessage('Invalid email.');

        $user = new User;
        $user->setFirstName(firstName: 'John')
            ->setLastName(lastName: 'Doe')
            ->setEmail(email: '');
    }

    public function testMutableUserClassExceptonEmailBadFormat()
    {
        $this->expectExceptionMessage('Invalid email.');

        $user = new User;
        $user->setFirstName(firstName: 'John')
            ->setLastName(lastName: 'Doe')
            ->setEmail(email: 'user@domain');
    }
}
