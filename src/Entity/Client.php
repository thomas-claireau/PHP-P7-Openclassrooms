<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @ApiResource(
 * 	collectionOperations={},
 * 	itemOperations={
 *     "showAll"={
 *         "route_name"="api.clients.showAll",
 *         "method"="GET",
 *         "path"="/clients",
 * 			"swagger_context" = {
 * 			   "parameters" = {},
 * 				"summary" = "List of Bilemo clients",
 *              "consumes" = {
 *                  "application/json",
 *               },
 *              "produces" = {
 *                  "application/json"
 *               }
 * 			},
 *     },
 *     "read"={
 * 		   "route_name"="api.clients.read",
 *         "method"="GET",
 *         "path"="/clients/{id}",
 * 			"swagger_context" = {
 * 				"summary" = "Detail of a Bilemo client",
 * 			    "parameters" = {
 *                  {
 *                      "name" = "id",
 *                      "in" = "path",
 *                      "required" = true,
 *                      "type" = "integer",
 * 						"description" = "Id of your Bilemo client"
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
 * )
 */
class Client
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Serializer\Groups({"showAll", "read"})
	 */
	private $name;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="client", orphanRemoval=true)
	 */
	private $user;

	public function __construct()
	{
		$this->user = new ArrayCollection();
	}

	public function __toString()
	{
		return $this->name;
	}

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

	/**
	 * @return Collection|User[]
	 */
	public function getUser(): Collection
	{
		return $this->user;
	}

	public function addUser(User $user): self
	{
		if (!$this->user->contains($user)) {
			$this->user[] = $user;
			$user->setClient($this);
		}

		return $this;
	}

	public function removeUser(User $user): self
	{
		if ($this->user->contains($user)) {
			$this->user->removeElement($user);
			// set the owning side to null (unless already changed)
			if ($user->getClient() === $this) {
				$user->setClient(null);
			}
		}

		return $this;
	}
}
