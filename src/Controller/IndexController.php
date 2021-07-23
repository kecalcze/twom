<?php declare(strict_types=1);


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index() : Response
    {
        $form = $this->createFormBuilder()
            ->add('id', NumberType::class)
            ->getForm();

        return $this->render('index.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/item/{id}", requirements={"id"="\d+"})
     */
    public function item(string $id) : Response
    {
        return $this->render('item.html.twig',
        ['id' => $id]);
    }
}