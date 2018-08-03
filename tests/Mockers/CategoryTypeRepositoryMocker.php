<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 03/08/2018
 * Time: 10:27 PM
 */

namespace App\Tests\Mockers;

use App\Repository\CategoryTypeRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class CategoryTypeRepositoryMocker
 * @package App\Tests\Mockers
 */
class CategoryTypeRepositoryMocker extends TestCase
{
    /**
     * @var null
     */
    public $category = null;

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    public function getCategoryTypeRepositoryMock()
    {
        $mock = $this->createMock(CategoryTypeRepository::class);

        $mock->expects($this->any())
            ->method('find')
            ->willReturn($this->category);

        return $mock;
    }
}