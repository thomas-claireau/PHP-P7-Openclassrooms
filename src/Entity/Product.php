<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Controller\Api\ApiProductController;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @UniqueEntity("name")
 * @ApiResource(
 * 	collectionOperations={},
 * 	itemOperations={
 *     "showAll"={
 *         "route_name"="api.products.showAll",
 *         "method"="GET",
 *         "path"="/products",
 * 			"swagger_context" = {
 * 			   "parameters" = {},
 * 				"summary" = "List of Bilemo products",
 *              "consumes" = {
 *                  "application/json",
 *               },
 *              "produces" = {
 *                  "application/json"
 *               }
 * 			},
 *     },
 *     "read"={
 * 		   "route_name"="api.products.read",
 *         "method"="GET",
 *         "path"="/products/{id}",
 * 			"swagger_context" = {
 * 				"summary" = "Detail of a Bilemo product",
 * 			    "parameters" = {
 *                  {
 *                      "name" = "id",
 *                      "in" = "path",
 *                      "required" = true,
 *                      "type" = "integer",
 * 						"description" = "Id of your Bilemo product"
 *                  }
 *              },
 *              "consumes" = {
 *                  "application/json",
 *               },
 *              "produces" = {
 *                  "application/json"
 *               }
 * 			}
 *     },
 * }
 * )
 */
class Product
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 * @Serializer\Groups({"showAll"})
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Serializer\Groups({"showAll", "read"})
	 */
	private $name;

	/**
	 * @ORM\Column(type="integer")
	 * @Serializer\Groups({"showAll", "read"})
	 */
	private $price;

	/**
	 * @ORM\Column(type="text")
	 * @Serializer\Groups({"showAll", "read"})
	 */
	private $description;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getPrice(): ?int
	{
		return $this->price;
	}

	public function setPrice(int $price): self
	{
		$this->price = $price;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}
}
