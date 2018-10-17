<?php

namespace AppBundle\Controller;
use AppBundle\Entity\comment;
use AppBundle\Entity\idea;
use AppBundle\Entity\User;
use AppBundle\Entity\note;
use AppBundle\Form\ideaType;
use AppBundle\Form\commentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if ($user) {
            return $this->forward('adeaBundle:Default:findall');
        } else {
            $idea = new idea();
            $form = $this->createForm(ideaType::class, $idea, array('action' => $this->generateUrl('addidea')));


            $doctrine = $this->getDoctrine();
            $rep = $doctrine->getRepository('AppBundle:idea');
            $ideas = $rep->findBy(array(), array('addDate' => 'desc'));
            $ideasgroup = array();
            foreach ($ideas as $idea) {
//pour chaque post on va chercher les notes associés (rating)
                $repository = $this->getDoctrine()
                    ->getRepository(note::class);


                $query = $repository->createQueryBuilder('n')
                    ->Select('AVG(n.note) as moy , COUNT(n.note) as nbr')
                    ->where('n.idea = :idea')
                    ->setParameter('idea', $idea->getId())

                    ->getQuery();

                $rating = $query->getResult();

//pour chaque post on va chercher les comments associés

                $manager = $doctrine->getRepository('AppBundle:comment');
                $comments = $manager->findBy(array('idea' => $idea));

//           ca sert a afficher le formulaire de comment
                $comment = new comment();
                $c = $this->createForm(commentType::class, $comment, array('action' => $this->generateUrl('addcomment', array('idea' => $idea->getId()))));
                $commentForms = $c->createView();
                $ideasgroup[] = array($idea, $commentForms, $comments,$rating[0]);

            }
            return $this->render('default/index.html.twig',array('ideasgroup' => $ideasgroup));
        }
    }
    /**
     * @Route("/admindash")
     */
    public function adminAction(){
        return $this->render('admin.html.twig');
    }
}
