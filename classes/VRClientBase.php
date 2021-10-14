<?php

// Низкоуровневая часть клиента
// Разделил клиента на две части просто чтобы не писать один большой класс
class VRClientBase {

    private ?string $token;
    private string $apiUrl;

    public function __construct(string $apiUrl) {
        $this->token = null;
        $this->apiUrl = $apiUrl;
    }

    // Вход
    public function login(string $login, string $password) {
        $jsonRPC = $this->blankJsonRPC("authLogin");
        $jsonRPC["params"]["login"] = $login;
        $jsonRPC["params"]["password"] = $password;
        $result = $this->exec($jsonRPC);
        $this->token = $result->result->token;
    }

    // Выход
    public function logout() {
        if (!is_null($this->token)) {
            $jsonRPC = $this->blankJsonRPC("authLogout");
            $jsonRPC["params"] = ["auth" => ["token" => $this->token]];
            $this->exec($jsonRPC);
            $this->token = null;
        }
    }

    // Запускалка Enum-методов API.
    // У всех них одинаковый набор параметров и выполняются синхронно
    protected function enum(string $method, ?array $query) {
        $jsonRPC = $this->authenticatedJsonRPC($method);
        $jsonRPC["params"]["query"] = $query;
        $result = $this->exec($jsonRPC);
        return $result;
    }

    // Запускалка асинхронных методов с ожиданием завершения
    protected function synchronized(string $method, ?array $params) {
        $jsonRPC = $this->authenticatedJsonRPC($method);
        $jsonRPC["params"] = array_merge($jsonRPC["params"], $params);
        $result = $this->exec($jsonRPC);
        $this->wait($result->result->handle);
        return $result;
    }

    // Ожидает завершения асинхронной операции
    private function wait(string $handle) {
        $jsonRPC = $this->authenticatedJsonRPC("taskStatus");
        $jsonRPC["params"]["handle"] = $handle;
        while (true) {
            $result = $this->exec($jsonRPC);
            switch ($result->result->status) {
                case "success":
                    break 2;
                case "active":
                case "unknown": // Как-бы здесь не зависнуть навсегда, надо уточнить насчет unknown.
                    continue 2;
                case "failed":
                case "cancelled":
                    throw new VRAPIException("Асинхронная операция завершилась ошибкой или была отменена.");
            }
        }
    }

    // Отправляет запрос на сервер
    // Получим либо результат, либо исключение
    private function exec(mixed $jsonRPC) {
        $request = ["http" => ["method" => "POST", "header" => "Content-Type: application/json", "content" => json_encode($jsonRPC)]];
        $context = stream_context_create($request);
        $response = json_decode(json: file_get_contents($this->apiUrl, false, $context), associative: false);

        // Если всё в порядке и есть результат, то возвращаем.
        if (property_exists($response, "result")) {
            return $response;
        }

        // А иначе выбрасываем исключение
        $message = "Случилось что-то непонятное.";

        if (property_exists($response, "error")) {
            $message = $response->error->message; // Возможно API сообщил что-то полезное
        }

        throw new VRAPIException($message);
    }

    // Подготавливает заготовку JSON-RPC с токеном 
    private function authenticatedJsonRPC(string $method, string $id = "1", string $version = "2.0") {
        $jsonRPC = $this->blankJsonRPC($method, $id, $version);
        $jsonRPC["params"]["auth"] = ["token" => $this->token];
        return $jsonRPC;
    }

    // Подготавливает заготовку JSON-RPC 
    private function blankJsonRPC(string $method, string $id = "1", string $version = "2.0") {
        return ["jsonrpc" => $version, "method" => $method, "params" => [], "id" => $id];
    }

}
