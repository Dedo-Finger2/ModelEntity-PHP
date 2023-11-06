<?php

namespace app\entity;

class UserEntity extends Entity
{

    /**
     * Método especial dessa entidade, verifica se o email é válido ou não
     *
     * @return void
     */
    public function emailIsValid()
    {
        if (!isset($this->attributes["email"])) {
            throw new \Exception("Email field is invalid.");
        }

        return filter_var($this->attributes["email"], FILTER_VALIDATE_EMAIL);
    }


    /**
     * Método especial dessa entidade, encripta a senha antes de lançar no banco
     *
     * @param string $password - Senha que será encriptada
     * @return void
     */
    public function setPasswordHash(string $password)
    {
        $this->attributes["password"] = password_hash($password, PASSWORD_DEFAULT);
    }
}
