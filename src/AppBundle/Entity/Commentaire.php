<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="user_name", type="string", length=30, nullable=true)
	 */
	private $userName;
	
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="date")
	 */
	private $date;
	
	 /**
     * @ORM\ManyToOne(targetEntity="Circuit", inversedBy="commentaires")
     * (Doctrine OWNING SIDE)
     * @ORM\JoinColumn(name="circuit_id", referencedColumnName="id")
     */
	protected $circuit;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

  
    /**
     * Set circuit
     *
     * @param \AppBundle\Entity\Circuit $circuit
     *
     * @return Commentaire
     */
    public function setCircuit(\AppBundle\Entity\Circuit $circuit = null)
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * Get circuit
     *
     * @return \AppBundle\Entity\Circuit
     */
    public function getCircuit()
    {
        return $this->circuit;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Commentaire
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return Commentaire
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commentaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
