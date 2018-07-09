<?php
// gestion generale du site 
namespace OC\BlogBundle\Controller;

use OC\BlogBundle\Entity\Image;

use OC\GestionBundle\Entity\ImageA;
use OC\GestionBundle\Entity\Section;
use OC\GestionBundle\Entity\TextA;
use OC\GestionBundle\Entity\Article;
use OC\PersonnelBundle\Entity\User;

use Symfony\Component\Form\Forms;

use OC\BlogBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@OCBlog/Default/index.html.twig');
    }
    
    public function acceuilAction()
    {
        // recherche des sections pour la generation du menu 
        $em = $this->getDoctrine()->getRepository(Section::class);
        $section = $em->findAll();
        
        $emArticle = $this->getDoctrine()->getManager()->getRepository(Article::class);
        $dernierArticle = $emArticle->findLastArticle();
        
        return $this->render('@OCBlog/Default/acceuil.html.twig',array('section'=>$section,'article'=>$dernierArticle));
        
    }
    
    public function transferAction(Request $request)
    {
        if (!empty($_FILES['ionicFile']['name']))
        {
      try
        {
          $target_dir = $this->container->getParameter('file_directory');
          $target_file = $target_dir . basename($_FILES['ionicFile']['name']);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          $check = getimagesize($_FILES['ionicFile']['tmp_name']);
          if ($check !== false)
          {
              $uploadOk = 1;
          }
          else {
              $uploadOk = 0;
          }
          if (move_uploaded_file($_FILES['ionicFile']['tmp_name'],$target_file.'new.jpg'))
          {
              return 1;
          }
            
        } catch(Exception $e){
        $array = array('status'=> 0);
     }
     
    /*try {
          $image = new Image();
         
            $data = $request->request->all();
            $file = $request->files->get('ionicFile');
             
                    $image ->setFile($file);
                 $em = $this->getDoctrine()->getManager();
               $em->persist($image);
               $em->flush();   
                $array = array('status' => 1);    
     } catch(Exception $e){
          $array = array('status'=> 0);
         
     }*/
  
     return new JsonResponse($array);
    
        }
        
      // controller gerant le transfer d'image venant d'apli 
     
      return $this->render('@OCBlog/Default/transfer.html.twig',array('variable'=>0));
      
    }
    
    public function authentificationAction(Request $request)
    {
       
        if(!empty($request->get('user'))&&(!empty($request->get('mdp'))))
        {
           $user = $request->get('user');
           $mdp = $request->get('mdp');
           
           $userManager = $this->get('fos_user.user_manager');
           // encode password
           
           $result = $userManager->findUserBy(array('username'=>$user));
          // on cherche le service encode password et on verifie si le password est bon 
           $encoder_service = $this->get('security.encoder_factory');
           $encoder = $encoder_service->getEncoder($result);
           if($encoder->isPasswordValid($result->getPassword(), $mdp, $result->getSalt()))
           {
               // on ne peut envoyer directement l'entité qui n'est pas sous forme de tableau, on doit donc serializer l'entity
               // ou envoyer sous forme 'manuel' et json 
            return new JsonResponse(array('user'=>$result->getUsername(),'authentification'=>'ok'));
           }
           else {
               return new JsonResponse(array('authentification'=>'no'));
           }
        }
        
       return $this->render('@OCBlog/Default/transfer.html.twig');
        
    }
    
    public function imageAction(Request $request)
    {
        $image = new Image();
        $form = $this->get('form.factory')->create(ImageType::class, $image);
        
       $form->handleRequest($request);
      if ($request->isMethod('POST'))
       {
           if($form->isValid())
           {
               $image = $form->getData();
               
               $em = $this->getDoctrine()->getManager();
               $em->persist($image);
               $em->flush();
               return $this->redirectToRoute('oc_blog_homepage');
           }
       }
       
       return $this->render('@OCBlog/Default/image.html.twig', array('form'=>$form->createView()));
    }
    
    public function biblioAction(Request $request)
    {
        if (!empty($request->get('user')))
        {
            $user = $request->get('user');
            $mdp = $request->get('mdp');
            
                $em = $this->getDoctrine()->getRepository(Image::class);
                $image = $em->findAll();
                $tab = [];
                foreach ($image as $img)
                {
                    $tab[] = [ 
                        'user' => $user,
                        'mdp' => $mdp,
                    'id' => $img->getId(),
                    'url' => $img->getAdresse()
                    ];
                }
              //  $id = $image->getId();
              //  $url = $image->getUrl();
            //  $formated = array('id'=>$id, 'url'=>$url);
                return new JsonResponse($tab);
            
        }
        
        return $this->redirectToRoute('oc_blog_homepage');
    }
    
    public function bibliositeAction()
    {
        $em = $this->getDoctrine()->getRepository(Image::class);
        $image = $em->findAll();
        return $this->render('@OCBlog/Default/imageToute.html.twig',array('allImage'=>$image));
    }
    
}
