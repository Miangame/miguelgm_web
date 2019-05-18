<?php

namespace AppBundle\Controller;

use AppBundle\Services\EmailHelper;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /**
     * Muestra el portfolio
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App/portfolio/portfolio.html.twig');
    }

    /**
     * Muestra la vista de contacto
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        return $this->render('@App/portfolio/contact.html.twig');
    }

    /**
     * Envía un email por ajax
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendFormContactAction(Request $request)
    {

        /** @var EmailHelper $emailService */
        $emailService = $this->get("email_helper");

        $name = $request->get("name");
        $email = $request->get("email");
        $comments = $request->get("comments");

        //Respuesta por defecto
        $response = new JsonResponse();
        $result = array(
            "status" => false,
            "msg" => "Ha ocurrido un error. Inténtelo de nuevo más tarde."
        );

        if ($name) {
            if ($email) {
                if ($comments) {
                    $comments = $name . " - " . $email . "<br>----------------------------------------<br>" . $comments;
                    $resultEmail = $emailService->sendEmail("Nuevo mensaje portfolio", $email, "miangame1@gmail.com", $comments);

                    if ($resultEmail) {
                        $result = array(
                            "status" => true,
                            "msg" => "Mensaje enviado correctamente."
                        );
                    }
                } else {

                    $result = array(
                        "status" => false,
                        "msg" => "Escríbeme algo anda :)"
                    );
                }
            } else {
                $result = array(
                    "status" => false,
                    "msg" => "Debes introducir un email."
                );
            }
        } else {
            $result = array(
                "status" => false,
                "msg" => "Pon tu nombre, porfa :)"
            );
        }

        $response->setContent(json_encode($result));

        return $response;
    }
}
