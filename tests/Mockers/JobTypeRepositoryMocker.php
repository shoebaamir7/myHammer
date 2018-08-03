<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 03/08/2018
 * Time: 10:28 PM
 */

namespace App\Tests\Mockers;

use App\Repository\JobTypeRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class JobTypeRepositoryMocker
 * @package App\Tests\Mockers
 */
class JobTypeRepositoryMocker extends TestCase
{
    /**
     * @var null
     */
    public $jobType = null;

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    public function getJobTypeRepositoryMock()
    {
        $mock = $this->createMock(JobTypeRepository::class);

        $mock->expects($this->any())
            ->method('find')
            ->willReturn($this->jobType);

        return $mock;
    }
}