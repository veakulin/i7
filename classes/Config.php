<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of DefaultConfig
 *
 * @author v
 */
class Config {
    public static string $apiUrl = "https://vrdemo.virtreg.ru/vr-api";
    public static string $apiLogin = "demo";
    public static string $apiPassword = "demo";
    public static int $maxLength = 2147483647;
    
    private function __construct() {        
    }
}
