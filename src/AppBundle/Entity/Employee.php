<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Employee
 *
 * @ORM\Table(name="employee", indexes={@ORM\Index(name="is_removed", columns={"is_removed"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 */
class Employee
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
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="datetime")
     */
    private $dateOfBirth;

    /**
     * @var Phone[]|ArrayCollection
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Phone", mappedBy="employee", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $phones;

    /**
     * @var Address[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Address", mappedBy="employee", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $addresses;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="salary", type="decimal", precision=10, scale=2)
     */
    private $salary;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", options={"default": 1})
     */
    private $active = true;


    /**
     * @var bool
     *
     * @ORM\Column(name="is_removed", type="boolean", options={"default": 0})
     */
    private $removed = false;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Employee
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Employee
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Employee
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Employee
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Get phones
     *
     * @return Phone[]|ArrayCollection
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add phone
     *
     * @param Phone $phone
     *
     * @return Employee
     */
    public function addPhone($phone)
    {
        $phone->setEmployee($this);
        $this->phones->add($phone);

        return $this;
    }

    /**
     * Remove phone
     *
     * @param Phone $phone
     *
     * @return Employee
     */
    public function removePhone($phone)
    {
        $this->phones->removeElement($phone);

        return $this;
    }

    /**
     * Get addresses
     *
     * @return Address[]|ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add address
     *
     * @param Address $address
     *
     * @return Employee
     */
    public function addAddress(Address $address)
    {
        $address->setEmployee($this);

        $this->addresses->add($address);

        return $this;
    }

    /**
     * Remove address
     *
     * @param Address $address
     *
     * @return Employee
     */
    public function removeAddress(Address $address)
    {
        $this->addresses->removeElement($address);

        return $this;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Employee
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set salary
     *
     * @param string $salary
     *
     * @return Employee
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return string
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Check if user is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Checks if user is removed.
     *
     * @return bool
     */
    public function isRemoved() {
        return $this->removed;
    }

    /**
     * Set removed
     *
     * @param bool $removed
     */
    public function setRemoved($removed)
    {
        $this->removed = $removed;
    }
}

