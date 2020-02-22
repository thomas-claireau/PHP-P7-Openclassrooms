<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
	 * @Route("api/products", name="api.products.showAll")
	 * @Method("GET")
	 * @return Response
	 */
	public function showAll()
	{
		$products = $this->getDoctrine()->getRepository('App:Product')->findAll();

		$data = $this->serializer->serialize($products, 'json', SerializationContext::create()->setGroups(array('list')));

		$response = new Response($data);
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @Route("api/products/{id}", name="api.products.read")
	 * @Method("GET")
	 * @return Response
	 */
	public function read(Product $product, Request $request)
	{
		$data = $this->serializer->serialize($product, 'json', SerializationContext::create()->setGroups(array('detail')));

		$response = new Response($data);
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}
