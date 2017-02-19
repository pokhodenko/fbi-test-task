<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Service\EmployeeManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Employee controller.
 *
 * @Route("employee")
 */
class EmployeeController extends Controller
{
    /**
     * Lists all employee entities.
     *
     * @Route("/", name="employee_index")
     * @Method("GET")
     * @Security("has_role('ROLE_WORKER')")
     */
    public function indexAction()
    {
        return $this->render('employee/index.html.twig', array(
            'employees' => $this->getEmployeeManager()->findAll(),
        ));
    }

    /**
     * Creates a new employee entity.
     *
     * @Route("/new", name="employee_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function newAction(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm('AppBundle\Form\EmployeeType', $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getEmployeeManager()->save($employee);

            return $this->redirectToRoute('employee_show', array('id' => $employee->getId()));
        }

        return $this->render('employee/new.html.twig', array(
            'employee' => $employee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a employee entity.
     *
     * @Route("/{id}", name="employee_show")
     * @Method("GET")
     * @Security("has_role('ROLE_WORKER')")
     */
    public function showAction(Employee $employee)
    {
        if ($employee->isRemoved()) {
            throw $this->createNotFoundException();
        }

        $deleteForm = $this->createDeleteForm($employee);

        return $this->render('employee/show.html.twig', array(
            'employee' => $employee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing employee entity.
     *
     * @Route("/{id}/edit", name="employee_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Employee $employee)
    {
        if ($employee->isRemoved()) {
            throw $this->createNotFoundException();
        }

        $deleteForm = $this->createDeleteForm($employee);
        $editForm = $this->createForm('AppBundle\Form\EmployeeType', $employee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_edit', array('id' => $employee->getId()));
        }

        return $this->render('employee/edit.html.twig', array(
            'employee' => $employee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a employee entity.
     *
     * @Route("/{id}", name="employee_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Employee $employee)
    {
        $form = $this->createDeleteForm($employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getEmployeeManager()->remove($employee);
        }

        return $this->redirectToRoute('employee_index');
    }

    /**
     * Creates a form to delete an employee entity.
     *
     * @param Employee $employee The employee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Employee $employee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employee_delete', array('id' => $employee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @return EmployeeManager
     */
    private function getEmployeeManager() {
        return $this->get('app.employee.manager');
    }

}
