<?php

namespace App\Controller;

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
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class JobController
 * @package App\Controller
 */
class JobController extends FOSRestController
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
     * Creates a job
     * @Rest\Post("/job/create")
     * @param Request $request
     * @return JsonResponse
     */
    public function postJobAction(Request $request)
    {
        try {
            $requestData = $request->request->all();
            $this->checkValidations($requestData);
            $jobDate = new DateTime($requestData['jobDate']);
            $jobDate->format('Y-m-d H:i:s');
            $job = new Job();
            $job->setTitle($requestData['title']);
            $job->setDescription($requestData['description']);
            $job->setJobDate($jobDate);
            $job->setJobUniqueId(random_bytes(10));
            $job->setCreatedAt(new DateTime());
            $job->setUpdatedAt(new DateTime());
            $job->setIsActive(true);
            /** @var User $user */
            $user = $this->userRepository->find(1);
            $job->setUser($user);

            /** @var CategoryTypeRepository $categoryType */
            $categoryType = $this->categoryTypeRepository->find(1);
            $job->setCategoryType($categoryType);

            /** @var JobType $jobType */
            $jobType = $this->jobTypeRepository->find(1);
            $job->setJobType($jobType);

            /** @var Region $region */
            $region = $this->regionRepository->find(1);
            $job->setRegion($region);

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return new JsonResponse(['code' => Response::HTTP_OK, 'message' => 'Job created successfully.']);
        } catch (Exception $exception) {
            return new JsonResponse(['code' => Response::HTTP_BAD_REQUEST, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function checkValidations(array $data)
    {
        if(empty($data['title'])) {
            throw new Exception('Title is required.');
        }

        if(empty($data['description'])) {
            throw new Exception('Description is required.');
        }

        if(empty($data['jobDate'])) {
            throw new Exception('Job date is required.');
        }

        $isDateValid = $this->validateDate($data['jobDate'], 'Y-m-d H:i:s');
        if(!$isDateValid) {
            throw new Exception('Job date is invalid.');
        }
    }

    /**
     * @param $date
     * @param string $format
     * @return bool
     */
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
