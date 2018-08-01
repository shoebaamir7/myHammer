<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends FOSRestController
{
//    /**
//     * @Route("/job", name="job")
//     */
//    public function index()
//    {
//        return $this->render('job/index.html.twig', [
//            'controller_name' => 'JobController',
//        ]);
//    }

    /**
     *
     * @Route(requirements={"_format"="json|xml"})
     * @Route("/job/create", name="create-job")
     * @param Request $request
     * @return JsonResponse
     */
    public function postJobAction(Request $request)
    {
        $job = ['name' => 'Aamir'];
        /*$data = json_decode(
            $request->request->all(),
            true
        );*/
        dump($request->request->all()); die;
        return new JsonResponse($job);
    }

}
