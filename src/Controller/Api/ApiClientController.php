<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("api/")
 */
class ApiClientController extends AbstractController
{
	/**
	 * @var ClientRepository
	 */
	private $clientRepository;

	/**
	 * @var ObjectManager
	 */
	private $em;

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
	 */
	public function read(Client $client)
	{
		return $client;
	}
}
