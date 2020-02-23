<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ApiUserController extends AbstractController
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var ObjectManager
	 */
	private $em;

	public function __construct(UserRepository $userRepository, ObjectManager $em, SerializerInterface $serializer)
	{
		$this->userRepository = $userRepository;
		$this->em = $em;
		$this->serializer = $serializer;
	}

	/**
	 * @Route("api/users_client/{idClient}", name="api.users.showAll")
	 * @Method("GET")
	 * @return Response
	 */
	public function showAll(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$idClient = $params['idClient'];

		$users = $this->userRepository->findAllByClient($idClient);

		$data = $this->serializer->serialize($users, 'json', SerializationContext::create()->setGroups(array('showAll')));

		$response = new Response($data);
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("api/users/{id}", name="api.users.read")
	 * @Method("GET")
	 * @return Response
	 */
	public function read(User $user, Request $request)
	{
		$data = $this->serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array('read')));

		$response = new Response($data);
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}
