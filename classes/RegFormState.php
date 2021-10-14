<?php

// Хелпер для сбора полей с формы.
class RegFormState {

    public string $domain;
    public string $nameLocal;
    public string $birthday;
    public string $email;
    public string $phone;
    public string $indexLocal;
    public string $countryLocal;
    public string $regionLocal;
    public string $cityLocal;
    public string $streetLocal;
    public string $identType;
    public string $identCountry;
    public string $identSeries;
    public string $identNumber;
    public string $identIssuer;
    public string $identIssued;

    public function __construct() {
    }

    // Собираем поля формы
    public function fill(array $post) {
        $this->domain = $post["domain"];
        $this->nameLocal = $post["nameLocal"];
        $this->birthday = $post["birthday"];
        $this->email = $post["email"];
        $this->phone = $post["phone"];
        $this->indexLocal = $post["indexLocal"];
        $this->countryLocal = $post["countryLocal"];
        $this->regionLocal = $post["regionLocal"];
        $this->cityLocal = $post["cityLocal"];
        $this->streetLocal = $post["streetLocal"];
        $this->identType = $post["identType"];
        $this->identCountry = $post["identCountry"];
        $this->identSeries = $post["identSeries"];
        $this->identNumber = $post["identNumber"];
        $this->identIssuer = $post["identIssuer"];
        $this->identIssued = $post["identIssued"];
    }

    // Транслирует поля формы в структуру для создания нового клиента
    public function translateClient() {
        $result = [
            "client" => [
                "legal" => "person",
                "nameLocal" => $this->nameLocal,
                "emails" => [
                    $this->email
                ],
                "phones" => [
                    $this->phone
                ],
                "addressLocal" => [
                    "index" => $this->indexLocal,
                    "country" => $this->countryLocal,
                    "region" => $this->regionLocal,
                    "city" => $this->cityLocal,
                    "street" => $this->streetLocal
                ],
                "birthday" => $this->birthday,
                "identity" => [
                    "country" => $this->identCountry,
                    "type" => $this->identType,
                    "series" => $this->identSeries,
                    "number" => $this->identNumber,
                    "issuer" => $this->identIssuer,
                    "issued" => $this->identIssued
                ]
            ]
        ];
        
        return $result;
    }
    
    // Транслирует поля формы в заготовку для создания нового домена
    public function translateDomain() {
        $result = [
            "domain" => [
                "name" => $this->domain
            ]
        ];
        
        return $result;
    }
}
