<?php

namespace Miguelgm\TelegramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Telegram/Default/index.html.twig');
    }
}
