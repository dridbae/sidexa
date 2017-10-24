<?php

namespace AppBundle\Service;

use AppBundle\Repository\UserRepository;

class CheckDuplicateMail
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * CheckDuplicateMail constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $mail
     * @return bool
     */
    public function check(string $mail): bool
    {
        return !!$this->userRepository->getSimpleResultFromEmail($mail);
    }
}
