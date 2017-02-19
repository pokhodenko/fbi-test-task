<?php
/**
 * @file
 * File description. 
 */

namespace tests\FBI\UserBundle\Entity;


use FBI\UserBundle\Entity\Role;

class RolesTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateAddsPrefix() {
        $role = Role::create('WORKER');

        $this->assertEquals('ROLE_WORKER', $role->getRole());
    }

    public function testCreateAddsPrefixInLowerCase() {
        $role = Role::create('role_worker');

        $this->assertEquals('ROLE_WORKER', $role->getRole());
    }

    public function testCreateTrimsValue() {
        $role = Role::create('_worker_');
        $this->assertEquals('ROLE_WORKER', $role->getRole());
    }

    public function possibleValuesForRolesConstructor()
    {
        return [
            ['worker'],
            ['_worker'],
            ['ROLE_WORKER'],
            ['ROLE_ROLE_WORKER'],
            ['WORKER'],
            ['_WORKER_'],
        ];
    }

    /**
     * @dataProvider possibleValuesForRolesConstructor
     */
    public function testSetterDoesSameThingAsCreator($value) {
        $firstRole = new Role();
        $firstRole->setRole($value);

        $secondRole = Role::create($value);

        $this->assertEquals($firstRole->getRole(), $secondRole->getRole());
    }
}