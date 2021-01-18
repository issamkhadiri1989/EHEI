<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as Security;

class ChangePassword
{
    /**
     * @var string
     * @Security\UserPassword(message="The old password is not correct")
     */
    private $oldPassword;
    /**
     * @var string
     * @Assert\Length(
     *     min="6",
     *     minMessage="Please provide a password with at leat {{ limit }} chars."
     * )
     */
    private $newPassword;

    /**
     * @var string
     * @Assert\EqualTo(
     *     propertyPath="newPassword",
     *     message="The password does not match."
     * )
     */
    private $confirmPassword;

    //<editor-fold desc="Getters and Setters">

    /**
     * @return string
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     */
    public function setOldPassword(?string $oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return string
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     */
    public function setNewPassword(?string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return string
     */
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $confirmPassword
     */
    public function setConfirmPassword(string $confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    //</editor-fold>
}