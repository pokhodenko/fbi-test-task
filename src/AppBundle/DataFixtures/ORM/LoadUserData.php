<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBI\UserBundle\Entity\Role;
use FBI\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;


class LoadUserData implements FixtureInterface, ContainerAwareInterface {

    use ContainerAwareTrait;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $role = Role::create('user');

        $user = new User();

        $user->addRole($role);

        $user->setUsername('admin');
        $user->setFirstName('Dima');
        $user->setLastName('Pokhodenko');
        $user->setEmail('pohod.d@gmail.com');
        $user->setLastLoginAt(new \DateTime());

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'test');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

}