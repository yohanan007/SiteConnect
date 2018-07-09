<?php

/*
bundle de gestion d'inscription et de suppression des utilisateurs 
modification des mots de passe générale du site
accéde au donnée des différents utilisateurs
*/

namespace OC\AdministrateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCAdministrateurBundle:Default:index.html.twig');
    }
}
