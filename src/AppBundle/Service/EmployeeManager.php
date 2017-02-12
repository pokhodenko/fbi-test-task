<?php

namespace AppBundle\Service;

use AppBundle\Entity\Employee;
use Doctrine\ORM\EntityManager;

class EmployeeManager
{
    private $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Create / update employee.
     *
     * @param Employee $employee
     */
    public function save(Employee $employee)
    {
        $this->em->persist($employee);
        $this->em->flush();
    }

    /**
     * Remove an employee (mark as removed).
     *
     * @param Employee $employee
     */
    public function remove(Employee $employee)
    {
        $employee->setRemoved(true);
        $this->em->persist($employee);
        $this->em->flush();
    }

    /**
     * Shortcut function.
     *
     * @return array
     */
    public function findAll()
    {
        return $this->findBy([]);
    }

    /**
     * Finds not removed entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $criteria = array_merge($criteria, ['removed' => false]);
        return $this->em
            ->getRepository('AppBundle:Employee')
            ->findBy($criteria, $orderBy, $limit, $offset);
    }
}
