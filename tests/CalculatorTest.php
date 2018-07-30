<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 28/07/2018
 * Time: 12:24 AM
 */

namespace App\Tests;

use App\Calculator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class CalculatorTest
 * @package App\Tests
 */
class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $obj = new Calculator();
        $result = $obj->add(3, 7);
        $this->assertEquals(10, $result);
    }
}