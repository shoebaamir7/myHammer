<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 03/08/2018
 * Time: 10:25 PM
 */

namespace App\Tests\Mockers;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class UserRepositoryMocker
 * @package App\Tests\Mockers
 */
class UserRepositoryMocker extends TestCase
{
    /**
     * @var null
     */
    public $user = null;

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    public function getUserRepositoryMock()
    {
        $mock = $this->createMock(UserRepository::class);

        $mock->expects($this->any())
            ->method('find')
            ->willReturn($this->user);

        $mock->expects($this->any())
            ->method('findOneBy')
            ->willReturn($this->user);

        return $mock;
    }
}