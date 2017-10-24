<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'email' => 'test@gmail.com',
            'firstName' => 'test',
            'lastName' => 'test'
        );

        $user1 = new User();
        $user1->setEmail('test@gmail.com');
        $user1->setFirstName('test');
        $user1->setLastName('test');

        $form = $this->factory->create(UserType::class);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($user1, $form->getData());
    }
}