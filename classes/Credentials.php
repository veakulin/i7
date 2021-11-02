<?php

class Credentials {
    public string $login;
    public string $password;
    
    function __construct(string $login = "", string $password = "") {
        $this->login = $login;
        $this->password = $password;
    }
}
