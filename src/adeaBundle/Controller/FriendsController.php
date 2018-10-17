<?php

namespace adeaBundle\Controller;
use AppBundle\Entity\idea;
use AppBundle\Entity\note;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\invitation;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ideaType;
use Symfony\Component\HttpFoundation\Response;
class FriendsController extends Controller
{
    /**
     * @Route("/addFollowing/{following}" , name="addFollowing")
     */
    public function AddFollowingAction (User $following)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->forward('AppBundle:Default:index');
        } else {
            $user = $this->getUser();

            if ($user != $following) {
                $friend = new invitation();
                $friend->setFollowing($following);
                $friend->setFollower($user);
                $friend->setInvitDate(date_create(date('Y-m-d H:i:s', time())));
                $doctrine = $this->get('doctrine');
                $manager = $doctrine->getManager();
                $manager->persist($friend);
                $manager->flush();
            }
            return $this->redirectToRoute('profile', array('following' => $following));
        }
    }
    /**
     * @Route("/friends" , name="friends")
     */
    public function friendsAction ()
    {

        $user = $this->getUser();
        if (!$user) {
            return $this->forward('AppBundle:Default:index');
        } else {

        $user = $this->getUser();
        $doctrine = $this->getDoctrine();
        $rep = $doctrine->getRepository('AppBundle:invitation');
        $followers = $rep->findBy(array('follower' => $user), array('invitDate' => 'desc'));
        $followings = $rep->findBy(array('following' => $user), array('invitDate' => 'desc'));

            foreach ($followings as $following){
                $rep = $doctrine->getRepository('AppBundle:User');
                $friend = $rep->findById($following->getFollowing());

                $following->getFollowing()->setUserName($friend[0]->getUserName());


            }
            $followers1=array();
            foreach ($followers as $follower){
                $rep = $doctrine->getRepository('AppBundle:User');
                $friend = $rep->findById($follower->getFollowing());

                $follower->getFollowing()->setUserName($friend[0]->getUserName());
                // on va tester si on est déja follower de ce user
//            pour voir si ilfaut afficher le bouton follow
            $rep = $doctrine->getRepository('AppBundle:invitation');
              $f=$rep->findBy(array('follower' => $user,'following'=>$follower->getFollowing()));

            if ($f){ // si il existe dans la liste des followings
                $followers1[]=array($follower,1);

            }else{
                $followers1[]=array($follower,0);

            }

            }

//dump($followers1);
//            dump($followings);
//            die();


        return $this->render('@adea/Default/friends.html.twig', array('followers' => $followers1, 'followings' => $followings));

    }
}


    /**
     * @Route("/profil/{user}", name="profil")
     */
    public function ProfilAction (Request $request, User $user=null)
    {
        $u = $this->getUser();
        if (!$u) {
            return $this->forward('AppBundle:Default:index');
        } else {

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


//
                $ideasgroup[] = array($idea, $comments, $rating[0]);
            }

            return $this->render('@adea/Default/followingProfile.html.twig', array('ideasgroup' => $ideasgroup));


        }
    }


}
