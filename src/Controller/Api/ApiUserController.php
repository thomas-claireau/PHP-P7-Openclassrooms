<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Client;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

	public function __construct(UserRepository $userRepository, ObjectManager $em, SerializerInterface $serializer, UserPasswordEncoderInterface $encoder)
	{
		$this->userRepository = $userRepository;
		$this->em = $em;
		$this->serializer = $serializer;
		$this->encoder = $encoder;
	}

	/**
	 * @Rest\Get(
	 *     path = "users_client/{id}",
	 *     name = "api.users.client.showAll",
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"showAll"}
	 * )
	 * @Route("api/")
	 */
	public function showAll(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$idClient = $params['id'];

		$isIdClientInt = (int) $idClient;

		if ($isIdClientInt || $idClient == "0") {
			$users = $this->userRepository->findAllByClient($idClient);

			if ($users) {
				return $users;
			}

			throw new ResourceValidationException("The ressource was not found");
		}

		throw new ResourceValidationException("Client ID is not of type integer");
	}

	/**
	 * @Rest\Get(
	 *     path = "users/{id}",
	 *     name = "api.users.read",
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"read"}
	 * )
	 * @Route("api/")
	 */
	public function read(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$idUser = $params['id'];

		$isIdUserInt = (int) $idUser;

		if ($isIdUserInt || $idUser == "0") {
			$user = $this->getDoctrine()
				->getRepository(User::class)
				->find($idUser);

			if ($user instanceof User) {
				return $user;
			}

			throw new ResourceValidationException("The ressource was not found");
		}

		throw new ResourceValidationException("User ID is not of type integer");
	}

	/**
	 * @Rest\Post(
	 *     path = "users_client/{id}",
	 *     name = "api.users.create",
	 * 	   requirements = {"id"="\d+"}
	 * )
	 * @Rest\View(
	 * 	StatusCode = 201,
	 * 	serializerGroups = {"read"}
	 * )
	 * @ParamConverter("user", converter="fos_rest.request_body")
	 * @Route("api/")
	 */
	public function createUser(User $user, ConstraintViolationList $violations, Request $request)
	{
		if (count($violations)) {
			$message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
			foreach ($violations as $violation) {
				$message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
			}

			throw new ResourceValidationException($message);
		}

		$params = $request->attributes->get('_route_params');
		$idClient = $params['id'];

		if ($user instanceof User) {
			$name = $user->getUsername();
			$password = $user->getPassword();
			$email = $user->getEmail();

			$isNameInt = (int) $name;
			$isEmailInt = (int) $email;

			if (!$isNameInt && !$isEmailInt) {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					throw new ResourceValidationException("The email address is invalid");
				}

				$client = $this->getDoctrine()
					->getRepository(Client::class)
					->find($idClient);

				$user->setPassword($this->encoder->encodePassword($user, $password));
				$user->setClient($client);
				$user->setRole('["ROLE_CLIENT"]');
				$this->em->persist($user);
				$this->em->flush();

				return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl('api.users.read', ['id' => $user->getId()])]);
			}

			throw new ResourceValidationException("Data is not submitted in the correct format");
		}
	}

	/**
	 * @Rest\Put(
	 *     path = "users/{id}",
	 *     name = "api.users.update",
	 * 	   requirements = {"id"="\d+"}
	 * )
	 * @Rest\View(
	 * 	StatusCode = 200,
	 * 	serializerGroups = {"read"}
	 * )
	 * @ParamConverter("user", converter="fos_rest.request_body")
	 * @Route("api/")
	 */
	public function updateUser(User $user, ConstraintViolationList $violations, Request $request)
	{
		if (count($violations)) {
			$message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
			foreach ($violations as $violation) {
				$message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
			}

			throw new ResourceValidationException($message);
		}

		$params = $request->attributes->get('_route_params');
		$idUser = $params['id'];

		$userExist = $this->getDoctrine()
			->getRepository(User::class)
			->find($idUser);

		if ($userExist instanceof User) {
			$name = $user->getUsername();
			$password = $user->getPassword();
			$email = $user->getEmail();

			$isNameInt = (int) $name;
			$isEmailInt = (int) $email;

			if (!$isNameInt && !$isEmailInt) {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					throw new ResourceValidationException("The email address is invalid");
				}
				$userExist->setUsername($name);
				$userExist->setPassword($this->encoder->encodePassword($userExist, $password));
				$userExist->setEmail($email);

				$this->em->persist($userExist);
				$this->em->flush();

				return $this->view($userExist, Response::HTTP_OK, ['Location' => $this->generateUrl('api.users.read', ['id' => $userExist->getId()])]);
			}

			throw new ResourceValidationException("Data is not submitted in the correct format");
		}
	}

	/**
	 * @Rest\Delete(
	 *     path = "users/{id}",
	 *     name = "api.users.delete",
	 * )
	 * @Rest\View(
	 * 	StatusCode = 204,
	 * 	serializerGroups = {"read"}
	 * )
	 * @Route("api/")
	 */
	public function deleteUser(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$idUser = $params['id'];

		$isIdUserInt = (int) $idUser;

		if ($isIdUserInt || $idUser == "0") {
			$user = $this->getDoctrine()
				->getRepository(User::class)
				->find($idUser);

			if ($user instanceof User) {
				$roleUser = $user->getRole();

				if ($roleUser !== '["ROLE_ADMIN"]') {
					$this->em->remove($user);
					$this->em->flush();
					return $this->view('', Response::HTTP_NO_CONTENT);
				}

				throw new ResourceValidationException('Unable to delete an administrator');
			}

			throw new ResourceValidationException("The ressource was not found");
		}

		throw new ResourceValidationException("User ID is not of type integer");
	}
}
