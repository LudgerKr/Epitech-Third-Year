<?php

namespace App\Controller\Api\Discount;

use App\Entity\Discount;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteController
 * @package App\Controller\Api\Discount
 * @Route("/api",name="api_")
 *
 */
class DeleteController extends AbstractFOSRestController
{
    /**
     * @Rest\Delete("/discount/{id}", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return FormInterface|Response
     */
    public function deleteDiscountAction(Request $request, EntityManagerInterface $em)
    {
        $discount = $em->getRepository(Discount::class)->find($request->get('id'));

        if(empty($discount)) {
            return $this->handleView($this->view(['status'=>'Discount not found'],Response::HTTP_NOT_FOUND));
        }

        $em->remove($discount);
        $em->flush();

        return $this->handleView($this->view('Discount deleted', Response::HTTP_ACCEPTED));
    }
}
