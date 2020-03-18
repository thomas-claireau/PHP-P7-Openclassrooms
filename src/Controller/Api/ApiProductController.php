<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
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
class ApiProductController extends AbstractController
{
	/**
	 * @var ProductRepository
	 */
	private $productRepository;

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
	 * @Route("api/")
	 */
	public function read(Request $request)
	{
		$params = $request->attributes->get('_route_params');
		$idProduct = $params['id'];

		$isIdProductInt = (int) $idProduct;

		if ($isIdProductInt || $idProduct == "0") {
			$product = $this->getDoctrine()
				->getRepository(Product::class)
				->find($idProduct);

			if ($product instanceof Product) {
				return $product;
			}

			throw new ResourceValidationException("The ressource was not found");
		}

		throw new ResourceValidationException("Product ID is not of type integer");
	}
}
