<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\CheckDuplicateMail;
use PHPUnit\Framework\TestCase;

class CheckDuplicateMailTest extends TestCase
{
    public function testIcanDetectDuplicateMails()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->any())
            ->method('getSimpleResultFromEmail')
            ->willReturn([['1']]);

        $checkDuplicateMail = new CheckDuplicateMail($userRepository);

        $this->assertTrue($checkDuplicateMail->check("test@gmail.com"));

    }

    public function testIcannotDetectDuplicateMailsIfNotPresents()
    {
        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->expects($this->any())
            ->method('getSimpleResultFromEmail')
            ->willReturn([]);

        $checkDuplicateMail = new CheckDuplicateMail($userRepository);

        $this->assertFalse($checkDuplicateMail->check("test@gmail.com"));
    }
}