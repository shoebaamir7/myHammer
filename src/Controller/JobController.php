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
use App\Service\JobService;
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
     * @var JobService
     */
    public $jobService;

    /**
     * JobController constructor.
     * @param JobService $jobService
     */
    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
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
            $this->requestValidations($requestData);
            $this->jobService->create($requestData);
            return new JsonResponse(['code' => Response::HTTP_OK, 'message' => 'Job created successfully.']);
        } catch (Exception $exception) {
            return new JsonResponse(['code' => Response::HTTP_BAD_REQUEST, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Creates a job
     * @Rest\Post("/job/edit")
     * @param Request $request
     * @return JsonResponse
     */
    public function postJobEditAction(Request $request)
    {
        try {
            $requestData = $request->request->all();
            $this->requestValidations($requestData);
            $this->jobService->edit($requestData);
            return new JsonResponse(['code' => Response::HTTP_OK, 'message' => 'Job saved successfully.']);
        } catch (Exception $exception) {
            return new JsonResponse(['code' => Response::HTTP_BAD_REQUEST, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Creates a job
     * @Rest\Post("/jobs", name="show-jobs")
     * @param Request $request
     * @return JsonResponse
     */
    public function postJobShowAction(Request $request)
    {
        try {
            $requestData = $request->request->all();
            $jobs = $this->jobService->showAllJobs($requestData);
            return new JsonResponse(['code' => Response::HTTP_OK, 'message' => Response::$statusTexts[Response::HTTP_OK], 'jobs' => $jobs]);
        } catch (Exception $exception) {
            return new JsonResponse(['code' => Response::HTTP_BAD_REQUEST, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function requestValidations(array $data)
    {
        if(empty($data['title'])) {
            throw new Exception('Title is invalid.');
        }

        if(strlen($data['title']) < 5 || strlen($data['title']) > 50) {
            throw new Exception('Title should be between 5 and 50 characters');
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
