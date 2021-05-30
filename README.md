# Monkey Office Connect PHP Middleware

## Einleitung

Das Buchhaltungsprogramm "Monkey Office" bietet eine API-Schnittstelle in Form von "Monkey Office Connect" an.
Dahinter verbirgt sich eine "JSON"-API, über die auf die darunterliegende CubeSQL-Datenbank zugegriffen werden kann. Das erfolgt 
jedoch nicht direkt, sondern über eine Middleware. Diese hier ist in PHP geschrieben und orientiert sich an den 
von ProSaldo mitgelieferten PHP-Code. 
Dieser ist [hier](https://github.com/Konafets/mo-connect-php-middleware/blob/develop/moConnectMiddleware.php) zu finden.

Gründe für die Neuimplementierung:

- Testbarkeit
- Verwenung von Composer für die einfache Intergration in externe Projekte
- Kapselung der Datenstrukturen in PHP-Objekte
- Trennung des Clients von den Services, um den Client austauschbarer zu gestalten


## Verwendung

```
$credentials = [
    'username' => '<username>',
    'password' => '<password>',
    'company' => '<ID>',
];

$client = Client::fromCredentials($credentials);
$this->service = new ApiInfoService($client);
```
