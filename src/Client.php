<?php declare(strict_types = 1);

namespace ArrobaIt\MoConnectApi;

class Client
{
    /**
     * Zugriffs-URL MonKey Office Connect
     */
    private const MO_API_URL = 'http://127.0.0.1:8084/monkeyOfficeConnectJSON';

    /**
     * Zugriffs-Login MonKey Office Connect
     */
    private static string $moApiUserName = '';

    /**
     * Zugriffs-Passwort MonKey Office Connect
     */
    private static string $moApiPassword = '';

    /**
     * Selektiere Firma für Zugriffe
     */
    private static $moApiFirma = '';

//    /**
//     * interne Variable für Content als JSON-Objekt
//     */
//    protected $m_json;

    protected static $curlHandle;


    public function __construct(string $username, string $password, string $company = null)
    {
        self::$moApiUserName = $username;
        self::$moApiPassword = $password;
        self::$moApiFirma = $company;

        $this->connectMo();
    }

    public static function fromCredentials(array $credentials): self
    {
        return new self($credentials['username'], $credentials['password'], $credentials['company']);
    }

    public function setCompany(string $company): void
    {
        self::$moApiFirma = $company;
    }

    /**
     * @return string
     * @TODO Refactor!
     */
    public function contentTableDump(): string
    {
        $str = "<table border='1' cellpadding='4' cellspacing='0' bordercolor='#E0E0E0'>";
        $str .= "<tr><th align='left' valign='top' colspan='2'>TableDump</th></tr>";
        $str .= "<tr><th align='left' valign='top'>Key</th><th align='left' valign='top'>Value</th></tr>";
        foreach ($this->m_json as $key => $val) {
            $str .= "<tr><td align='left' valign='top'>" . $key . "</td><td align='left' valign='top'>" . htmlentities(json_encode($val,
                    JSON_UNESCAPED_UNICODE)) . "</td></tr>";
        }
        $str .= "</table>";

        return $str;
    }

    public function hasInsertIdent(): bool
    {
        return ($this->hasStatus()) && isset($this->getContent()->ReturnStatus->Insert_ID);
    }

    public function insertIdent(): string
    {
        if ($this->hasInsertIdent()) {
            return $this->getContent()->ReturnStatus->Insert_ID;
        }

        return "";
    }

    public function getStatusText(): array
    {
        if ($this->hasStatus() && isset($this->getContent()->ReturnStatus->StatustextItem)) {
            return (array) $this->getContent()->ReturnStatus->StatustextItem;
        }

        return [];
    }

    public function getStatusTextDump(): string
    {
        if ($this->hasStatus() && isset($this->getContent()->ReturnStatus->StatustextItem)) {
            // TODO: Refactor
            $texte = $this->getStatusText();
            $str = "<table border='1' cellpadding='4' cellspacing='0' bordercolor='#E0E0E0'>";
            $str .= "<tr><th align='left' valign='top'>StatusDump</th></tr>";
            $str .= "<tr><th align='left' valign='top'>Key</th></tr>";
            foreach ($texte as $txt) {
                $str .= "<tr><td align='left' valign='top'>" . $txt->StatustextItem . "</td></tr>";
            }
            $str .= "</table>";

            return $str;
        }

        return '';
    }

    public function isConnected(): bool
    {
        return isset(self::$curlHandle);
    }

    public function isDisconnected(): bool
    {
        return !isset(self::$curlHandle);
    }

    public function connectMo(): void
    {
        if ($this->isDisconnected()) {
            self::$curlHandle = curl_init();
            curl_setopt(self::$curlHandle, CURLOPT_URL, self::MO_API_URL);
            curl_setopt(self::$curlHandle, CURLOPT_HEADER, false);
            curl_setopt(self::$curlHandle, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt(self::$curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt(self::$curlHandle, CURLOPT_USERPWD, self::$moApiUserName . ":" . self::$moApiPassword);
            curl_setopt(self::$curlHandle, CURLOPT_HTTPAUTH,  CURLAUTH_ANY);
            curl_setopt(self::$curlHandle, CURLOPT_POST, true);
            curl_setopt(self::$curlHandle, CURLOPT_RETURNTRANSFER,  true);
        }
    }

    /**
     * @throws \JsonException
     */
    public function call(array $request)
    {
        if ($this->isDisconnected()) {
            $this->connectMo();
        }

        $requestJson = json_encode($request, JSON_THROW_ON_ERROR);
        if (self::$moApiFirma !== '') {
            curl_setopt(self::$curlHandle, CURLOPT_HTTPHEADER, ['mbl-ident: ' . self::$moApiFirma]);
        }
        curl_setopt(self::$curlHandle, CURLOPT_HTTPHEADER, ['Content-Length: ' . strlen($requestJson)]);
        curl_setopt(self::$curlHandle, CURLOPT_POSTFIELDS, $requestJson);

        $json = curl_exec(self::$curlHandle);
        return json_decode($json, false, 512, JSON_THROW_ON_ERROR);
    }

    public function disconnectMo(): void
    {
        if (isset(self::$curlHandle)) {
            curl_close(self::$curlHandle);
            self::$curlHandle = null;
        }
    }

    protected static function decodeParameter($in)
    {
        if ($in instanceof Client) {
            $return = json_encode($in->getContent());
        } elseif ($in === '') {
            $return = '""';
        } else {
            $return = $in;
        }

        return $return;
    }
}
