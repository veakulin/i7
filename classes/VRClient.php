<?php

class VRClient extends VRClientBase {
    
    public function __construct(string $apiUrl) {
        parent::__construct($apiUrl);
    }    
    
    public function countryEnum(array $query = null) {
        $result = $this->enum("countryEnum", $query);
        return $result->result->countries;
    }

    public function regionEnum(array $query = null) {
        $result = $this->enum("regionEnum", $query);
        return $result->result->regions;
    }
    
    public function identTypeEnum(array $query = null) {
        $result = $this->enum("identTypeEnum", $query);
        return $result->result->identTypes;
    }
    
    public function domainEnum(array $query = null) {
        $result = $this->enum("domainEnum", $query);
        return $result->result->domains;
    }
    
    public function clientCreate(array $client) {
        $result = $this->synchronized("clientCreate", $client);
        return $result->result->id;
    }
    
    public function domainCreate(array $domain) {
        $result = $this->synchronized("domainCreate", $domain);
        return $result->result->id;
    }
    
    public function domainUpdate(array $params) {
        $result = $this->synchronized("domainUpdate", $params);
        return $result->result->id;
    }
}
