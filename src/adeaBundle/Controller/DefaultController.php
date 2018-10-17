<?php

namespace adeaBundle\Controller;
use AppBundle\Entity\comment;
use AppBundle\Entity\idea;
use AppBundle\Entity\User;
use AppBundle\Entity\note;
use AppBundle\Form\ideaType;
use AppBundle\Form\commentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;


class DefaultController extends Controller
{


    /**
     * @Route("/addidea", name="addidea")
     */
    public function addideaAction (Request $request)
    {  $user = $this->getUser();
        if (!$user) {
            return $this->forward('AppBundle:Default');
        } else {
        $idea = new idea();
        $form = $this->createForm(ideaType::class, $idea);
        $form->handleRequest($request);
        if ($form->isRequired() && $form->isValid()) {

//          upload file
            $file = $form['attachmentPath']->getData();
            $extension_upload = $file->getClientOriginalExtension();
            $x = uniqid();  // retourne un id unique
            $Filename = $x . '.' . $extension_upload;
            $directory = 'img/';
            $file->move($directory, $Filename);

            $user = $this->getUser();

            $idea->setAttachmentPath($directory . $Filename);
            $idea->setIdUser($user);
            $idea->setAddDate(date_create(date('Y-m-d H:i:s', time())));
            $idea->setVisibility(1);
            $idea->setStatus(1);

            $doctrine = $this->get('doctrine');
            $rep = $doctrine->getRepository('AppBundle:idea');
            $manager = $doctrine->getManager();

            $manager->persist($idea);
            $manager->flush();

            return $this->forward('adeaBundle:Default:findAll');
        }
        }
    }


    /**
     * @Route("/home" , name="allideas")
     */
    public function findAllAction ()
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->forward('AppBundle:Default:index');
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
                $ideasgroup[] = array($idea, $commentForms, $comments, $rating[0]);

            }


            return $this->render('@adea/Default/index.html.twig', array('form' => $form->createView(), 'ideasgroup' => $ideasgroup));

        }
    }


    /**
     * @Route("/addcomment/{idea}", name="addcomment")
     */
    public function addcommentAction (Request $request, idea $idea)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->forward('AppBundle:Default:index');
        } else {
            $comment = new comment();
            $form = $this->createForm(commentType::class, $comment);
            $form->handleRequest($request);
            if ($form->isRequired() && $form->isValid()) {
                $comment->setAddDate(date_create(date('Y-m-d H:i:s', time())));
                $comment->setIdea($idea);
                $user = $this->getUser();
                $comment->setUser($user);
                $doctrine = $this->get('doctrine');
                $rep = $doctrine->getRepository('AppBundle:comment');
                $manager = $doctrine->getManager();
                $manager->persist($comment);
                $manager->flush();
                return $this->redirectToRoute('allideas');
            }
        }
    }

// Add rating

    /**
     * @Route("/addRating/{idea}", name="addRating")
     */
    public function addRatingAction (Request $request, idea $idea)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->forward('AppBundle:Default:index');
        } else {
            $user = $this->getUser();
            $doctrine = $this->getDoctrine();
            $rep = $doctrine->getRepository('AppBundle:note');
            // test si le user a déja noté l'idea
            $note = $rep->findOneBy(array('idea' => $idea, 'User' => $user));
//si il a déja noté cette idée on va modifier la note
            if (!$note) {

                $note = new note();
                $note->setUser($user);
                $note->setIdea($idea);
                echo $note->getIdea();

            }
            echo $note->getId();

            $ref = $idea->getId() . 'rating';
            $rating = $_POST[$ref];
            $note->setNote($rating);

            $manager = $doctrine->getManager();

            $manager->persist($note);
            $manager->flush();
            return new Response('success');

        }
    }




//profile***********************************

    /**
     * @Route("/profile", name="profile")
     */
    public function showProfileAction (Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->forward('AppBundle:Default:index');
        } else {
            $user = $this->getUser();
            $idea = new idea();
            $form = $this->createForm(ideaType::class, $idea, array('action' => $this->generateUrl('addidea')));


            $doctrine = $this->getDoctrine();

            $rep = $doctrine->getRepository('AppBundle:idea');
            $ideas = $rep->findBy(array('IdUser' => $user), array('addDate' => 'desc'));
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

                $manager = $doctrine->getRepository('AppBundle:comment');
                $comments = $manager->findBy(array('idea' => $idea), array('addDate' => 'desc'));


//           ca sert a afficher le formulaire de comment
                $comment = new comment();
                $c = $this->createForm(commentType::class, $comment, array('action' => $this->generateUrl('addcomment', array('idea' => $idea->getId()))));
                $commentForms = $c->createView();
                $ideasgroup[] = array($idea, $commentForms, $comments, $rating[0]);
            }

            return $this->render('@adea/Default/profile.html.twig', array('form' => $form->createView(), 'ideasgroup' => $ideasgroup));

        }

    }
}
