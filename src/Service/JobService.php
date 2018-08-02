<?php
/**
 * Created by PhpStorm.
 * User: AAMIR
 * Date: 02/08/2018
 * Time: 10:33 PM
 */

namespace App\Service;

use App\Entity\CategoryType;
use App\Entity\Job;
use App\Entity\JobType;
use App\Entity\Region;
use App\Entity\User;
use App\Repository\CategoryTypeRepository;
use App\Repository\JobRepository;
use App\Repository\JobTypeRepository;
use App\Repository\RegionRepository;
use App\Repository\UserRepository;
use DateTime;
use Exception;

/**
 * Class JobService
 * @package App\Service
 */
class JobService
{
    /**
     * @var JobRepository $jobRepository
     */
    public $jobRepository;

    /**
     * @var UserRepository $userRepository
     */
    public $userRepository;

    /**
     * @var CategoryTypeRepository $categoryTypeRepository
     */
    public $categoryTypeRepository;

    /**
     * @var JobTypeRepository $jobTypeRepository
     */
    public $jobTypeRepository;

    /**
     * @var RegionRepository $regionRepository
     */
    public $regionRepository;

    /**
     * JobController constructor.
     * @param JobRepository $jobRepository
     * @param UserRepository $userRepository
     * @param CategoryTypeRepository $categoryTypeRepository
     * @param JobTypeRepository $jobTypeRepository
     * @param RegionRepository $regionRepository
     */
    public function __construct(JobRepository $jobRepository, UserRepository $userRepository, CategoryTypeRepository $categoryTypeRepository, JobTypeRepository $jobTypeRepository, RegionRepository $regionRepository)
    {
        $this->jobRepository = $jobRepository;
        $this->userRepository = $userRepository;
        $this->categoryTypeRepository = $categoryTypeRepository;
        $this->jobTypeRepository = $jobTypeRepository;
        $this->regionRepository = $regionRepository;
    }

    /**
     * @param $requestData
     * @param Job|null $job
     * @return bool
     * @throws Exception
     */
    public function create($requestData, Job $job = null)
    {
        try {
            $jobDate = new DateTime($requestData['jobDate']);
            $jobDate->format('Y-m-d H:i:s');
            if(null === $job) {
                /** @var Job $job */
                $job = new Job();
            }
            /** @var User $user */
            $user = $this->userRepository->findOneBy(['email' => $requestData['email']]);
            if(empty($user)) {
                throw new Exception('User does not exist');
            }
            $job->setUser($user);

            /** @var CategoryType $categoryType */
            $categoryType = $this->categoryTypeRepository->find($requestData['categoryId']);
            if(empty($categoryType)) {
                throw new Exception('Invalid category');
            }
            $job->setCategoryType($categoryType);

            /** @var JobType $jobType */
            $jobType = $this->jobTypeRepository->find($requestData['jobTypeId']);
            if(empty($jobType)) {
                throw new Exception('Invalid job selected');
            }
            $job->setJobType($jobType);

            /** @var Region $region */
            $region = $this->regionRepository->findOneBy(['zipCode' => $requestData['zip']]);
            if(empty($region)) {
                throw new Exception('Only german zipcodes allowed');
            }
            $job->setRegion($region);

            $job->setTitle($requestData['title']);
            $job->setDescription($requestData['description']);
            $job->setJobDate($jobDate);
            $job->setJobUniqueId($this->generateRandomString(20));
            $job->setCreatedAt(new DateTime());
            $job->setUpdatedAt(new DateTime());
            $job->setIsActive(true);

            $this->jobRepository->save($job);
            return true;
        } catch (Exception $e) {
            throw new Exception('Error while creating job. '.$e->getMessage());
        }
    }

    /**
     * @param $requestData
     * @return bool
     * @throws Exception
     */
    public function edit($requestData)
    {
        try {
            if(empty($requestData['userId']) || empty($requestData['jobId'])) {
                throw new Exception('Please request job with user');
            }
            /** @var Job $job */
            $job = $this->jobRepository->findOneBy(['id' => $requestData['jobId'], 'user' => $requestData['userId']]);
            if (empty($job)) {
                throw new Exception('Invalid job');
            }
            $this->create($requestData, $job);
            return true;
        } catch (Exception $e) {
            throw new Exception('Error while saving job. '.$e->getMessage());
        }
    }

    /**
     * @param int $length
     * @return string
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $requestData
     * @return mixed
     * @throws Exception
     */
    public function showAllJobs($requestData)
    {
        try {
            if(empty($requestData['userId'])) {
                throw new Exception('User does not exist');
            }
            /** @var User $user */
            $user = $this->userRepository->findOneBy(['id' => $requestData['userId'], 'role' => 'ADMIN']);
            if (empty($user)) {
                throw new Exception('Invalid User');
            }
            $jobs = $this->jobRepository->findJObsByServiceAndRegion($requestData['servicefilter'], $requestData['regionfilter']);
            return $jobs;
        } catch (Exception $e) {
            throw new Exception('Error while fetching job. '.$e->getMessage());
        }
    }

}