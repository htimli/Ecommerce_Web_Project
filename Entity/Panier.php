<?php

namespace Lic\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="im1920_paniers")
 * @ORM\Entity(repositoryClass="Lic\EcommerceBundle\Repository\PanierRepository")
 */
class Panier
{

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var Produit
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Lic\EcommerceBundle\Entity\Produit")
     * @ORM\JoinColumn(name="id_produit", nullable=false)
     */
    //ManytoOne car un panier possède plusieurs produits
    //pareil pour utilisateur
    private $produit;

    /**
     * @var Utilisateur
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Lic\EcommerceBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="id_utilisateur", nullable=false)
     */

    private $utilisateur;


    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Panier
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set produit
     *
     * @param \Lic\EcommerceBundle\Entity\Produit $produit
     *
     * @return Panier
     */
    public function setProduit(\Lic\EcommerceBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \Lic\EcommerceBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set utilisateur
     *
     * @param \Lic\EcommerceBundle\Entity\Utilisateur $utilisateur
     *
     * @return Panier
     */
    public function setUtilisateur(\Lic\EcommerceBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Lic\EcommerceBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
