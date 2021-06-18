<?php declare(strict_types = 1);

namespace ArrobaIt\MoConnectApi;

use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * Zugriffs-URL MonKey Office Connect
     */
    private const MO_API_URL = 'http://127.0.0.1:8084/monkeyOfficeConnectJSON';

    protected \GuzzleHttp\Client $client;

    protected string $moApiFirma;

    public function __construct(string $username, string $password, string $company = '', HandlerStack $handler = null, $options = [])
    {
        $headers['Content-Type'] = 'application/x-www-form-urlencoded';

        if ($company !== '') {
            $headers['mbl-ident'] = $company;
        }

        $config = [
            'base_uri' => self::MO_API_URL,
            'verify' => false,
            'allow_redirects' => true,
            'auth' => [
                $username,
                $password
            ],
            'headers' => $headers,
        ];

        $config = array_merge_recursive($config, $options);

        if ($handler instanceof HandlerStack) {
            $config['handler'] = $handler;
        }

        $this->client = new \GuzzleHttp\Client($config);
    }

    public static function fromCredentials(array $credentials): self
    {
        return new self($credentials['username'], $credentials['password'], $credentials['company']);
    }

    public function setCompany(string $company): void
    {
        $this->moApiFirma = $company;
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

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function send(array $request): object
    {
        $response = $this->client->post(self::MO_API_URL, [
            'debug' => false,
            'body' => json_encode($request, JSON_THROW_ON_ERROR),
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        }
    }
}
