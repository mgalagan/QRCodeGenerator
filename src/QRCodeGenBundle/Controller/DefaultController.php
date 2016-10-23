<?php

namespace QRCodeGenBundle\Controller;

use QRCodeGenBundle\Entity\QRCode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * main action
     * @Route("/", name="qr_code_gen_main")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $code = new QRCode();
        // manually set form method to avoid bad processing
        $form = $this->createFormBuilder($code, ['method' => 'POST'])
            ->add('text', TextType::class)
            ->add('width', IntegerType::class)
            ->add('height', IntegerType::class)
            ->add('generate', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $this->get('qr_code_gen.generator.qr')->generate($code);

            return $this->render('QRCodeGenBundle:Default:index.html.twig', [
                'error' => $data['error'],
                'image' => [
                    'data' => base64_encode($data['image']),
                    'type' => $data['type'],
                    'width' => $code->getWidth(),
                    'height' => $code->getHeight(),
                ]
            ]);
        }

        return $this->render('QRCodeGenBundle:Default:index.html.twig', ['form' => $form->createView()]);
    }
}
