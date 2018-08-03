<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 03/08/2018
 * Time: 10:29 PM
 */

namespace App\Tests\Mockers;

use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class RegionRepositoryMocker
 * @package App\Tests\Mockers
 */
class RegionRepositoryMocker extends TestCase
{
    /**
     * @var null
     */
    public $region = null;

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    public function getRegionRepositoryMock()
    {
        $mock = $this->createMock(RegionRepository::class);

        $mock->expects($this->any())
            ->method('findOneBy')
            ->willReturn($this->region);

        return $mock;
    }
}