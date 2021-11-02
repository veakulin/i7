<?php

class Credentials {
    public $login;
    public $password;
    
    function __construct(string $login = "", string $password = "") {
        $this->login = $login;
        $this->password = $password;
    }
}
