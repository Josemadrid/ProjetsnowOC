<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordReset
{

    /**
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     * @Assert\Email(
     *      message = "Veuillez entrer un email valide !"
     * )
     * @Assert\Length(
     *      max = 254,
     *      maxMessage = "Votre email ne peut pas contenir plus que {{ limit }} caractères !"
     * )
     */
    private $email;

    /**
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     * @Assert\Length(
     *      min = 6,
     *      max = 50,
     *      minMessage = "Votre mot de passe doit contenir au moins 6 caractères.",
     *      maxMessage = "Votre mot de passe ne peut pas contenir plus que {{ limit }} caractères !"
     * )
     * @Assert\Regex(
     *     pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)^",
     *     match = true,
     *     message = "Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial !"
     * )
     */
    private $newPassword;



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }


}
