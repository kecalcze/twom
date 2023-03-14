<?php declare(strict_types=1);


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     * @Route("/{_locale}", requirements={"_locale"="%app.supported_locales%"})
     */
    public function index(Request $request) : Response
    {
        $form = $this->createFormBuilder()
            ->add('id', NumberType::class, ['attr' => [
                    'data-pristine-required' => 'true',
                    'minlength' => '2',
                    'maxlength' => '5',
                    'data-pristine-type' => 'number',
                ]])
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                return $this->redirectToRoute('app_index_item', ['id' => $form->getData()['id']]);
            }
        }

        return $this->render('index.html.twig',
            [
                'form' => $form->createView(),
                'current_locale' => $request->getSession()->get('_locale', 'cs')
            ]
        );
    }

    /**
     * @Route("/item/{id}", requirements={"id"="\d+"})
     * @Route("/item/{id}/{_locale}", requirements={"id"="\d+", "_locale"="%app.supported_locales%"})
     */
    public function item(Request $request, string $id) : Response
    {
        return $this->render('item.html.twig',
            [
                'id' => $id,
                'current_locale' => $request->getSession()->get('_locale', 'cs')
            ]
        );
    }
}