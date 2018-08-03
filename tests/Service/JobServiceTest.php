<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 03/08/2018
 * Time: 8:52 PM
 */

namespace App\Tests\Service;

use App\Entity\CategoryType;
use App\Entity\Job;
use App\Entity\JobType;
use App\Entity\Region;
use App\Entity\User;
use App\Service\JobService;
use App\Tests\Mockers\CategoryTypeRepositoryMocker;
use App\Tests\Mockers\JobRepositoryMocker;
use App\Tests\Mockers\JobTypeRepositoryMocker;
use App\Tests\Mockers\RegionRepositoryMocker;
use App\Tests\Mockers\UserRepositoryMocker;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class JobServiceTest
 * @package App\Tests\Service
 */
class JobServiceTest extends TestCase
{
    /**
     * @var JobService
     */
    public $service;

    /**
     * @var JobRepositoryMocker $jobRepositoryMocker
     */
    public $jobRepositoryMocker;

    /**
     * @var UserRepositoryMocker $userRepositoryMocker
     */
    private $userRepositoryMocker;

    /**
     * @var CategoryTypeRepositoryMocker $categoryTypeRepositoryMocker
     */
    private $categoryTypeRepositoryMocker;

    /**
     * @var JobTypeRepositoryMocker $jobTypeRepositoryMocker
     */
    private $jobTypeRepositoryMocker;

    /**
     * @var RegionRepositoryMocker $regionRepositoryMocker
     */
    private $regionRepositoryMocker;

    /**
     * initialize objects
     */
    protected function setUp()
    {
        $this->jobRepositoryMocker = new JobRepositoryMocker();
        $this->userRepositoryMocker = new UserRepositoryMocker();
        $this->categoryTypeRepositoryMocker = new CategoryTypeRepositoryMocker();
        $this->jobTypeRepositoryMocker = new JobTypeRepositoryMocker();
        $this->regionRepositoryMocker = new RegionRepositoryMocker();
    }

    /**
     * destroy objects
     */
    protected function tearDown()
    {
        $this->jobRepositoryMocker = null;
        $this->userRepositoryMocker = null;
        $this->categoryTypeRepositoryMocker = null;
        $this->jobTypeRepositoryMocker = null;
        $this->regionRepositoryMocker = null;
    }

    /**
     * Setup service object
     */
    public function setupService()
    {
        $jobRepositoryMock = $this->jobRepositoryMocker->getJobRepositoryMock();
        $userRepositoryMock = $this->userRepositoryMocker->getUserRepositoryMock();
        $categoryTypeRepositoryMock = $this->categoryTypeRepositoryMocker->getCategoryTypeRepositoryMock();
        $jobTypeRepositoryMock = $this->jobTypeRepositoryMocker->getJobTypeRepositoryMock();
        $regionRepositoryMock = $this->regionRepositoryMocker->getRegionRepositoryMock();

        $this->service = new JobService($jobRepositoryMock, $userRepositoryMock, $categoryTypeRepositoryMock, $jobTypeRepositoryMock, $regionRepositoryMock);
    }

    /**
     * test If Job Created Successfully
     */
    public function testIfJobCreatedSuccessfully()
    {
        $requestData = array (
            'email' => 'user@gmail.com',
            'title' => 'Awesome title',
            'description' => 'some text',
            'jobDate' => '2018-10-10 05:10:20',
            'zip' => '10115',
            'categoryId' => 1,
            'jobTypeId' => 1,
        );
        $this->userRepositoryMocker->user = new User();
        $this->categoryTypeRepositoryMocker->category = new CategoryType();
        $this->jobTypeRepositoryMocker->jobType = new JobType();
        $this->regionRepositoryMocker->region = new Region();
        $this->jobRepositoryMocker->job = new Job();
        $this->setupService();
        $response = $this->service->create($requestData);
        $this->assertTrue($response);
    }

    /**
     * test If Job Edited Suucessfully
     */
    public function testIfJobEditedSuucessfully()
    {
        $requestData = array (
            'jobId' => 2,
            'userId' => 2,
            'email' => 'user@gmail.com',
            'title' => 'Awesome title',
            'description' => 'some text',
            'jobDate' => '2018-10-10 05:10:20',
            'zip' => '10115',
            'categoryId' => 1,
            'jobTypeId' => 1,
        );

        $this->userRepositoryMocker->user = new User();
        $this->categoryTypeRepositoryMocker->category = new CategoryType();
        $this->jobTypeRepositoryMocker->jobType = new JobType();
        $this->regionRepositoryMocker->region = new Region();
        $this->jobRepositoryMocker->job = new Job();
        $this->setupService();
        $response = $this->service->edit($requestData);
        $this->assertTrue($response);
    }

    /**
     * test If Jobs Listed Successfully
     */
    public function testIfJobsListedSuccessfully()
    {
        $requestData = array (
            'userId' => 1,
            'servicefilter' => '',
            'regionfilter' => '',
        );
        $this->userRepositoryMocker->user = new User();
        $this->jobRepositoryMocker->list = $this->getJobList();
        $this->setupService();
        $response = $this->service->showAllJobs($requestData);
        $this->assertEquals($this->jobRepositoryMocker->list, $response);
    }

    /**
     * @return array
     */
    public function getJobList() : array
    {
        $list = array (
            'code' => 200,
            'message' => 'OK',
            'jobs' =>
                array (
                    array (
                            'JobId' => 2,
                            'title' => 'Abtransport, Entsorgung und Entrümpelung',
                            'description' => 'some text',
                            'jobDate' =>
                                array (
                                    'date' => '2018-10-10 05:10:20.000000',
                                    'timezone_type' => 3,
                                    'timezone' => 'Europe/Berlin',
                                ),
                            'city' => 'Berlin',
                            'zipCode' => '10115',
                            'country' => 'Germany',
                            'name' => 'END USER',
                            'email' => 'user@gmail.com',
                        ),
                    array (
                            'JobId' => 3,
                            'title' => 'Sonstige Umzugsleistungen',
                            'description' => 'some text',
                            'jobDate' =>
                                array (
                                    'date' => '2018-10-10 05:10:20.000000',
                                    'timezone_type' => 3,
                                    'timezone' => 'Europe/Berlin',
                                ),
                            'city' => 'Berlin',
                            'zipCode' => '10115',
                            'country' => 'Germany',
                            'name' => 'END USER',
                            'email' => 'user@gmail.com',
                        ),
                ),
        );

        return $list;
    }

}