<?php
/*bundle gestion de nouvelle page sur le site 
plan generale d'une page 
différente page peuvent être contenu dans un chapitre
on appel page un contenu 
un contenu peut contenir  différentes sections
une section peut contenir différents articles
un article contient du texte et peut contenir une image
*/
namespace OC\GestionBundle\Controller;

use OC\GestionBundle\Entity\ImageA;
use OC\GestionBundle\Entity\Section;
use OC\GestionBundle\Entity\TextA;
use OC\GestionBundle\Entity\Article;
use OC\PersonnelBundle\Entity\User;
use Symfony\Component\Form\Forms;

use OC\PersonnelBundle\Form\RegistrationType;
use OC\GestionBundle\Form\ImageAType;
use OC\GestionBundle\Form\SectionType;
use OC\GestionBundle\Form\TextAType;
use OC\GestionBundle\Form\ArticleType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@OCGestion/Default/index.html.twig');
    }
    
    public function blogAction(Request $request)
    {   
        $article = new Article();
        $form = $this->get('form.factory')->create(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if ($request->isMethod('POST'))
        {
            if($form->isValid())
          {  
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->persist($article->getSection());
        
            $em->flush();
        return $this->redirectToRoute('oc_blog_homepage');
          }      
            
        }
        return $this->render('@OCGestion/Default/blog.html.twig', array('forms' => $form->createView() ));
    }
    
    public function utilisateursAction(Request $request)
    {
        $user = new User();
        $form = $this->get('form.factory')->create(RegistrationType::class, $user);
        return $this->render('@OCGestion/Default/utilAcceuil.html.twig', array('forms'=>$form->createView()));
    }
}
