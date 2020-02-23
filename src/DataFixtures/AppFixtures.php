<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Product;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

	public function __construct(ClientRepository $clientRepository, ProductRepository $productRepository, UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
	{
		$this->userRepository = $userRepository;
		$this->clientRepository = $clientRepository;
		$this->productRepository = $productRepository;
		$this->encoder = $encoder;
	}

	public function load(ObjectManager $manager)
	{
		// reset autoincrement à 1
		$this->userRepository->resetIndex();
		$this->clientRepository->resetIndex();
		$this->productRepository->resetIndex();

		$users = [
			[
				"username" => "root",
				"email" => "root@root.fr",
				"role" => '["ROLE_ADMIN"]',
				"password" => "root",
			],
			[
				"username" => "Client 1 SFR",
				"email" => "client-1@sfr.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 1 Bouygues",
				"email" => "client-1@bouygues.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 1 France telecom",
				"email" => "client-1@france-telecom.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 1 Orange",
				"email" => "client-1@orange.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 1 Free",
				"email" => "client-1@free.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 1 La poste",
				"email" => "client-1@la-poste.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 2 SFR",
				"email" => "client-2@sfr.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 2 Bouygues",
				"email" => "client-2@bouygues.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 2 France telecom",
				"email" => "client-2@france-telecom.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 2 Orange",
				"email" => "client-2@orange.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 2 Free",
				"email" => "client-2@free.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
			[
				"username" => "Client 2 La poste",
				"email" => "client-2@la-poste.fr",
				"role" => '["ROLE_CLIENT"]',
				"password" => "root",
			],
		];

		$clients = ['SFR', 'Bouygues', 'France telecom', 'Orange', 'Free', 'La poste'];
		$clientsObj = [];

		$products = [
			[
				"name" => "Apple iPhone 11 Pro Max",
				"price" => 1149,
				"description" => "Cet iPhone cuvée 2019 offre plus de nouveautés qu'il n'y parait. L'autonomie d'abord, tout bonnement impressionnante pour un smarpthone griffée d'une pomme avec plus de deux jours et demi loin d'une prise. Tout simplement l'un des smartphones les plus autonomes du marché. Les aptitudes photo/vidéo ensuite qui boxent voire dépassent les meilleurs photophone sous Android. Avec l'iPhone 11 Pro Max, Apple retrouve sa place sur le podium des meilleurs smartphones premium sur cette fin 2019. L'iPhone le plus abouti que l'on ait testé depuis bien longtemps"
			],
			[
				"name" => "Samsung Galaxy Note 10+",
				"price" => 785,
				"description" => "Le Samsung Galaxy Note 10+ permet à la firme sud-coréenne de différencier de nouveau ses gammes Note et S. Bien pensée du début à la fin, de l'écran au stylet, la phablette XXL de la firme sud-coréenne est un plaisir à utiliser au quotidien et offre une expérience ultra-immersive. Techniquement irréprochable, le Samsung Galaxy Note 10+ brille par sa fluidité. Côté autonomie, il tient la route avec une batterie plus puissante qui gère correctement toute cette débauche d'énergie. On regrette l'absence de port mini-jack comme sur les Samsung Galaxy S10 mais cela est compensé par le reste de la fiche technique premium du flagship de Samsung. Le Galaxy Note 10+ est incontestablement le smartphone le plus abouti de la marque."
			],
			[
				"name" => "Huawei P30 Pro",
				"price" => 489,
				"description" => "Comme ses prédécesseurs de la série P, le P30 Pro mise principalement sur la photo. Cette année, la grande innovation de Huawei est l'intégration d'un capteur photo correspondant à un zoom optique 5x qui offre des résultats franchement impressionnants. Pour parfaire le tableau, cela permet d'obtenir un grossissement hybride 10x d'une qualité inégalée. La partie photo est LA grande réussite de ce smartphone. En revanche, elle ne se fait pas sans contrepartie notamment au niveau du poids du produit et du design qui n'est pas exceptionnel. Il profite tout de même d'un bel écran OLED incurvé de 6,4 pouces, d'une autonomie sensiblement supérieure à la moyenne et d'un capteur d'empreinte sous l'écran."
			],
			[
				"name" => "Xiaomi Mi 9T Pro",
				"price" => 408,
				"description" => "Le Xiaomi Mi 9T Pro est un Mi 9T dopé au Snapdragon 855. Il reprend l'essentiel de la fiche technique de son petit frère ce qui en fait un très bon smartphone qui est en plus vendu à un prix particulièrement agressif. Un écran AMOLED full borderless de qualité, des performances de haute volée, une autonomie confortable, le smartphone de Xiaomi livre une excellente prestation."
			],
			[
				"name" => "Samsung Galaxy A50",
				"price" => 265,
				"description" => "Un grand écran AMOLED, un triple capteur photo qui fait le job et une belle autonomie le Samsung Galaxy A50 a de sérieux arguments qui lui permettent d'être l'une des références sur le segment très concurrencé du milieu de gamme. Commercialisé autour des 349€, Samsung tient là sa réponse aux smartphones chinois portés par Xiaomi et autres Pocophone. Le Galaxy A50 n'est pas parfait pour autant. Son capteur ultra grand-angle, pour commencer, a de nombreuses lacunes de nuit. Si les performances du Samsung Galaxy A50, elles ne permettent pas de profiter d'un multitâche poussé. Enfin, on regrette que le lecteur d'empreintes ne soit pas plus réactif que ça."
			],
			[
				"name" => "Xiaomi Redmi Note 8T",
				"price" => 153,
				"description" => "S'il ne prend pas vraiment de risques, le Xiaomi Redmi Note 8T permet à la firme chinoise de proposer une référence de plus dans son catalogue. Digne remplaçant du Redmi Note 7, il coche toutes les cases et fait preuve d'une belle polyvalence. On lui reprochera toutefois son manque d'originalité visible notamment au niveau de son design, quasiment inchangé par rapport à la génération précédente. Son interface est aussi loin d'être agréable à parcourir puisque trop chargée."
			],
		];

		foreach ($clients as $item) {
			$client = new Client();
			$client->setName($item);
			$manager->persist($client);
			array_push($clientsObj, $client);
		}

		foreach ($users as $key => $item) {
			if ($key != 0) {
				if ($key > 6) {
					$i = $key - 7;
				} else {
					$i = $key - 1;
				}
			} else {
				$i = 1;
			}

			$client = isset($clientsObj[$i]) ? $clientsObj[$i] : false;
			$user = new User();
			$user->setUsername($item['username']);
			$user->setEmail($item['email']);
			$user->setRole($item['role']);
			$user->setPassword($this->encoder->encodePassword($user, $item['password']));
			if ($client && $key !== 0)
				$user->setClient($client);
			$manager->persist($user);
		}

		foreach ($products as $item) {
			$product = new Product();
			$product->setName($item['name']);
			$product->setPrice($item['price']);
			$product->setDescription($item['description']);
			$manager->persist($product);
		}

		$manager->flush();
	}
}
