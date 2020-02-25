<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("name")
 * @ApiResource(
 * 	collectionOperations={},
 * 	itemOperations={
 *     "showAll"={
 *         "method"="GET",
 *         "path"="/users_client/{id}",
 *         "controller"=ApiUserController::class,
 * 			"swagger_context" = {
 * 				"summary" = "List of registered users linked to a client",
 * 			    "parameters" = {
 *                  {
 *                      "name" = "id",
 *                      "in" = "path",
 *                      "required" = true,
 *                      "type" = "string",
 * 						"description" = "Id of your client"
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
 *     "read"={
 *         "method"="GET",
 *         "path"="/users/{id}",
 *         "controller"=ApiUserController::class,
 * 			"swagger_context" = {
 * 				"summary" = "Detail of a registered user",
 * 			    "parameters" = {
 *                  {
 *                      "name" = "id",
 *                      "in" = "path",
 *                      "required" = true,
 *                      "type" = "string",
 * 						"description" = "Id of your user"
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
 *     "createUser"={
 *         "method"="POST",
 *         "path"="/users_client/{id}",
 *         "controller"=ApiUserController::class,
 * 			"swagger_context" = {
 * 				"summary" = "Add a new user linked to a client",
 * 			    "parameters" = {
 *                  {
 *                      "name" = "id",
 *                      "in" = "path",
 *                      "required" = true,
 *                      "type" = "string",
 * 						"description" = "Id of your client. The created user will be linked to this client",
 *                  },
 *                  {
 *                      "name" = "user",
 *                      "in" = "body",
 *                      "required" = true,
 *                      "type" = "string",
 * 						"description" = "Data of your new user",
 * 						"schema": {
 * 							"properties": {
 *         						"name": {
 * 									"type": "string",
 * 									"example": "name of user"
 * 								},
 * 								"email": {
 * 									"type": "string",
 * 									"example": "user@user.fr"
 * 								},
 * 								"password": {
 * 									"type": "string",
 * 									"example": "password"
 * 								},
 * 							}
 * 						 }
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
 *     "deleteUser"={
 *         "method"="DELETE",
 *         "path"="/users/{id}",
 *         "controller"=ApiUserController::class,
 * 			"swagger_context" = {
 * 				"summary" = "Delete a user linked to a client",
 * 				"parameters": {
 * 					{
 * 						"name": "id",
 * 						"in": "path",
 * 						"required": true,
 * 						"type": "string",
 * 						"description": "Id of user to delete"
 * 					}
 * 				},
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
class User implements UserInterface
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
	private $email;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Serializer\Groups({"showAll", "read"})
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Serializer\Groups({"showAll", "read"})
	 */
	private $role;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $password;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="user", fetch="EAGER")
	 * @Serializer\Groups({"showAll", "read"})
	 */
	private $client;

	public function __toString()
	{
		return $this->username;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getUsername(): ?string
	{
		return $this->name;
	}

	public function setUsername(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getRole(): ?string
	{
		return $this->role;
	}

	public function setRole(string $role): self
	{
		$this->role = $role;

		return $this;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	public function getClient(): ?Client
	{
		return $this->client;
	}

	public function setClient(?Client $client): self
	{
		$this->client = $client;

		return $this;
	}

	/**
	 * Returns the roles granted to the user.
	 *
	 *     public function getRoles()
	 *     {
	 *         return array('ROLE_USER');
	 *     }
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return (Role|string)[] The user roles
	 */
	public function getRoles()
	{
		return ['ROLE_ADMIN'];
	}

	/**
	 * Returns the salt that was originally used to encode the password.
	 *
	 * This can return null if the password was not encoded using a salt.
	 *
	 * @return string|null The salt
	 */
	public function getSalt()
	{
		return null;
	}

	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 */
	public function eraseCredentials()
	{
	}
}
