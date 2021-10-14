<?php

class DNSFormState {

    public string $domain;
    public string $nservers;

    public function __construct() {
        
    }

    public function fill(array $post) {
        $this->domain = $post["domain"];
        $this->nservers = $post["nservers"];
    }

    public function translateDomain() {
        $result = [
            "domain" => [
                "name" => $this->domain,
                "nservers" => $this->nservers
            ]
        ];

        return $result;
    }

}
