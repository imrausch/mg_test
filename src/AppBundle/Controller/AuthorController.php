<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Form\Type\AuthorType;
use AppBundle\Utils\FormErrorsSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorController extends Controller
{
	/**
	 * @return JsonResponse
	 */
	public function getListAction()
	{
		/** @var Author[] $authors */
		$authors = $this->getDoctrine()->getRepository('AppBundle:Author')->findAll();

		$result = [];
		foreach ($authors as $author){
			$result[] = $this->serializeAuthor($author);
		}

		return new JsonResponse($result, 200);
	}

	/**
	 * @param int $id
	 * @return JsonResponse|Response
	 */
	public function getItemAction($id)
	{
		/** @var Author $author */
		$author = $this->getDoctrine()->getRepository('AppBundle:Author')->find($id);
		if (!$author){
			return new Response('', 404);
		}

		return new JsonResponse($this->serializeAuthor($author), 200);
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
			$author = $this->getDoctrine()->getRepository('AppBundle:Author')->find($id);
			if (!$author instanceof Author){
				return new Response('', 404);
			}
		} else {
			$responseStatus = 201;
			$author = new Author();
		}

		$form = $this->createForm(new AuthorType(), $author);
		$form->handleRequest($request);

		if (!$form->isValid()){
			return new JsonResponse(FormErrorsSerializer::serializeErrors($form), 400);
		}

		$this->getDoctrine()->getManager()->persist($author);
		$this->getDoctrine()->getManager()->flush();

		$response = new Response();
		$response->setStatusCode($responseStatus);
		$response->headers->set('Location',
			$this->generateUrl('author_get_item', ['id' => $author->getId()])
		);

		return $response;
	}

	/**
	 * @param int $id
	 * @return JsonResponse|Response|NotFoundHttpException
	 */
	public function deleteItemAction($id)
	{
		$author = $this->getDoctrine()->getRepository('AppBundle:Author')->find($id);
		if (!$author){
			return new Response('', 404);
		}

		$this->getDoctrine()->getManager()->remove($author);
		$this->getDoctrine()->getManager()->flush();

		return new Response('', 204);
	}

	/**
	 * @param Author $author
	 * @return array
	 */
	private function serializeAuthor(Author $author)
	{
		return [
			'id'              => $author->getId(),
			'name'            => $author->getName(),
			'surname'         => $author->getSurname(),
			'cityOfResidence' => $author->getCityOfResidence(),
			'yearOfBirth'     => $author->getYearOfBirth(),
			'yearOfDeath'     => $author->getYearOfDeath(),
		];
	}
}
