<?php
// gestion des utilisateurs 
namespace OC\PersonnelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCPersonnelBundle:Default:index.html.twig');
    }
}
