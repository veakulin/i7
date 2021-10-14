<?php
require_once '../classes.php';

$vrClient = new VRClient(Config::$apiUrl);
$vrClient->login(Config::$apiLogin, Config::$apiPassword);

$isPost = $_SERVER["REQUEST_METHOD"] === 'POST';

if ($isPost) {
    $formState = new RegFormState();
    $formState->fill($_POST);
    $clientId = $vrClient->clientCreate($formState->translateClient());
    $domain = $formState->translateDomain();
    $domain["clientId"] = $clientId;
    $vrClient->domainCreate($domain);
}

$countries = $vrClient->countryEnum(["length" => Config::$maxLength]);
$regions = $vrClient->regionEnum(["length" => Config::$maxLength]);
$identTypes = $vrClient->identTypeEnum(["length" => Config::$maxLength]);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Регистрация домена</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="core.css">
    </head>
    <body class="h-100 d-flex justify-content-center">
        <form method="POST">
            <fieldset class="form-group">
                <legend>Домен</legend>
                <label>Имя:</label>
                <input type="text" class="form-control" id="domain" name="domain" value="domen-domenovich-domenov.ru" required />
            </fieldset>
            <br />

            <fieldset class="form-group">
                <legend>Клиент</legend>

                <label for="nameLocal">Фамилия Имя Отчество:</label>
                <input type="text" class="form-control" id="nameLocal" name="nameLocal" value="ПОЖИРАТЕЛЬ ДОМЕНОВ" required />

                <label for="birthday">Дата рождения:</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="1970-01-01" required />

                <label for="email">E-Mail:</label>
                <input type="email" class="form-control" id="email" name="email" value="x@y.z" required />

                <label for="phone">Телефон:</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="+7 (555) 555-55-55" required />

                <label for="indexLocal">Почтовый индекс:</label>
                <input type="text" class="form-control" id="indexLocal" name="indexLocal" value="122334" required />

                <label for="countryLocal">Cтрана:</label>
                <select class="form-select" id="countryLocal" name="countryLocal" required>
                    <?php
                    foreach ($countries as $country) {
                        ?>
                        <option value=<?= $country->id ?>><?= $country->name ?></option>
                        <?php
                    }
                    ?>
                </select>

                <label for="regionLocal">Регион:</label>
                <select class="form-select" id="regionLocal" name="regionLocal" required>
                    <?php
                    foreach ($regions as $region) {
                        ?>
                        <option value=<?= $region->id ?>><?= $region->name ?></option>
                        <?php
                    }
                    ?>
                </select>

                <label for="cityLocal">Населенный пункт:</label>
                <input type="text" class="form-control" id="cityLocal" name="cityLocal" value="Цветочный город" required />

                <label for="streetLocal">Улица, дом, квартира, офис:</label>
                <input type="text" class="form-control" id="streetLocal" name="streetLocal" value="Улица Колокольчиков" required />
 
                <label for="identType">Удостоверение личности:</label>
                <select class="form-select" id="identType" name="identType" required>
                    <?php
                    foreach ($identTypes as $identType) {
                        ?>
                        <option value=<?= $identType->id ?>><?= $identType->name ?></option>
                        <?php
                    }
                    ?>
                </select>

                <label for="identCountry">Страна выдачи удостоверения личности:</label>
                <select class="form-select" id="identCountry" name="identCountry" required>
                    <?php
                    foreach ($countries as $country) {
                        ?>
                        <option value=<?= $country->id ?>><?= $country->name ?></option>
                        <?php
                    }
                    ?>
                </select>                
                
                <label for="identSeries">Серия:</label>
                <input type="text" class="form-control" id="identSeries" name="identSeries" value="5555" required />
                
                <label for="identNumber">Номер:</label>
                <input type="text" class="form-control" id="identNumber" name="identNumber" value="555555" required />

                <label for="identIssuer">Кем выдано:</label>
                <input type="text" class="form-control" id="identIssuer" name="identIssuer" value="Властями" required />

                <label for="identIssued">Когда выдано:</label>
                <input type="date" class="form-control" id="identIssued" name="identIssued" value="1970-01-01" required />
            </fieldset>

            <button type="submit" class="btn btn-primary my-3">Подать заявку</button>
            
        </form>
    </body>

    <?php
    $vrClient->logout();
    ?>
</html>
