<?php

namespace Lic\EcommerceBundle\Controller;

use Lic\EcommerceBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



use Lic\EcommerceBundle\Entity\Produit;

class UserController extends Controller
{
    public function connexionAction()
    {
        return $this->render('@LicEcommerce/user/connexion.html.twig');
    }
    public function getConnexionAction()
    {
        $login=$_POST['login'];
        $password=$_POST['password'];
        return new Response("vous etes connecté en tant que ".$login);
    }
    public function deconnexionAction()
    {
        return $this->render('@LicEcommerce/user/deconnexion.html.twig');
    }

    public function creerCompteAction()
    {
        return $this->render('@LicEcommerce/user/creerCompte.html.twig');
    }


    private function formBienRemplis(){
        $em=$this->getDoctrine()->getManager();
                                          //pour chercher dans notre base si il l'identifiant est déjà utilisée
        $sameId=$em->getRepository('LicEcommerceBundle:Utilisateur')->findOneBy(array('identifiant' => $_POST['identifiant']));

        if(($_POST['identifiant']!=null)&&($_POST['motDePasse']!=null)){    //les champs qui ne doivent pas etre vides
            if (!isset($sameId)) {        // identifiant utilisé
                if (Utilisateur::is_valid_format_date($_POST['anniversaire'])) {
                    return 0;       //si le format de la date est valide
                }
                else {
                    return 1;
                }
            } else {
                return 2;
            }
        }else {
            return 3;
        }

    }
    private function reponsesForm($n){
        switch ($n){
            case 0 :
                $res='Felicitation formulaire bien remplit';
                break;
            case 1 :
                $res='Format de date invalide !';
                break;
            case 2 :
                $res='Attention identifiant dejà existant  veuillez choisir un nouveau !';
                break;
            case 3 :
                $res='mot de passe ou/et identifiant : champ(s) vide(s) veuillez le(s) remplire !';
                break;
            default :
                $res='Ereur reponse formulaire';
                break;
        }
        return $res;
    }

    public function getCreerCompteAction()
    {
            $identifiant=$_POST['identifiant'];
            $motDePasse=sha1($_POST['motDePasse']);
            $nom=$_POST['nom'];
            $prenom=$_POST['prenom'];
            $dateNaissance=$_POST['anniversaire'];

            $em=$this->getDoctrine()->getManager();

                 if($this->formBienRemplis()==0) {

                     $user = new Utilisateur();
                     $user->setIdentifiant($identifiant);
                     $user->setMotdepasse($motDePasse);
                     $user->setNom($nom);
                     $user->setPrenom($prenom);
                     $user->setAnniversaire(\DateTime::createFromFormat('Y-m-d', $dateNaissance));
                     $user->setIsadmin(false);

                     $user->setCreated(new \DateTime("now"));;

                     $em->persist($user);
                     $em->flush();
                     //$this->addFlash('success', "bravo !" . $identifiant);
                     return new Response("Félicitation compte crée avec succé : table mise a jour with id= " . $identifiant);
                 }
                 else {
                     //throw $this->createNotFoundException("Page non trouvé");
                     return new Response($this->reponsesForm($this->formBienRemplis()));
                 }
    }
    public function modifierProfilAction(){
        $myVariable = $this->container->getParameter('userNow');
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('LicEcommerceBundle:Utilisateur')->find($myVariable);

        if($user != null){
            $identifiant=$user->getIdentifiant();
            $motDePasse=$user->getMotdepasse();
            $nom=$user->getNom();
            $prenom=$user->getPrenom();
            $dateDeNaissance=$user->getAnniversaire();
            $args=array(
                'identifiant'=>$identifiant,
                'motDePasse'=>$motDePasse,
                'nom'=>$nom,
                'prenom'=>$prenom,
                'dateDeNaissance'=>$dateDeNaissance
            );
        }else{
            return new Response("vous devez vous connecter ou creer un compte ! (utilisateur non authentifié )");
        }
        return $this->render('@LicEcommerce/user/modifierProfil.html.twig',$args);
    }
    public function getModifierProfilAction()
    {
        $identifiant=$_POST['identifiant'];
        $motDePasse=sha1($_POST['motDePasse']);
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $dateNaissance=$_POST['anniversaire'];

        $em=$this->getDoctrine()->getManager();
        $myVariable = $this->container->getParameter('userNow');

        $user=$em->getRepository('LicEcommerceBundle:Utilisateur')->find($myVariable);

        if($this->formBienRemplis()==0) {
            $user->setIdentifiant($identifiant);
            $user->setMotdepasse($motDePasse);
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setAnniversaire(\DateTime::createFromFormat('Y-m-d', $dateNaissance));
            $user->setModified(new \DateTime("now"));;

            $em->persist($user);
            $em->flush();
            return new Response("Félicitation compte modifié avec succé : table mise a jour  with id= " . $identifiant);
        }
        else {
            return new Response($this->reponsesForm($this->formBienRemplis()));
        }
    }

    public function afficheAction()
    {
        $myVariable = $this->container->getParameter('userNow');
        $em = $this->getDoctrine()->getManager();

        $user=$em->getRepository('LicEcommerceBundle:Utilisateur')->find($myVariable);
        if($user!=null){
            if($user->getIsadmin()==true){
                $utilisateurs=$em->getRepository("LicEcommerceBundle:Utilisateur")->findAll();
                return $this->render('@LicEcommerce/user/users.html.twig',array('utilisateurs'=>$utilisateurs));
            } else {
                return new Response("Action non permise : vous pouvez pas voir les autres utilisateurs ");
            }
        }else {
            return new Response("vous devez vous connecter ou creer un compte ! (utilisateur non authentifié )");
        }
    }
    public function afficheMenuAction()
    {
        $myVariable = $this->container->getParameter('userNow');
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('LicEcommerceBundle:Utilisateur')->find($myVariable);

        return $this->render('@LicEcommerce/menu.html.twig',array("user"=>$user));
    }
    public function testAction()
    {
        $myVariable = $this->container->getParameter('userNow');

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('LicEcommerceBundle:Utilisateur')->find($myVariable);
        if($user==null){
            return new Response("vous devez vous connecter ou creer un compte ! (utilisateur non authentifié )");
        }
        else{
            if($user->getIsadmin()==true){
                return new Response("vous etes authentifié administrateur !");
            }
            else {
                return new Response("authentifié client !");
            }
        }
        return $this->render('@LicEcommerce/Default/test.html.twig',array("user"=>$user));
    }


}

