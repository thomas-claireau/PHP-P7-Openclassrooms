<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Repository\ClientRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\ResourceValidationException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("api/")
 */
class ApiClientController extends AbstractController
{
	/**
	 * @var ClientRepository
	 */
	private $clientRepository;

	public function __construct(ClientRepository $clientRepository, ObjectManager $em, SerializerInterface $serializer)
	{
		$this->clientRepository = $clientRepository;
		$this->em = $em;
		$this->serializer = $serializer;
	}

	/**
	 * @Rest\Get(
	 *     path = "clients",
	 *     name = "api.clients.showAll",
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"showAll"}
	 * )
	 */
	public function showAll()
	{
		$clients = $this->clientRepository->findAll();
		return $clients;
	}

	/**
	 * @Rest\Get(
	 *     path = "clients/{id}",
	 *     name = "api.clients.read",
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"read"}
	 * )
	 * @Route("api/")
	 */
	public function read(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$idClient = $params['id'];

		$isIdClientInt = (int) $idClient;

		if ($isIdClientInt || $idClient == "0") {
			$client = $this->getDoctrine()
				->getRepository(Client::class)
				->find($idClient);

			if ($client instanceof Client) {
				return $client;
			}

			throw new ResourceValidationException("The ressource was not found");
		}

		throw new ResourceValidationException("Client ID is not of type integer");
	}
}
