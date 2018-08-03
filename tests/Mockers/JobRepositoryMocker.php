<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 03/08/2018
 * Time: 10:16 PM
 */

namespace App\Tests\Mockers;

use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class JobRepositoryMocker
 * @package App\Tests\Mockers
 */
class JobRepositoryMocker extends TestCase
{
    /** @var null  */
    public $job = null;

    /** @var null  */
    public $list = null;

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    public function getJobRepositoryMock()
    {
        $mock = $this->createMock(JobRepository::class);

        $mock->expects($this->any())
            ->method('find')
            ->willReturn($this->job);

        $mock->expects($this->any())
            ->method('findOneBy')
            ->willReturn($this->job);

        $mock->expects($this->any())
            ->method('save')
            ->willReturn($this->job);

        $mock->expects($this->any())
            ->method('findJObsByServiceAndRegion')
            ->willReturn($this->list);

        return $mock;
    }
}