<?php
require_once '../classes.php';

$vrClient = new VRClient(Config::$apiUrl, new Credentials(Config::$apiLogin, Config::$apiPassword));

$isPost = $_SERVER["REQUEST_METHOD"] === 'POST';

if ($isPost) {
    $formState = new DNSFormState();
    $formState->fill($_POST);
    $domain = $vrClient->domainEnum(["filter" => ["&", ["name", "=", $formState->domain], ["isDeleted", "=", false]]]);
    $clientId = $domain[0]->clientId;
    $domainId = $domain[0]->id; 
    $vrClient->domainUpdate(["id" => $domainId, "clientId" => $clientId, "domain" => ["delegated" => true, "nservers" => preg_split('/\s+/', $formState->nservers, -1, PREG_SPLIT_NO_EMPTY)]]);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Изменение домена</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="core.css">
    </head>
    <body class="h-100 d-flex justify-content-center">
        <form method="POST">
            
            <fieldset class="form-group">
                <legend>Домен</legend>
                
                <label>Имя:</label>
                <input type="text" class="form-control" id="domain" name="domain" value="domen-domenovich-domenov.ru" required />
                
                <label for="nservers">DNS-серверы</label>
                <input type="text" class="form-control" id="nservers" name="nservers" value="ns1.ru ns2.ru" required />
            </fieldset>

            <button type="submit" class="btn btn-primary my-3">Изменить</button>
            
        </form>
    </body>

    <?php
    $vrClient->logout();
    ?>
</html>
