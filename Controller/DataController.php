<?php

namespace Lic\EcommerceBundle\Controller;

use Lic\EcommerceBundle\Entity\Panier;
use Lic\EcommerceBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Lic\EcommerceBundle\Entity\Produit;

class DataController extends Controller
{
    public function loadAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produit1=new Produit();
        $produit1->setLibelle('iphone6');
        $produit1->setPrix(300.00);
        $produit1->setQuantite(2);
        $em->persist($produit1);


        $produit2=new Produit();
        $produit2->setLibelle('iphone7');
        $produit2->setPrix(400.00);
        $produit2->setQuantite(3);
        $em->persist($produit2);

        $produit3=new Produit();
        $produit3->setLibelle('iphone8');
        $produit3->setPrix(600.00);
        $produit3->setQuantite(8);
        $em->persist($produit3);

        $em->flush();

        return new Response("data has been loaded");
    }
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits=$em->getRepository("LicEcommerceBundle:Produit")->findAll();
        return $this->render('@LicEcommerce/data/list.html.twig',array('produits'=>$produits));
    }
    public function getListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $myVariable = $this->container->getParameter('userNow');
        $user=$em->getRepository('LicEcommerceBundle:Utilisateur')->find($myVariable);



        $prods_chooses=$_POST['prod'];
        foreach($prods_chooses as $cle => $quantite) {
            if ($quantite != 0){
                $prod_choose=$em->getRepository('LicEcommerceBundle:Produit')->find($cle);//produit choisit

                $panier=$em->getRepository('LicEcommerceBundle:Panier')->findOneBy(Array('utilisateur'=>$user,'produit'=>$prod_choose));

                if($panier==null) {
                    //si l'utilisateur n'a pas ce produit dans son panier
                    $panier = new Panier();
                    $panier->setUtilisateur($user);
                    $panier->setQuantite($quantite);
                    $panier->setProduit($prod_choose);
                }
                else{
                    //si le même produit a dèjà été ajouté ,il ne doit apparaı̂tre qu’une seule fois dans la liste
                    $new_quantite=$panier->getQuantite()+$quantite;
                    $panier->setQuantite($new_quantite);
                }
                $em->persist($panier);
                $em->flush();

                //pour modifier la quantité du produit dans le stock
                $quantiteRestante=$prod_choose->getQuantite()-$quantite;
                $prod_choose->setQuantite($quantiteRestante);
                $em->persist($prod_choose);
                $em->flush();
            }
        }
       $produits=$em->getRepository("LicEcommerceBundle:Produit")->findAll();

        return $this->redirectToRoute('lic_ecommerce_data_list',array('produits'=>$produits));
    }
}