<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
//    /**
//     * @Route("/add")
//     */
//    public function addAction()
//    {
//        $userManager = $this->container->get('fos_user.user_manager');
//        $user = $userManager->createUser();
//        $user->setUsername('admin');
//        $user->setRoles(array('ROLE_ADMIN'));
//        $user->setEmail('admin@gmail.com');
//        $user->setPlainPassword('admin');
//        $user->setEnabled(true);
//        $userManager->updateUser($user);
//        return $this->forward('AppBundle:Security:redirect');
//    }

    /**
     * @Route("/Acceuil")
     */
    public function redirectAction()
    {

        $authChecker = $this->container->get('security.authorization_checker');

        if ($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('@App/Security/admin_home.html.twig',array('msg'=>'i m admin'));
        }else if($authChecker->isGranted('ROLE_USER')){
            return $this->forward('adeaBundle:Default:findAll');
        }else{
            return $this->render('@FOSUser/Security/login.html.twig');
        }

    }
}