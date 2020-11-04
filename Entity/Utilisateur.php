<?php

namespace Lic\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="im1920_utilisateurs")
 * @ORM\Entity(repositoryClass="Lic\EcommerceBundle\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="identifiant", type="string", length=30, unique=true ,options={"comment"="sert de login"})
     */
    private $identifiant;

    /**
     * @var string
     *
     * @ORM\Column(name="motdepasse", type="string", length=60,options={"comment"="mot de passe crypté : il faut une taille assez grande pour ne pas le tronquer"})
     */
    private $motdepasse;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=true,options={"default"=NULL})
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=true,options={"default"=NULL})
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anniversaire", type="date", nullable=true,options={"default"=NULL})
     */
    private $anniversaire;

    /**
     * @var int
     *
     * @ORM\Column(name="isadmin", type="boolean",options={"default"=0})
     */
    private $isadmin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true,options={"default"=NULL})
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true,options={"default"=NULL})
     */
    private $modified;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifiant
     *
     * @param string $identifiant
     *
     * @return Utilisateur
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set motdepasse
     *
     * @param string $motdepasse
     *
     * @return Utilisateur
     */
    public function setMotdepasse($motdepasse)
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    /**
     * Get motdepasse
     *
     * @return string
     */
    public function getMotdepasse()
    {
        return $this->motdepasse;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set anniversaire
     *
     * @param \DateTime $anniversaire
     *
     * @return Utilisateur
     */
    public function setAnniversaire($anniversaire)
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    /**
     * Get anniversaire
     *
     * @return \DateTime
     */
    public function getAnniversaire()
    {
        return $this->anniversaire;
    }

    /**
     * Set isadmin
     *
     * @param integer $isadmin
     *
     * @return Utilisateur
     */
    public function setIsadmin($isadmin)
    {
        $this->isadmin = $isadmin;

        return $this;
    }

    /**
     * Get isadmin
     *
     * @return int
     */
    public function getIsadmin()
    {
        return $this->isadmin;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Utilisateur
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Utilisateur
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set is valid format date
     *
     * @param string $format
     *
     * @return boolean
     */
    public static function is_valid_format_date($format)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$format)){
            return true;    //l'expression reguliere de la date doit etre sous cette forme
        }else{
            return false;
        }
    }




}

