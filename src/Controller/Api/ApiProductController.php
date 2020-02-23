<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("api/")
 */
class ApiProductController extends AbstractController
{
	/**
	 * @var ProductRepository
	 */
	private $productRepository;

	/**
	 * @var ObjectManager
	 */
	private $em;

	public function __construct(ProductRepository $productRepository, ObjectManager $em, SerializerInterface $serializer)
	{
		$this->productRepository = $productRepository;
		$this->em = $em;
		$this->serializer = $serializer;
	}

	/**
	 * @Rest\Get(
	 *     path = "products",
	 *     name = "api.products.showAll",
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"showAll"}
	 * )
	 */
	public function showAll()
	{
		$products = $this->productRepository->findAll();
		return $products;
	}

	/**
	 * @Rest\Get(
	 *     path = "products/{id}",
	 *     name = "api.products.read",
	 * )
	 * @Rest\View(
	 * 	serializerGroups = {"read"}
	 * )
	 */
	public function read(Product $product)
	{
		return $product;
	}
}
