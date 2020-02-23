<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @Route("api/")
 */
class ApiUserController extends FOSRestController
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
	 * @Rest\Get(
	 *     path = "users_client/{id}",
	 *     name = "api.users.client.showAll",
	 *     requirements = {"id"="\d+"}
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"showAll"}
	 * )
	 */
	public function showAll(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$idClient = $params['id'];

		$users = $this->userRepository->findAllByClient($idClient);

		return $users;
	}

	/**
	 * @Rest\Get(
	 *     path = "users/{id}",
	 *     name = "api.users.read",
	 *     requirements = {"id"="\d+"}
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"read"}
	 * )
	 */
	public function read(User $user)
	{
		return $user;
	}

	/**
	 * @Rest\Post(
	 *     path = "users",
	 *     name = "api.users.create",
	 * )
	 * @Rest\View(
	 * 	StatusCode = 201
	 * )
	 * @ParamConverter("user", converter="fos_rest.request_body")
	 */
	public function createUser(User $user, ConstraintViolationList $violations)
	{
		if (count($violations)) {
			return $this->view($violations, Response::HTTP_BAD_REQUEST);
		}

		$this->em->persist($user);
		$this->em->flush();

		return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl('api.users.read', ['id' => $user->getId()])]);
	}
}
