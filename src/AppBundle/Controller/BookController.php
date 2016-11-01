<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Book;
use AppBundle\Form\Type\BookType;
use AppBundle\Utils\FormErrorsSerializer;
use AppBundle\Utils\ViolationListMessagesSerializer;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends Controller
{
	/**
	 * @return JsonResponse
	 */
	public function getListAction()
	{
		/** @var EntityManager $em */
		$em = $this->getDoctrine()->getManager();

		$now = new \DateTime();
		$year = (int)$now->format('Y');
		$year = $year - 100;

		$qb = $em->createQueryBuilder()
			->select('b')
			->from('AppBundle:Book', 'b')
			->leftJoin('b.authors', 'a')
			->where('a.id IS NULL OR a.id NOT IN (SELECT a2.id FROM AppBundle:Author a2 WHERE a2.yearOfDeath IS NOT NULL AND a2.yearOfDeath > :y )')
			->setParameter('y', $year);

		/** @var Book[] $books */
		$books = $qb->getQuery()->getResult();

		//$books = $this->getDoctrine()->getRepository('AppBundle:Book')->findAll();
		/** @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator */
		//$validator = $this->get('validator');

		$result = [];
		foreach ($books as $book){
			//$errors = $validator->validate($book, null, ['Show']);
			//if (count($errors) == 0){
				$result[] = $this->serializeBook($book);
			//}
		}

		return new JsonResponse($result, 200);
	}

	/**
	 * @param int $id
	 * @return JsonResponse|Response
	 */
	public function getItemAction($id)
	{
		/** @var Book $book */
		$book = $this->getDoctrine()->getRepository('AppBundle:Book')->find($id);
		if (!$book){
			return new Response('', 404);
		}

		/** @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator */
		$validator = $this->get('validator');
		$errors = $validator->validate($book, null, ['Show']);
		if (count($errors) > 0){
			return new JsonResponse(ViolationListMessagesSerializer::serializeMessages($errors), 400);
		}

		return new JsonResponse($this->serializeBook($book), 200);
	}

	/**
	 * @param int $id
	 * @param Request $request
	 * @return JsonResponse|Response
	 * @throws NotFoundHttpException
	 */
	public function editItemAction($id, Request $request)
	{
		if ($id){
			$responseStatus = 204;
			$book = $this->getDoctrine()->getRepository('AppBundle:Book')->find($id);
			if (!$book instanceof Book){
				return new Response('', 404);
			}
			$validationGroups = ['Edit'];
		} else {
			$responseStatus = 201;
			$book = new Book();
			$validationGroups = ['Add'];
		}

		$form = $this->createForm(new BookType(), $book, ['validation_groups' => $validationGroups]);
		$form->handleRequest($request);

		if (!$form->isValid()){
			return new JsonResponse(FormErrorsSerializer::serializeErrors($form), 400);
		}

		$this->getDoctrine()->getManager()->persist($book);
		$this->getDoctrine()->getManager()->flush();

		$response = new Response();
		$response->setStatusCode($responseStatus);
		$response->headers->set('Location',
			$this->generateUrl('book_get_item', ['id' => $book->getId()])
		);

		return $response;
	}

	/**
	 * @param int $id
	 * @return JsonResponse|Response|NotFoundHttpException
	 */
	public function deleteItemAction($id)
	{
		$book = $this->getDoctrine()->getRepository('AppBundle:Book')->find($id);
		if (!$book){
			return new Response('', 404);
		}

		/** @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator */
		$validator = $this->get('validator');
		$errors = $validator->validate($book, null, ['Delete']);
		if (count($errors) > 0){
			return new JsonResponse(ViolationListMessagesSerializer::serializeMessages($errors), 400);
		}

		$this->getDoctrine()->getManager()->remove($book);
		$this->getDoctrine()->getManager()->flush();

		return new Response('', 204);
	}

	/**
	 * @param Book $book
	 * @return array
	 */
	private function serializeBook(Book $book)
	{
		$result = [
			'id'          => $book->getId(),
			'name'        => $book->getName(),
			'color'       => $book->getColor(),
			'cityOfIssue' => $book->getCityOfIssue(),
			'yearOfIssue' => $book->getYearOfIssue(),
			'authors'     => [],
		];
		foreach ($book->getAuthors() as $author){
			/** @var Author $author */
			$result['authors'][] = $author->getId();
		}

		return $result;
	}
}
