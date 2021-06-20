<?php

/**
 * Basisklasse für alle API-Handler
 * Version: 18.1.0
 * API-Schema:  91
 * erstellt:    28.05.21
 */

/**
 *Zugriffs-URL MonKey Office Connect
 */
$moapi_url = 'http://127.0.0.1:8084/monkeyOfficeConnectJSON';
/**
 * Zugriffs-Login MonKey Office Connect
 */
$moapi_login = '';
/**
 * Zugriffs-Passwort MonKey Office Connect
 */
$moapi_pass = '';
/**
 * Selektiere Firma für Zugriffe
 */
$moapi_firma = '';


/**
 * abstrakte Basisklasse aller API-Module
 * benötigt php-Modul Curl
 * kapselt Kommunikation mit MonKey Office Connect
 * besitzt einfache Dump-Funktionen für Debug
 */
class moAPIHandlerBase
{
    /**
     * Interne Variable für Content als JSON-Objekt
     */
    protected $m_json;

    /**
     * @param $json Content des Objektes
     */
    public function __construct($json)
    {
        $this->m_json = $json;
    }

    /**
     * Liefert true wenn Content gesetzt ist
     *
     * @return bool
     */
    public function HasContent()
    {
        return isset($this->m_json);
    }

    /**
     * Liefert Content-Datenstruktur
     */
    public function GetContent()
    {
        return $this->m_json;
    }

    /**
     * Gibt Content als HTML-Tabelle aus, für Debug
     *
     * @return string
     */
    public function ContentTableDump()
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

    /**
     * Liefert true wenn InsertIdent bekannt ist
     *
     * @return bool
     */
    public function HasInsertIdent()
    {
        return ($this->HasStatus() && isset($this->GetContent()->ReturnStatus->Insert_ID));
    }

    /**
     * Liefert InsertIdent
     *
     * @return string
     */
    public function InsertIdent()
    {
        if ($this->HasInsertIdent()) {
            return $this->GetContent()->ReturnStatus->Insert_ID;
        }

        return '';
    }

    /**
     * Liefert true wenn Status gesetzt ist
     *
     * @return bool
     */
    public function HasStatus()
    {
        return ($this->HasContent() && isset($this->GetContent()->ReturnStatus));
    }

    /**
     * Liefert Statustext als String-Array
     *
     * @return mixed
     */
    public function StatusText()
    {
        if ($this->HasStatus() && isset($this->GetContent()->ReturnStatus->StatustextItem)) {
            $str = $this->GetContent()->ReturnStatus->StatustextItem;

            return (array)$str;
        }

        return '';
    }

    /**
     * Gibt StatusText als HTML-Tabelle aus, für Debug
     *
     * @return string
     */
    public function StatusTextDump()
    {
        if ($this->HasStatus() && isset($this->GetContent()->ReturnStatus->StatustextItem)) {
            $texte = $this->StatusText();
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
     * Gibt StatusCode zurück
     *
     * @return string
     */
    public function StatusCode()
    {
        if ($this->HasStatus()) {
            return $this->GetContent()->ReturnStatus->Statuscode;
        }

        return '';
    }

    /**
     * Liefert true wenn StatusCode vorhanden ist und StatusCode OK ist
     *
     * @return bool
     */
    public function StatusOk()
    {
        return ($this->HasStatus() && (int)$this->StatusCode() === 0);
    }

    /**
     * Hält geöffnetes curl-Handle
     * Wird von ConnectMO() gesetzt
     * Gilt bis Aufruf DisConnectMO() bzw Scriptende
     */
    protected static $ch;

    /**
     * Führt einen Zugriff auf MonKey Office Connect aus
     *
     * @param string $query_json JSON-Datenstruktur für Anfrage
     * @return string Antwort als JSON-Objekt
     */
    protected static function ConnectMO($query_json)
    {
        global $moapi_url;
        global $moapi_login;
        global $moapi_pass;
        global $moapi_firma;

        if (!isset(self::$ch)) {
            self::$ch = curl_init();
            curl_setopt(self::$ch, CURLOPT_URL, $moapi_url);
            curl_setopt(self::$ch, CURLOPT_HEADER, false);
            curl_setopt(self::$ch, CURLOPT_VERBOSE, true);
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(self::$ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt(self::$ch, CURLOPT_HTTPHEADER, ['Content-Length: ' . strlen($query_json)]);
            curl_setopt(self::$ch, CURLOPT_USERPWD, $moapi_login . ":" . $moapi_pass);
            curl_setopt(self::$ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt(self::$ch, CURLOPT_POST, true);
        } else {
            curl_setopt(self::$ch, CURLOPT_HTTPHEADER, ['Content-Length: ' . strlen($query_json)]);
        }

        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $query_json);

        if ($moapi_firma !== '') {
            curl_setopt(self::$ch, CURLOPT_HTTPHEADER, ['mbl-ident: ' . $moapi_firma]);
        }
        $json = curl_exec(self::$ch);

        return json_decode($json);
    }

    /**
     * Schliesst offene Verbindung
     */
    public static function DisConnectMO()
    {
        if (isset(self::$ch)) {
            curl_close(self::$ch);
            self::$ch = null;
        }
    }

    /**
     * Konvertierte Variable $in für Zugriffsfunktionen
     *
     * @param mixed $in Zu konvertierende Variable
     * @return string
     */
    protected static function DecodeParameter($in)
    {
        if ($in instanceof moAPIHandlerBase) {
            $ret = json_encode($in->GetContent());
        } elseif ($in === '') {
            $ret = '';
        } else {
            $ret = $in;
        }

        return $ret;
    }
}

?>

<?php

/**
 * Zugriffsmodul für Firmen
 */
class moAPIfirmen extends moAPIHandlerBase
{

    /**
     * firmaList -- Listet verfügbare Firmen
     *
     * @return moAPIfirmen , (GetContent() liefert Array vom Datentyp FirmaListItem)
     */
    public static function firmaList()
    {
        $json_content = self::connectMO('{"firmaList":""}');

        return new moAPIfirmen($json_content->firmaListResponse->ReturnData);
    }

    /**
     * firmaGet -- Infos zur aktuell selektierten Firma
     *
     * @return moAPIfirmen , ($ret->GetContent() liefert Datentyp FirmaItem)
     */
    public static function firmaGet()
    {
        $json_content = self::connectMO('{"firmaGet":""}');

        return new moAPIfirmen($json_content->firmaGetResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Vorgaben
 */
class moAPIvorgaben extends moAPIHandlerBase
{

    /**
     * kostenstellenList -- Liefert definierte Kostenstellen
     *
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp KostenstelleListItem)
     */
    public static function kostenstellenList()
    {
        $json_content = self::connectMO('{"kostenstellenList":""}');

        return new moAPIvorgaben($json_content->kostenstellenListResponse->ReturnData);
    }

    /**
     * nummernkreisList -- Liefert definierte Nummerkreise
     *
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp NummernkreisListItem)
     */
    public static function nummernkreisList()
    {
        $json_content = self::connectMO('{"nummernkreisList":""}');

        return new moAPIvorgaben($json_content->nummernkreisListResponse->ReturnData);
    }

    /**
     * steuersatzList -- Liefert definierte Steuersätze
     *
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp SteuersatzListItem)
     */
    public static function steuersatzList()
    {
        $json_content = self::connectMO('{"steuersatzList":""}');

        return new moAPIvorgaben($json_content->steuersatzListResponse->ReturnData);
    }

    /**
     * waehrungList -- Liefert definierte Währungen
     *
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp WaehrungListItem)
     */
    public static function waehrungList()
    {
        $json_content = self::connectMO('{"waehrungList":""}');

        return new moAPIvorgaben($json_content->waehrungListResponse->ReturnData);
    }

    /**
     * preislisteVerkaufList -- Liefert definierte VK-Preisliste
     *
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp VerkaufpreislisteListItem)
     */
    public static function preislisteVerkaufList()
    {
        $json_content = self::connectMO('{"preislisteVerkaufList":""}');

        return new moAPIvorgaben($json_content->preislisteVerkaufListResponse->ReturnData);
    }

    /**
     * zahlungsbedingungEinkaufList -- Liefert definierte Zahlungsbedingungen Einkauf
     *
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp ZahlungsBedingungEinkaufListItem)
     */
    public static function zahlungsbedingungEinkaufList()
    {
        $json_content = self::connectMO('{"zahlungsbedingungEinkaufList":""}');
        $ret = new moAPIvorgaben($json_content->zahlungsbedingungEinkaufListResponse->ReturnData);

        return $ret;
    }

    /**
     * zahlungsbedingungVerkaufList -- Liefert definierte Zahlungsbedingungen Verkauf
     *
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp ZahlungsBedingungVerkaufListItem)
     */
    public static function zahlungsbedingungVerkaufList()
    {
        $json_content = self::connectMO('{"zahlungsbedingungVerkaufList":""}');

        return new moAPIvorgaben($json_content->zahlungsbedingungVerkaufListResponse->ReturnData);
    }

    /**
     * druckformularFilterTemplate -- Liefert Filter für Druckformulare
     *
     * @return moAPIvorgaben , ($ret->GetContent() liefert Datentyp DruckFormularFilter)
     */
    public static function druckformularFilterTemplate()
    {
        $json_content = self::connectMO('{"druckformularFilterTemplate":""}');

        return new moAPIvorgaben($json_content->druckformularFilterTemplateResponse->ReturnData);
    }

    /**
     * druckformularList -- Liefert definierte Druckformulare
     *
     * @param moAPIvorgaben $DruckFormularFilter
     * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp DruckFormularListItem)
     */
    public static function druckformularList($DruckFormularFilter)
    {
        $json_content = self::connectMO('{"druckformularList":' . self::decodeParameter($DruckFormularFilter) . '}');

        return new moAPIvorgaben($json_content->druckformularListResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Adressen
 */
class moAPIadressen extends moAPIHandlerBase
{

    /**
     * adresseFilterTemplate -- Vorlage für Adressen-Filter
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AdresseFilter)
     */
    public static function adresseFilterTemplate()
    {
        $json_content = self::connectMO('{"adresseFilterTemplate":""}');

        return new moAPIadressen($json_content->adresseFilterTemplateResponse->ReturnData);
    }

    /**
     * adresseList -- liefert alle Adressen als Liste
     *
     * @param moAPIadressen $AdresseFilter (Datenstruktur)
     *
     * @return moAPIadressen , (GetContent() liefert Array vom Datentyp AdresseListItem)
     */
    public static function adresseList($AdresseFilter)
    {
        $json_content = self::connectMO('{"adresseList":' . self::decodeParameter($AdresseFilter) . '}');

        return new moAPIadressen($json_content->adresseListResponse->ReturnData);
    }

    /**
     * adresseGet -- liefert Details einer Adresse
     *
     * @param string $Adresse_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AdresseItem)
     */
    public static function adresseGet($Adresse_ID)
    {
        $json_content = self::connectMO('{"adresseGet":{"Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIadressen($json_content->adresseGetResponse->ReturnData);
    }

    /**
     * adresseAdd -- fügt eine Adresse hinzu
     *
     * @param mixed $AdresseAddItem (Datenstruktur)
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseAdd($AdresseAddItem)
    {
        $json_content = self::connectMO('{"adresseAdd":' . self::decodeParameter($AdresseAddItem) . '}');

        return new moAPIadressen($json_content->adresseAddResponse->ReturnData);
    }

    /**
     * adresseModify -- modifiziert vorhandene Adresse
     *
     * @param mixed $AdresseItem (Datenstruktur)
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseModify($AdresseItem)
    {
        $json_content = self::connectMO('{"adresseModify":' . self::decodeParameter($AdresseItem) . '}');

        return new moAPIadressen($json_content->adresseModifyResponse->ReturnData);
    }

    /**
     * adresseDelete -- löscht vorhandene Adresse
     *
     * @param string $Adresse_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseDelete($Adresse_ID)
    {
        $json_content = self::connectMO('{"adresseDelete":{"Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIadressen($json_content->adresseDeleteResponse->ReturnData);
    }

    /**
     * adresseTemplate -- liefert AdresseAddItem als Vorlage
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AdresseAddItem)
     */
    public static function adresseTemplate()
    {
        $json_content = self::connectMO('{"adresseTemplate":""}');

        return new moAPIadressen($json_content->adresseTemplateResponse->ReturnData);
    }

    /**
     * adresseKategorieList -- ermittelt alle Adress-Kategorien
     *
     * @return moAPIadressen , (GetContent() liefert Array vom Datentyp AdresseKategorieItem)
     */
    public static function adresseKategorieList()
    {
        $json_content = self::connectMO('{"adresseKategorieList":""}');

        return new moAPIadressen($json_content->adresseKategorieListResponse->ReturnData);
    }

    /**
     * adresseAddAttachment -- fügt ein Attachment einer Adresse hinzu
     *
     * @param string $Adresse_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseAddAttachment($Adresse_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"adresseAddAttachment":{"Adresse_ID":"' . $Adresse_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');

        return new moAPIadressen($json_content->adresseAddAttachmentResponse->ReturnData);
    }

    /**
     * adresseAnsprechpartnerTemplate -- liefert AnsprechpartnerAddItem als Vorlage
     *
     * @param string $Adresse_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AnsprechpartnerAddItem)
     */
    public static function adresseAnsprechpartnerTemplate($Adresse_ID)
    {
        $json_content = self::connectMO('{"adresseAnsprechpartnerTemplate":{"Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIadressen($json_content->adresseAnsprechpartnerTemplateResponse->ReturnData);
    }

    /**
     * adresseAnsprechpartnerList -- liefert alle Ansprechpartner einer Adresse
     *
     * @param string $Adresse_ID
     *
     * @return moAPIadressen , (GetContent() liefert Array vom Datentyp AnsprechpartnerListItem)
     */
    public static function adresseAnsprechpartnerList($Adresse_ID)
    {
        $json_content = self::connectMO('{"adresseAnsprechpartnerList":{"Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIadressen($json_content->adresseAnsprechpartnerListResponse->ReturnData);
    }

    /**
     * adresseAnsprechpartnerAdd -- fügt Ansprechpartner zu Adresse hinzu
     *
     * @param mixed $AnsprechpartnerAddItem (Datenstruktur)
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseAnsprechpartnerAdd($AnsprechpartnerAddItem)
    {
        $json_content = self::connectMO('{"adresseAnsprechpartnerAdd":' . self::decodeParameter($AnsprechpartnerAddItem) . '}');

        return new moAPIadressen($json_content->adresseAnsprechpartnerAddResponse->ReturnData);
    }

    /**
     * adresseAnsprechpartnerGet -- liefert Details eines einzelnen Ansprechpartner
     *
     * @param string $Ansprechpartner_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AnsprechpartnerItem)
     */
    public static function adresseAnsprechpartnerGet($Ansprechpartner_ID)
    {
        $json_content = self::connectMO('{"adresseAnsprechpartnerGet":{"Ansprechpartner_ID":"' . $Ansprechpartner_ID . '"}}');

        return new moAPIadressen($json_content->adresseAnsprechpartnerGetResponse->ReturnData);
    }

    /**
     * adresseAnsprechpartnerModify -- modifiziert vorhandenen Ansprechpartner
     *
     * @param mixed $AnsprechpartnerItem (Datenstruktur)
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseAnsprechpartnerModify($AnsprechpartnerItem)
    {
        $json_content = self::connectMO('{"adresseAnsprechpartnerModify":' . self::decodeParameter($AnsprechpartnerItem) . '}');

        return new moAPIadressen($json_content->adresseAnsprechpartnerModifyResponse->ReturnData);
    }

    /**
     * adresseAnsprechpartnerDelete -- löscht eine Ansprechpartner
     *
     * @param string $Ansprechpartner_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseAnsprechpartnerDelete($Ansprechpartner_ID)
    {
        $json_content = self::connectMO('{"adresseAnsprechpartnerDelete":{"Ansprechpartner_ID":"' . $Ansprechpartner_ID . '"}}');

        return new moAPIadressen($json_content->adresseAnsprechpartnerDeleteResponse->ReturnData);
    }

    /**
     * adresseSepaMandatList -- Auflistung angelegter SEPA-Mandate für Adresse
     *
     * @param string $Adresse_ID
     *
     * @return moAPIadressen , (GetContent() liefert Array vom Datentyp SepaMandatListItem)
     */
    public static function adresseSepaMandatList($Adresse_ID)
    {
        $json_content = self::connectMO('{"adresseSepaMandatList":{"Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIadressen($json_content->adresseSepaMandatListResponse->ReturnData);
    }

    /**
     * adresseSepaMandatTemplate -- Vorlage für neues SEPA-Mandat
     *
     * @param string $Adresse_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp SepaMandatAddItem)
     */
    public static function adresseSepaMandatTemplate($Adresse_ID)
    {
        $json_content = self::connectMO('{"adresseSepaMandatTemplate":{"Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIadressen($json_content->adresseSepaMandatTemplateResponse->ReturnData);
    }

    /**
     * adresseSepaMandatAdd -- Anlegen eines SEPA-Mandat für Adresse
     *
     * @param mixed $SepaMandatAddItem (Datenstruktur)
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseSepaMandatAdd($SepaMandatAddItem)
    {
        $json_content = self::connectMO('{"adresseSepaMandatAdd":' . self::decodeParameter($SepaMandatAddItem) . '}');

        return new moAPIadressen($json_content->adresseSepaMandatAddResponse->ReturnData);
    }

    /**
     * adresseSepaMandatGet -- liefert Details eines vorhandenen SEPA-Mandat
     *
     * @param string $SepaMandat_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp SepaMandatItem)
     */
    public static function adresseSepaMandatGet($SepaMandat_ID)
    {
        $json_content = self::connectMO('{"adresseSepaMandatGet":{"SepaMandat_ID":"' . $SepaMandat_ID . '"}}');

        return new moAPIadressen($json_content->adresseSepaMandatGetResponse->ReturnData);
    }

    /**
     * adresseSepaMandatModify -- modifiziert vorhandenes SEPA-Mandat
     *
     * @param mixed $SepaMandatItem (Datenstruktur)
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseSepaMandatModify($SepaMandatItem)
    {
        $json_content = self::connectMO('{"adresseSepaMandatModify":' . self::decodeParameter($SepaMandatItem) . '}');

        return new moAPIadressen($json_content->adresseSepaMandatModifyResponse->ReturnData);
    }

    /**
     * adresseSepaMandatDelete -- löscht vorhandenes SEPA-Mandat
     *
     * @param string $SepaMandat_ID
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function adresseSepaMandatDelete($SepaMandat_ID)
    {
        $json_content = self::connectMO('{"adresseSepaMandatDelete":{"SepaMandat_ID":"' . $SepaMandat_ID . '"}}');

        return new moAPIadressen($json_content->adresseSepaMandatDeleteResponse->ReturnData);
    }

    /**
     * adresseSepaMandatPrintPDF -- gibt SEPA-Mandat als PDF aus
     *
     * @param string $SepaMandat_ID
     * @param mixed $DruckformularName
     *
     * @return moAPIadressen , ($ret->GetContent() liefert Datentyp SepaMandatPrintItem)
     */
    public static function adresseSepaMandatPrintPDF($SepaMandat_ID, $DruckformularName)
    {
        $json_content = self::connectMO('{"adresseSepaMandatPrintPDF":{"SepaMandat_ID":"' . $SepaMandat_ID . '", "DruckformularName":"' . $DruckformularName . '"}}');

        return new moAPIadressen($json_content->adresseSepaMandatPrintPDFResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Artikel und Leistungen
 */
class moAPIartikel extends moAPIHandlerBase
{

    /**
     * warengruppeTemplate -- liefert WarengruppeAddItem als Vorlage
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp WarengruppeAddItem)
     */
    public static function warengruppeTemplate()
    {
        $json_content = self::connectMO('{"warengruppeTemplate":""}');

        return new moAPIartikel($json_content->warengruppeTemplateResponse->ReturnData);
    }

    /**
     * warengruppeList -- Auflistung Warengruppen
     *
     * @return moAPIartikel , (GetContent() liefert Array vom Datentyp WarengruppeListItem)
     */
    public static function warengruppeList()
    {
        $json_content = self::connectMO('{"warengruppeList":""}');

        return new moAPIartikel($json_content->warengruppeListResponse->ReturnData);
    }

    /**
     * warengruppeGet -- Liefert Details einer Warengruppe
     *
     * @param string $Warengruppe_ID
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp WarengruppeItem)
     */
    public static function warengruppeGet($Warengruppe_ID)
    {
        $json_content = self::connectMO('{"warengruppeGet":{"Warengruppe_ID":"' . $Warengruppe_ID . '"}}');

        return new moAPIartikel($json_content->warengruppeGetResponse->ReturnData);
    }

    /**
     * warengruppeAdd -- fügt eine Warengruppe hinzu
     *
     * @param mixed $WarengruppeAddItem (Datenstruktur)
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function warengruppeAdd($WarengruppeAddItem)
    {
        $json_content = self::connectMO('{"warengruppeAdd":' . self::decodeParameter($WarengruppeAddItem) . '}');

        return new moAPIartikel($json_content->warengruppeAddResponse->ReturnData);
    }

    /**
     * warengruppeDelete -- löscht eine vorhandene Warengruppe
     *
     * @param string $Warengruppe_ID
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function warengruppeDelete($Warengruppe_ID)
    {
        $json_content = self::connectMO('{"warengruppeDelete":{"Warengruppe_ID":"' . $Warengruppe_ID . '"}}');

        return new moAPIartikel($json_content->warengruppeDeleteResponse->ReturnData);
    }

    /**
     * artikelTemplate -- liefert ArtikelAddltem als Vorlage
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelAddltem)
     */
    public static function artikelTemplate()
    {
        $json_content = self::connectMO('{"artikelTemplate":""}');

        return new moAPIartikel($json_content->artikelTemplateResponse->ReturnData);
    }

    /**
     * artikelList -- Auflistung Artikel
     *
     * @param mixed $ArtikelFilter (Datenstruktur)
     *
     * @return moAPIartikel , (GetContent() liefert Array vom Datentyp ArtikelListItem)
     */
    public static function artikelList($ArtikelFilter)
    {
        $json_content = self::connectMO('{"artikelList":' . self::decodeParameter($ArtikelFilter) . '}');

        return new moAPIartikel($json_content->artikelListResponse->ReturnData);
    }

    /**
     * artikelGet -- Liefert Details eines Artikel/Leistung
     *
     * @param string $Artikel_ID
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelItem)
     */
    public static function artikelGet($Artikel_ID)
    {
        $json_content = self::connectMO('{"artikelGet":{"Artikel_ID":"' . $Artikel_ID . '"}}');

        return new moAPIartikel($json_content->artikelGetResponse->ReturnData);
    }

    /**
     * artikelAdd -- fügt einen Artikel/Leistung hinzu
     *
     * @param mixed $ArtikelAddltem (Datenstruktur)
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function artikelAdd($ArtikelAddltem)
    {
        $json_content = self::connectMO('{"artikelAdd":' . self::decodeParameter($ArtikelAddltem) . '}');

        return new moAPIartikel($json_content->artikelAddResponse->ReturnData);
    }

    /**
     * artikelDelete -- löscht einen vorhandene Artikel/Leistung
     *
     * @param string $Artikel_ID
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function artikelDelete($Artikel_ID)
    {
        $json_content = self::connectMO('{"artikelDelete":{"Artikel_ID":"' . $Artikel_ID . '"}}');

        return new moAPIartikel($json_content->artikelDeleteResponse->ReturnData);
    }

    /**
     * artikelModify -- ändert einen vorhandenen Artikel/Leistung
     *
     * @param mixed $ArtikelItem (Datenstruktur)
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function artikelModify($ArtikelItem)
    {
        $json_content = self::connectMO('{"artikelModify":' . self::decodeParameter($ArtikelItem) . '}');

        return new moAPIartikel($json_content->artikelModifyResponse->ReturnData);
    }

    /**
     * artikelFilterTemplate -- Vorlage für Filter Artikel/Leistungen
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelFilter)
     */
    public static function artikelFilterTemplate()
    {
        $json_content = self::connectMO('{"artikelFilterTemplate":""}');
        $ret = new moAPIartikel($json_content->artikelFilterTemplateResponse->ReturnData);

        return $ret;
    }

    /**
     * artikelAddAttachment -- fügt ein Attachment einem Artikel hinzu
     *
     * @param string $Artikel_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function artikelAddAttachment($Artikel_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"artikelAddAttachment":{"Artikel_ID":"' . $Artikel_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');

        return new moAPIartikel($json_content->artikelAddAttachmentResponse->ReturnData);
    }

    /**
     * artikelBildGet -- Abrufen eines Artikelbildes
     *
     * @param string $Artikel_ID
     * @param mixed $Bildposition
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelBildItem)
     */
    public static function artikelBildGet($Artikel_ID, $Bildposition)
    {
        $json_content = self::connectMO('{"artikelBildGet":{"Artikel_ID":"' . $Artikel_ID . '", "Bildposition":"' . $Bildposition . '"}}');

        return new moAPIartikel($json_content->artikelBildGetResponse->ReturnData);
    }

    /**
     * artikelBildTemplate -- Abrufen einer Datenstruktur ArtikelBildAddlItem
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelBildAddlItem)
     */
    public static function artikelBildTemplate()
    {
        $json_content = self::connectMO('{"artikelBildTemplate":""}');

        return new moAPIartikel($json_content->artikelBildTemplateResponse->ReturnData);
    }

    /**
     * artikelBildAdd -- fügt ein Artikelbild hinzu
     *
     * @param string $Artikel_ID
     * @param mixed $ArtikelBildAddlItem (Datenstruktur)
     *
     * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function artikelBildAdd($Artikel_ID, $ArtikelBildAddlItem)
    {
        $json_content = self::connectMO('{"artikelBildAdd":{"Artikel_ID":"' . $Artikel_ID . '", ' . self::decodeParameter($ArtikelBildAddlItem) . '}}');

        return new moAPIartikel($json_content->artikelBildAddResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Lager
 */
class moAPIlager extends moAPIHandlerBase
{

    /**
     * lagerartikelList -- Listet alle Lagerartikel
     *
     * @return moAPIlager , (GetContent() liefert Array vom Datentyp ArtikelListItem)
     */
    public static function lagerartikelList()
    {
        $json_content = self::connectMO('{"lagerartikelList":""}');

        return new moAPIlager($json_content->lagerartikelListResponse->ReturnData);
    }

    /**
     * lagerjournalFilterTemplate -- Vorlage für Lagerjournal-Filter
     *
     * @return moAPIlager , ($ret->GetContent() liefert Datentyp LagerjournalFilter)
     */
    public static function lagerjournalFilterTemplate()
    {
        $json_content = self::connectMO('{"lagerjournalFilterTemplate":""}');

        return new moAPIlager($json_content->lagerjournalFilterTemplateResponse->ReturnData);
    }

    /**
     * lagerjournalList -- Liefert Lagerjournal(mit filter)
     *
     * @param mixed $LagerjournalFilter (Datenstruktur)
     *
     * @return moAPIlager , (GetContent() liefert Array vom Datentyp LagerjournalArtikelItem)
     */
    public static function lagerjournalList($LagerjournalFilter)
    {
        $json_content = self::connectMO('{"lagerjournalList":' . self::decodeParameter($LagerjournalFilter) . '}');

        return new moAPIlager($json_content->lagerjournalListResponse->ReturnData);
    }

    /**
     * lagerjournalGet -- Liefert Lagerjournal für Artikel (mit ID)
     *
     * @param string $Artikel_ID
     * @param mixed $NurLetzeBewegung
     *
     * @return moAPIlager , ($ret->GetContent() liefert Datentyp LagerjournalItem)
     */
    public static function lagerjournalGet($Artikel_ID, $NurLetzeBewegung)
    {
        $json_content = self::connectMO('{"lagerjournalGet":{"Artikel_ID":"' . $Artikel_ID . '", "NurLetzeBewegung":"' . $NurLetzeBewegung . '"}}');

        return new moAPIlager($json_content->lagerjournalGetResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Verkaufsbelege
 */
class moAPIverkauf extends moAPIHandlerBase
{

    /**
     * verkaufbelegFilterTemplate -- Vorlage für Verkaufbeleg-Filter
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegFilter)
     */
    public static function verkaufbelegFilterTemplate()
    {
        $json_content = self::connectMO('{"verkaufbelegFilterTemplate":""}');

        return new moAPIverkauf($json_content->verkaufbelegFilterTemplateResponse->ReturnData);
    }

    /**
     * verkaufbelegList -- Auflistung Verkaufbelege
     *
     * @param mixed $VerkaufbelegFilter (Datenstruktur)
     *
     * @return moAPIverkauf , (GetContent() liefert Array vom Datentyp VerkaufbelegListitem)
     */
    public static function verkaufbelegList($VerkaufbelegFilter)
    {
        $json_content = self::connectMO('{"verkaufbelegList":' . self::decodeParameter($VerkaufbelegFilter) . '}');

        return new moAPIverkauf($json_content->verkaufbelegListResponse->ReturnData);
    }

    /**
     * verkaufbelegGet -- Liefert Details eines Verkaufbeleg
     *
     * @param string $Verkaufbeleg_ID
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegItem)
     */
    public static function verkaufbelegGet($Verkaufbeleg_ID)
    {
        $json_content = self::connectMO('{"verkaufbelegGet":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '"}}');

        return new moAPIverkauf($json_content->verkaufbelegGetResponse->ReturnData);
    }

    /**
     * verkaufbelegTemplate -- liefert VerkaufbelegAddItem als Vorlage
     *
     * @param mixed $VerkaufbelegArt
     * @param mixed $Adresse_ID
     * @param mixed $VKPreisliste_ID
     * @param mixed $ArtikelAddPostenList (Datenstruktur)
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegAddItem)
     */
    public static function verkaufbelegTemplate($VerkaufbelegArt, $Adresse_ID, $VKPreisliste_ID, $ArtikelAddPostenList)
    {
        $json_content = self::connectMO('{"verkaufbelegTemplate":{"VerkaufbelegArt":"' . $VerkaufbelegArt . '", "Adresse_ID":"' . $Adresse_ID . '", "VKPreisliste_ID":"' . $VKPreisliste_ID . '", ' . self::decodeParameter($ArtikelAddPostenList) . '}}');

        return new moAPIverkauf($json_content->verkaufbelegTemplateResponse->ReturnData);
    }

    /**
     * verkaufbelegDuplikatTemplate -- Vorlage für einen duplizierten Verkaufbeleg
     *
     * @param string $Verkaufbeleg_ID
     * @param string $Adresse_ID
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegAddItem)
     */
    public static function verkaufbelegDuplikatTemplate($Verkaufbeleg_ID, $Adresse_ID)
    {
        $json_content = self::connectMO('{"verkaufbelegDuplikatTemplate":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", "Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIverkauf($json_content->verkaufbelegDuplikatTemplateResponse->ReturnData);
    }

    /**
     * verkaufbelegWeiterleitungTemplate -- Vorlage für einen weitergeleiteten Verkaufbeleg
     *
     * @param string $Verkaufbeleg_ID
     * @param string $VerkaufbelegArt
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegAddItem)
     */
    public static function verkaufbelegWeiterleitungTemplate($Verkaufbeleg_ID, $VerkaufbelegArt)
    {
        $json_content = self::connectMO('{"verkaufbelegWeiterleitungTemplate":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", "VerkaufbelegArt":"' . $VerkaufbelegArt . '"}}');

        return new moAPIverkauf($json_content->verkaufbelegWeiterleitungTemplateResponse->ReturnData);
    }

    /**
     * verkaufbelegPositionTemplate -- liefert VerkaufbelegPositionAddItem als Vorlage
     *
     * @param string $Artikel_ID
     * @param string $Adresse_ID
     * @param string $VKPreisliste_ID
     * @param string $Artikelmenge
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegPositionAddItem)
     */
    public static function verkaufbelegPositionTemplate($Artikel_ID, $Adresse_ID, $VKPreisliste_ID, $Artikelmenge)
    {
        $json_content = self::connectMO('{"verkaufbelegPositionTemplate":{"Artikel_ID":"' . $Artikel_ID . '", "Adresse_ID":"' . $Adresse_ID . '", "VKPreisliste_ID":"' . $VKPreisliste_ID . '", "Artikelmenge":"' . $Artikelmenge . '"}}');

        return new moAPIverkauf($json_content->verkaufbelegPositionTemplateResponse->ReturnData);
    }

    /**
     * verkaufbelegPreview -- berechnet einen Verkaufbeleg ohne ihn zu sichern
     *
     * @param mixed $VerkaufbelegAddItem (Datenstruktur)
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegItem)
     */
    public static function verkaufbelegPreview($VerkaufbelegAddItem)
    {
        $json_content = self::connectMO('{"verkaufbelegPreview":' . self::decodeParameter($VerkaufbelegAddItem) . '}');

        return new moAPIverkauf($json_content->verkaufbelegPreviewResponse->ReturnData);
    }

    /**
     * verkaufbelegAdd -- fügt einen neuen Verkaufbeleg hinzu
     *
     * @param mixed $VerkaufbelegAddItem (Datenstruktur)
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function verkaufbelegAdd($VerkaufbelegAddItem)
    {
        $json_content = self::connectMO('{"verkaufbelegAdd":' . self::decodeParameter($VerkaufbelegAddItem) . '}');

        return new moAPIverkauf($json_content->verkaufbelegAddResponse->ReturnData);
    }

    /**
     * verkaufbelegWeiterleitung -- fügt einen Verkaufbeleg als Weiterleitung hinzu
     *
     * @param mixed $VerkaufbelegAddItem (Datenstruktur)
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function verkaufbelegWeiterleitung($VerkaufbelegAddItem)
    {
        $json_content = self::connectMO('{"verkaufbelegWeiterleitung":' . self::decodeParameter($VerkaufbelegAddItem) . '}');

        return new moAPIverkauf($json_content->verkaufbelegWeiterleitungResponse->ReturnData);
    }

    /**
     * verkaufbelegDelete -- löscht einen Verkaufbeleg
     *
     * @param string $Verkaufbeleg_ID
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function verkaufbelegDelete($Verkaufbeleg_ID)
    {
        $json_content = self::connectMO('{"verkaufbelegDelete":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '"}}');

        return new moAPIverkauf($json_content->verkaufbelegDeleteResponse->ReturnData);
    }

    /**
     * verkaufbelegAddAttachment -- fügt ein Attachment einem Verkaufbeleg hinzu
     *
     * @param string $Verkaufbeleg_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function verkaufbelegAddAttachment($Verkaufbeleg_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"verkaufbelegAddAttachment":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');

        return new moAPIverkauf($json_content->verkaufbelegAddAttachmentResponse->ReturnData);
    }

    /**
     * verkaufbelegPrintPDF -- liefert einen Verkaufbeleg als PDF
     *
     * @param string $Verkaufbeleg_ID
     * @param string $DruckformularName
     * @param string $MarkAsPrinted
     *
     * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegPrintItem)
     */
    public static function verkaufbelegPrintPDF($Verkaufbeleg_ID, $DruckformularName, $MarkAsPrinted)
    {
        $json_content = self::connectMO('{"verkaufbelegPrintPDF":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", "DruckformularName":"' . $DruckformularName . '", "MarkAsPrinted":"' . $MarkAsPrinted . '"}}');

        return new moAPIverkauf($json_content->verkaufbelegPrintPDFResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Einkaufsbelege
 */
class moAPIeinkauf extends moAPIHandlerBase
{

    /**
     * einkaufbelegFilterTemplate -- Vorlage für Einkaufbeleg-Filter
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegFilter)
     */
    public static function einkaufbelegFilterTemplate()
    {
        $json_content = self::connectMO('{"einkaufbelegFilterTemplate":""}');

        return new moAPIeinkauf($json_content->einkaufbelegFilterTemplateResponse->ReturnData);
    }

    /**
     * einkaufbelegList -- Auflistung Einkaufbelege
     *
     * @param mixed $EinkaufbelegFilter (Datenstruktur)
     *
     * @return moAPIeinkauf , (GetContent() liefert Array vom Datentyp EinkaufbelegListitem)
     */
    public static function einkaufbelegList($EinkaufbelegFilter)
    {
        $json_content = self::connectMO('{"einkaufbelegList":' . self::decodeParameter($EinkaufbelegFilter) . '}');

        return new moAPIeinkauf($json_content->einkaufbelegListResponse->ReturnData);
    }

    /**
     * einkaufbelegGet -- Liefert Details eines Einkaufbeleg
     *
     * @param string $Einkaufbeleg_ID
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegItem)
     */
    public static function einkaufbelegGet($Einkaufbeleg_ID)
    {
        $json_content = self::connectMO('{"einkaufbelegGet":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '"}}');

        return new moAPIeinkauf($json_content->einkaufbelegGetResponse->ReturnData);
    }

    /**
     * einkaufbelegTemplate -- liefert EinkaufbelegAddItem als Vorlage
     *
     * @param mixed $EinkaufbelegArt
     * @param string $Adresse_ID
     * @param mixed $ArtikelAddPostenList (Datenstruktur)
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegAddItem)
     */
    public static function einkaufbelegTemplate($EinkaufbelegArt, $Adresse_ID, $ArtikelAddPostenList)
    {
        $json_content = self::connectMO('{"einkaufbelegTemplate":{"EinkaufbelegArt":"' . $EinkaufbelegArt . '", "Adresse_ID":"' . $Adresse_ID . '", ' . self::decodeParameter($ArtikelAddPostenList) . '}}');

        return new moAPIeinkauf($json_content->einkaufbelegTemplateResponse->ReturnData);
    }

    /**
     * einkaufbelegDuplikatTemplate -- Vorlage für einen duplizierten Einkaufbeleg
     *
     * @param string $Einkaufbeleg_ID
     * @param string $Adresse_ID
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegAddItem)
     */
    public static function einkaufbelegDuplikatTemplate($Einkaufbeleg_ID, $Adresse_ID)
    {
        $json_content = self::connectMO('{"einkaufbelegDuplikatTemplate":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", "Adresse_ID":"' . $Adresse_ID . '"}}');

        return new moAPIeinkauf($json_content->einkaufbelegDuplikatTemplateResponse->ReturnData);
    }

    /**
     * einkaufbelegWeiterleitungTemplate -- Vorlage für einen weitergeleiteten Einkaufbeleg
     *
     * @param string $Einkaufbeleg_ID
     * @param string $EinkaufbelegArt
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegAddItem)
     */
    public static function einkaufbelegWeiterleitungTemplate($Einkaufbeleg_ID, $EinkaufbelegArt)
    {
        $json_content = self::connectMO('{"einkaufbelegWeiterleitungTemplate":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", "EinkaufbelegArt":"' . $EinkaufbelegArt . '"}}');

        return new moAPIeinkauf($json_content->einkaufbelegWeiterleitungTemplateResponse->ReturnData);
    }

    /**
     * einkaufbelegPositionTemplate -- liefert EinkaufbelegPositionAddItem als Vorlage
     *
     * @param string $Artikel_ID
     * @param string $Adresse_ID
     * @param string $Artikelmenge
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegPositionAddItem)
     */
    public static function einkaufbelegPositionTemplate($Artikel_ID, $Adresse_ID, $Artikelmenge)
    {
        $json_content = self::connectMO('{"einkaufbelegPositionTemplate":{"Artikel_ID":"' . $Artikel_ID . '", "Adresse_ID":"' . $Adresse_ID . '", "Artikelmenge":"' . $Artikelmenge . '"}}');

        return new moAPIeinkauf($json_content->einkaufbelegPositionTemplateResponse->ReturnData);
    }

    /**
     * einkaufbelegPreview -- berechnet einen Einkaufbeleg ohne zu sichern
     *
     * @param mixed $EinkaufbelegAddItem (Datenstruktur)
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegItem)
     */
    public static function einkaufbelegPreview($EinkaufbelegAddItem)
    {
        $json_content = self::connectMO('{"einkaufbelegPreview":' . self::decodeParameter($EinkaufbelegAddItem) . '}');

        return new moAPIeinkauf($json_content->einkaufbelegPreviewResponse->ReturnData);
    }

    /**
     * einkaufbelegAdd -- fügt einen neuen Einkaufbeleg hinzu
     *
     * @param mixed $EinkaufbelegAddItem (Datenstruktur)
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function einkaufbelegAdd($EinkaufbelegAddItem)
    {
        $json_content = self::connectMO('{"einkaufbelegAdd":' . self::decodeParameter($EinkaufbelegAddItem) . '}');

        return new moAPIeinkauf($json_content->einkaufbelegAddResponse->ReturnData);
    }

    /**
     * einkaufbelegWeiterleitung -- fügt einen weitergeleiteten Einkaufbeleg hinzu
     *
     * @param mixed $EinkaufbelegAddItem (Datenstruktur)
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function einkaufbelegWeiterleitung($EinkaufbelegAddItem)
    {
        $json_content = self::connectMO('{"einkaufbelegWeiterleitung":' . self::decodeParameter($EinkaufbelegAddItem) . '}');

        return new moAPIeinkauf($json_content->einkaufbelegWeiterleitungResponse->ReturnData);
    }

    /**
     * einkaufbelegDelete -- löscht einen Einkaufbeleg
     *
     * @param string $Einkaufbeleg_ID
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function einkaufbelegDelete($Einkaufbeleg_ID)
    {
        $json_content = self::connectMO('{"einkaufbelegDelete":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '"}}');

        return new moAPIeinkauf($json_content->einkaufbelegDeleteResponse->ReturnData);
    }

    /**
     * einkaufbelegAddAttachment -- fügt ein Attachment einem Einkaufbeleg hinzu
     *
     * @param string $Einkaufbeleg_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function einkaufbelegAddAttachment($Einkaufbeleg_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"einkaufbelegAddAttachment":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');
        $ret = new moAPIeinkauf($json_content->einkaufbelegAddAttachmentResponse->ReturnData);

        return $ret;
    }

    /**
     * einkaufbelegPrintPDF -- liefert einen Einkaufbeleg als PDF
     *
     * @param string $Einkaufbeleg_ID
     * @param string $DruckformularName
     * @param string $MarkAsPrinted
     *
     * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegPrintItem)
     */
    public static function einkaufbelegPrintPDF($Einkaufbeleg_ID, $DruckformularName, $MarkAsPrinted)
    {
        $json_content = self::connectMO('{"einkaufbelegPrintPDF":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", "DruckformularName":"' . $DruckformularName . '", "MarkAsPrinted":"' . $MarkAsPrinted . '"}}');

        return new moAPIeinkauf($json_content->einkaufbelegPrintPDFResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Buchungen
 */
class moAPIbuchungen extends moAPIHandlerBase
{

    /**
     * buchungFilterTemplate -- Vorlage für Buchung-Filter
     *
     * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp BuchungFilter)
     */
    public static function buchungFilterTemplate()
    {
        $json_content = self::connectMO('{"buchungFilterTemplate":""}');
        $ret = new moAPIbuchungen($json_content->buchungFilterTemplateResponse->ReturnData);

        return $ret;
    }

    /**
     * buchungList -- Listet alle Buchungen
     *
     * @param mixed $BuchungFilter (Datenstruktur)
     *
     * @return moAPIbuchungen , (GetContent() liefert Array vom Datentyp BuchungListItem)
     */
    public static function buchungList($BuchungFilter)
    {
        $json_content = self::connectMO('{"buchungList":' . self::decodeParameter($BuchungFilter) . '}');

        return new moAPIbuchungen($json_content->buchungListResponse->ReturnData);
    }

    /**
     * buchungGet -- Liefert Eigenschaften einer Buchung
     *
     * @param string $Buchung_ID
     *
     * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp BuchungItem)
     */
    public static function buchungGet($Buchung_ID)
    {
        $json_content = self::connectMO('{"buchungGet":{"Buchung_ID":"' . $Buchung_ID . '"}}');

        return new moAPIbuchungen($json_content->buchungGetResponse->ReturnData);
    }

    /**
     * buchungTemplate -- liefert BuchungAddItem als Vorlage
     *
     * @param mixed $PositionenAnzahl
     *
     * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp BuchungAddItem)
     */
    public static function buchungTemplate($PositionenAnzahl)
    {
        $json_content = self::connectMO('{"buchungTemplate":{"PositionenAnzahl":"' . $PositionenAnzahl . '"}}');

        return new moAPIbuchungen($json_content->buchungTemplateResponse->ReturnData);
    }

    /**
     * buchungAdd -- fügt neue Buchung hinzu
     *
     * @param mixed $BuchungAddItem (Datenstruktur)
     *
     * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function buchungAdd($BuchungAddItem)
    {
        $json_content = self::connectMO('{"buchungAdd":' . self::decodeParameter($BuchungAddItem) . '}');

        return new moAPIbuchungen($json_content->buchungAddResponse->ReturnData);
    }

    /**
     * buchungAddAttachment -- fügt ein Attachment einer Buchung hinzu
     *
     * @param string $Buchung_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function buchungAddAttachment($Buchung_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"buchungAddAttachment":{"Buchung_ID":"' . $Buchung_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');

        return new moAPIbuchungen($json_content->buchungAddAttachmentResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Debitoren
 */
class moAPIdebitoren extends moAPIHandlerBase
{

    /**
     * debitorenRechnungFilterTemplate -- Vorlage für Filter Debitorenrechnungen
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungFilter)
     */
    public static function debitorenRechnungFilterTemplate()
    {
        $json_content = self::connectMO('{"debitorenRechnungFilterTemplate":""}');

        return new moAPIdebitoren($json_content->debitorenRechnungFilterTemplateResponse->ReturnData);
    }

    /**
     * debitorenRechnungList -- Auflistung Debitorenrechnungen
     *
     * @param mixed $DebitorenRechnungFilter (Datenstruktur)
     *
     * @return moAPIdebitoren , (GetContent() liefert Array vom Datentyp DebitorenRechnungListItem)
     */
    public static function debitorenRechnungList($DebitorenRechnungFilter)
    {
        $json_content = self::connectMO('{"debitorenRechnungList":' . self::decodeParameter($DebitorenRechnungFilter) . '}');

        return new moAPIdebitoren($json_content->debitorenRechnungListResponse->ReturnData);
    }

    /**
     * debitorenRechnungGet -- Liefert Details einer Debitorenrechnung
     *
     * @param string $Posten_ID
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungItem)
     */
    public static function debitorenRechnungGet($Posten_ID)
    {
        $json_content = self::connectMO('{"debitorenRechnungGet":{"Posten_ID":"' . $Posten_ID . '"}}');

        return new moAPIdebitoren($json_content->debitorenRechnungGetResponse->ReturnData);
    }

    /**
     * debitorenRechnungTemplate -- liefert DebitorenRechnungAddItem als Vorlage
     *
     * @param string $Adresse_ID
     * @param string $Datum
     * @param string $PositionenAnzahl
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungAddItem)
     */
    public static function debitorenRechnungTemplate($Adresse_ID, $Datum, $PositionenAnzahl)
    {
        $json_content = self::connectMO('{"debitorenRechnungTemplate":{"Adresse_ID":"' . $Adresse_ID . '", "Datum":"' . $Datum . '", "PositionenAnzahl":"' . $PositionenAnzahl . '"}}');

        return new moAPIdebitoren($json_content->debitorenRechnungTemplateResponse->ReturnData);
    }

    /**
     * debitorenRechnungPreview -- berechnet eine neue Debitorenrechnung, ohne speichern
     *
     * @param mixed $DebitorenRechnungAddItem (Datenstruktur)
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungItem)
     */
    public static function debitorenRechnungPreview($DebitorenRechnungAddItem)
    {
        $json_content = self::connectMO('{"debitorenRechnungPreview":' . self::decodeParameter($DebitorenRechnungAddItem) . '}');

        return new moAPIdebitoren($json_content->debitorenRechnungPreviewResponse->ReturnData);
    }

    /**
     * debitorenRechnungAdd -- fügt eine neue Debitorenrechnung hinzu
     *
     * @param mixed $DebitorenRechnungAddItem (Datenstruktur)
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function debitorenRechnungAdd($DebitorenRechnungAddItem)
    {
        $json_content = self::connectMO('{"debitorenRechnungAdd":' . self::decodeParameter($DebitorenRechnungAddItem) . '}');

        return new moAPIdebitoren($json_content->debitorenRechnungAddResponse->ReturnData);
    }

    /**
     * debitorenRechnungDelete -- löscht eine vorhandene Debitorenrechnung
     *
     * @param string $Posten_ID
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function debitorenRechnungDelete($Posten_ID)
    {
        $json_content = self::connectMO('{"debitorenRechnungDelete":{"Posten_ID":"' . $Posten_ID . '"}}');

        return new moAPIdebitoren($json_content->debitorenRechnungDeleteResponse->ReturnData);
    }

    /**
     * debitorenRechnungAddAttachment -- fügt ein Attachment einer Debitorenrechnung hinzu
     *
     * @param string $Posten_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function debitorenRechnungAddAttachment($Posten_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"debitorenRechnungAddAttachment":{"Posten_ID":"' . $Posten_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');

        return new moAPIdebitoren($json_content->debitorenRechnungAddAttachmentResponse->ReturnData);
    }

    /**
     * debitorenZahlungFilterTemplate -- Vorlage für Filter Debitorenzahlungen
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenZahlungFilter)
     */
    public static function debitorenZahlungFilterTemplate()
    {
        $json_content = self::connectMO('{"debitorenZahlungFilterTemplate":""}');

        return new moAPIdebitoren($json_content->debitorenZahlungFilterTemplateResponse->ReturnData);
    }

    /**
     * debitorenZahlungList -- Auflistung Debitorenzahlungen
     *
     * @param mixed $DebitorenZahlungFilter (Datenstruktur)
     *
     * @return moAPIdebitoren , (GetContent() liefert Array vom Datentyp DebitorenZahlungListItem)
     */
    public static function debitorenZahlungList($DebitorenZahlungFilter)
    {
        $json_content = self::connectMO('{"debitorenZahlungList":' . self::decodeParameter($DebitorenZahlungFilter) . '}');

        return new moAPIdebitoren($json_content->debitorenZahlungListResponse->ReturnData);
    }

    /**
     * debitorenZahlungGet -- Liefert Details einer Debitorenzahlung
     *
     * @param string $Zahlung_ID
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenZahlungItem)
     */
    public static function debitorenZahlungGet($Zahlung_ID)
    {
        $json_content = self::connectMO('{"debitorenZahlungGet":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');

        return new moAPIdebitoren($json_content->debitorenZahlungGetResponse->ReturnData);
    }

    /**
     * debitorenZahlungCreate -- erzeugt Zahlung für Debitorenrechnung
     *
     * @param string $Posten_ID
     * @param string $Datum
     * @param string $Konto
     * @param mixed $Zahlungsart (Datenstruktur)
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function debitorenZahlungCreate($Posten_ID, $Datum, $Konto, $Zahlungsart)
    {
        $json_content = self::connectMO('{"debitorenZahlungCreate":{"Posten_ID":"' . $Posten_ID . '", "Datum":"' . $Datum . '", "Konto":"' . $Konto . '", ' . self::decodeParameter($Zahlungsart) . '}}');

        return new moAPIdebitoren($json_content->debitorenZahlungCreateResponse->ReturnData);
    }

    /**
     * debitorenZahlungDelete -- löscht eine vorhandene Debitorenzahlung
     *
     * @param string $Zahlung_ID
     *
     * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function debitorenZahlungDelete($Zahlung_ID)
    {
        $json_content = self::connectMO('{"debitorenZahlungDelete":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');

        return new moAPIdebitoren($json_content->debitorenZahlungDeleteResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Kreditoren
 */
class moAPIkreditoren extends moAPIHandlerBase
{

    /**
     * kreditorenRechnungFilterTemplate -- Vorlage für Filter Kreditorenrechnungen
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungFilter)
     */
    public static function kreditorenRechnungFilterTemplate()
    {
        $json_content = self::connectMO('{"kreditorenRechnungFilterTemplate":""}');

        return new moAPIkreditoren($json_content->kreditorenRechnungFilterTemplateResponse->ReturnData);
    }

    /**
     * kreditorenRechnungList -- Auflistung Kreditorenrechnungen
     *
     * @param mixed $KreditorenRechnungFilter (Datenstruktur)
     *
     * @return moAPIkreditoren , (GetContent() liefert Array vom Datentyp KreditorenRechnungListItem)
     */
    public static function kreditorenRechnungList($KreditorenRechnungFilter)
    {
        $json_content = self::connectMO('{"kreditorenRechnungList":' . self::decodeParameter($KreditorenRechnungFilter) . '}');

        return new moAPIkreditoren($json_content->kreditorenRechnungListResponse->ReturnData);
    }

    /**
     * kreditorenRechnungGet -- Liefert Details einer Kreditorenrechnung
     *
     * @param string $Posten_ID
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungItem)
     */
    public static function kreditorenRechnungGet($Posten_ID)
    {
        $json_content = self::connectMO('{"kreditorenRechnungGet":{"Posten_ID":"' . $Posten_ID . '"}}');

        return new moAPIkreditoren($json_content->kreditorenRechnungGetResponse->ReturnData);
    }

    /**
     * kreditorenRechnungTemplate -- liefert KreditorenRechnungAddItem als Vorlage
     *
     * @param string $Adresse_ID
     * @param string $Datum
     * @param string $PositionenAnzahl
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungAddItem)
     */
    public static function kreditorenRechnungTemplate($Adresse_ID, $Datum, $PositionenAnzahl)
    {
        $json_content = self::connectMO('{"kreditorenRechnungTemplate":{"Adresse_ID":"' . $Adresse_ID . '", "Datum":"' . $Datum . '", "PositionenAnzahl":"' . $PositionenAnzahl . '"}}');

        return new moAPIkreditoren($json_content->kreditorenRechnungTemplateResponse->ReturnData);
    }

    /**
     * kreditorenRechnungPreview -- berechnet eine neue Kreditorenrechnung, ohne speichern
     *
     * @param mixed $KreditorenRechnungAddItem (Datenstruktur)
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungItem)
     */
    public static function kreditorenRechnungPreview($KreditorenRechnungAddItem)
    {
        $json_content = self::connectMO('{"kreditorenRechnungPreview":' . self::decodeParameter($KreditorenRechnungAddItem) . '}');

        return new moAPIkreditoren($json_content->kreditorenRechnungPreviewResponse->ReturnData);
    }

    /**
     * kreditorenRechnungAdd -- fügt eine neue Kreditorenrechnung hinzu
     *
     * @param mixed $KreditorenRechnungAddItem (Datenstruktur)
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function kreditorenRechnungAdd($KreditorenRechnungAddItem)
    {
        $json_content = self::connectMO('{"kreditorenRechnungAdd":' . self::decodeParameter($KreditorenRechnungAddItem) . '}');

        return new moAPIkreditoren($json_content->kreditorenRechnungAddResponse->ReturnData);
    }

    /**
     * kreditorenRechnungDelete -- löscht eine vorhandene Kreditorenrechnung
     *
     * @param string $Posten_ID
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function kreditorenRechnungDelete($Posten_ID)
    {
        $json_content = self::connectMO('{"kreditorenRechnungDelete":{"Posten_ID":"' . $Posten_ID . '"}}');

        return new moAPIkreditoren($json_content->kreditorenRechnungDeleteResponse->ReturnData);
    }

    /**
     * kreditorenRechnungAddAttachment -- fügt ein Attachment einer Kreditorenrechnung hinzu
     *
     * @param string $Posten_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function kreditorenRechnungAddAttachment($Posten_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"kreditorenRechnungAddAttachment":{"Posten_ID":"' . $Posten_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');

        return new moAPIkreditoren($json_content->kreditorenRechnungAddAttachmentResponse->ReturnData);
    }

    /**
     * kreditorenZahlungFilterTemplate -- Vorlage für Filter Kreditorenzahlungen
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenZahlungFilter)
     */
    public static function kreditorenZahlungFilterTemplate()
    {
        $json_content = self::connectMO('{"kreditorenZahlungFilterTemplate":""}');

        return new moAPIkreditoren($json_content->kreditorenZahlungFilterTemplateResponse->ReturnData);
    }

    /**
     * kreditorenZahlungList -- Auflistung Kreditorenzahlungen
     *
     * @param mixed $KreditorenZahlungFilter (Datenstruktur)
     *
     * @return moAPIkreditoren , (GetContent() liefert Array vom Datentyp KreditorenZahlungListItem)
     */
    public static function kreditorenZahlungList($KreditorenZahlungFilter)
    {
        $json_content = self::connectMO('{"kreditorenZahlungList":' . self::decodeParameter($KreditorenZahlungFilter) . '}');

        return new moAPIkreditoren($json_content->kreditorenZahlungListResponse->ReturnData);
    }

    /**
     * kreditorenZahlungGet -- Liefert Details einer Kreditorenzahlung
     *
     * @param string $Zahlung_ID
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenZahlungItem)
     */
    public static function kreditorenZahlungGet($Zahlung_ID)
    {
        $json_content = self::connectMO('{"kreditorenZahlungGet":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');

        return new moAPIkreditoren($json_content->kreditorenZahlungGetResponse->ReturnData);
    }

    /**
     * kreditorenZahlungCreate -- erzeugt Zahlung für Kreditorenrechnung
     *
     * @param string $Posten_ID
     * @param string $Datum
     * @param string $Konto
     * @param mixed $Zahlungsart (Datenstruktur)
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function kreditorenZahlungCreate($Posten_ID, $Datum, $Konto, $Zahlungsart)
    {
        $json_content = self::connectMO('{"kreditorenZahlungCreate":{"Posten_ID":"' . $Posten_ID . '", "Datum":"' . $Datum . '", "Konto":"' . $Konto . '", ' . self::decodeParameter($Zahlungsart) . '}}');

        return new moAPIkreditoren($json_content->kreditorenZahlungCreateResponse->ReturnData);
    }

    /**
     * kreditorenZahlungDelete -- löscht eine vorhandene Kreditorenzahlung
     *
     * @param string $Zahlung_ID
     *
     * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function kreditorenZahlungDelete($Zahlung_ID)
    {
        $json_content = self::connectMO('{"kreditorenZahlungDelete":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');

        return new moAPIkreditoren($json_content->kreditorenZahlungDeleteResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Offene Posten
 */
class moAPIoffenePosten extends moAPIHandlerBase
{

    /**
     * offenePostenFilterTemplate -- Vorlage für Offene Posten-Filter
     *
     * @return moAPIoffenePosten , ($ret->GetContent() liefert Datentyp OffenePostenFilter)
     */
    public static function offenePostenFilterTemplate()
    {
        $json_content = self::connectMO('{"offenePostenFilterTemplate":""}');

        return new moAPIoffenePosten($json_content->offenePostenFilterTemplateResponse->ReturnData);
    }

    /**
     * offenePostenListDebitoren -- Auflistung offener Posten Debitoren
     *
     * @param mixed $OffenePostenFilter (Datenstruktur)
     *
     * @return moAPIoffenePosten , (GetContent() liefert Array vom Datentyp OffenePostenListItem)
     */
    public static function offenePostenListDebitoren($OffenePostenFilter)
    {
        $json_content = self::connectMO('{"offenePostenListDebitoren":' . self::decodeParameter($OffenePostenFilter) . '}');

        return new moAPIoffenePosten($json_content->offenePostenListDebitorenResponse->ReturnData);
    }

    /**
     * offenePostenListKreditoren -- Auflistung offener Posten Kreditoren
     *
     * @param mixed $OffenePostenFilter (Datenstruktur)
     *
     * @return moAPIoffenePosten , (GetContent() liefert Array vom Datentyp OffenePostenListItem)
     */
    public static function offenePostenListKreditoren($OffenePostenFilter)
    {
        $json_content = self::connectMO('{"offenePostenListKreditoren":' . self::decodeParameter($OffenePostenFilter) . '}');

        return new moAPIoffenePosten($json_content->offenePostenListKreditorenResponse->ReturnData);
    }

    /**
     * offenePostenGet -- Liefert Details eines Posten
     *
     * @param string $Posten_ID
     *
     * @return moAPIoffenePosten , ($ret->GetContent() liefert Datentyp OffenePostenItem)
     */
    public static function offenePostenGet($Posten_ID)
    {
        $json_content = self::connectMO('{"offenePostenGet":{"Posten_ID":"' . $Posten_ID . '"}}');

        return new moAPIoffenePosten($json_content->offenePostenGetResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Projekte
 */
class moAPIprojekte extends moAPIHandlerBase
{

    /**
     * projektFilterTemplate -- Vorlage für Projekt-Filter
     *
     * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ProjektFilter)
     */
    public static function projektFilterTemplate()
    {
        $json_content = self::connectMO('{"projektFilterTemplate":""}');

        return new moAPIprojekte($json_content->projektFilterTemplateResponse->ReturnData);
    }

    /**
     * projektList -- Listet vorhandene Projekte
     *
     * @param mixed $ProjektFilter (Datenstruktur)
     *
     * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ProjektListItem)
     */
    public static function projektList($ProjektFilter)
    {
        $json_content = self::connectMO('{"projektList":' . self::decodeParameter($ProjektFilter) . '}');

        return new moAPIprojekte($json_content->projektListResponse->ReturnData);
    }

    /**
     * projektGet -- Liefert ein Projekt für die ID
     *
     * @param string $Projekt_ID
     *
     * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ProjektItem)
     */
    public static function projektGet($Projekt_ID)
    {
        $json_content = self::connectMO('{"projektGet":{"Projekt_ID":"' . $Projekt_ID . '"}}');

        return new moAPIprojekte($json_content->projektGetResponse->ReturnData);
    }

    /**
     * projektAddAttachment -- fügt ein Attachment einem Projekt hinzu
     *
     * @param string $Projekt_ID
     * @param mixed $AttachmentAddItem (Datenstruktur)
     *
     * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function projektAddAttachment($Projekt_ID, $AttachmentAddItem)
    {
        $json_content = self::connectMO('{"projektAddAttachment":{"Projekt_ID":"' . $Projekt_ID . '", ' . self::decodeParameter($AttachmentAddItem) . '}}');

        return new moAPIprojekte($json_content->projektAddAttachmentResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für Attachment-Verwaltung
 */
class moAPIattachment extends moAPIHandlerBase
{

    /**
     * attachmentFilterTemplate -- Vorlage für Attachment-Filter
     *
     * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentFilter)
     */
    public static function attachmentFilterTemplate()
    {
        $json_content = self::connectMO('{"attachmentFilterTemplate":""}');

        return new moAPIattachment($json_content->attachmentFilterTemplateResponse->ReturnData);
    }

    /**
     * attachmentList -- listet vorhandenen Attachments
     *
     * @param mixed $AttachmentFilter (Datenstruktur)
     *
     * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentListItem)
     */
    public static function attachmentList($AttachmentFilter)
    {
        $json_content = self::connectMO('{"attachmentList":' . self::decodeParameter($AttachmentFilter) . '}');

        return new moAPIattachment($json_content->attachmentListResponse->ReturnData);
    }

    /**
     * attachmentGet -- Liefert Details eines Attachments
     *
     * @param string $Attachment_ID
     *
     * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentItem)
     */
    public static function attachmentGet($Attachment_ID)
    {
        $json_content = self::connectMO('{"attachmentGet":{"Attachment_ID":"' . $Attachment_ID . '"}}');

        return new moAPIattachment($json_content->attachmentGetResponse->ReturnData);
    }

    /**
     * attachmentLoad -- Download Attachment-File. Die Daten des Dokuments sind als Base64 codiert
     *
     * @param string $Attachment_ID
     *
     * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentItemData)
     */
    public static function attachmentLoad($Attachment_ID)
    {
        $json_content = self::connectMO('{"attachmentLoad":{"Attachment_ID":"' . $Attachment_ID . '"}}');

        return new moAPIattachment($json_content->attachmentLoadResponse->ReturnData);
    }

    /**
     * attachmentDelete -- löscht ein Attachment
     *
     * @param string $Attachment_ID
     *
     * @return moAPIattachment , ($ret->GetContent() liefert Datentyp ReturnStatus)
     */
    public static function attachmentDelete($Attachment_ID)
    {
        $json_content = self::connectMO('{"attachmentDelete":{"Attachment_ID":"' . $Attachment_ID . '"}}');

        return new moAPIattachment($json_content->attachmentDeleteResponse->ReturnData);
    }
}

/**
 * Zugriffsmodul für API Information
 */
class moAPIapiinfo extends moAPIHandlerBase
{

    /**
     * apiInfoGet -- Infos zum aktuellenAPI
     *
     * @return moAPIapiinfo , ($ret->GetContent() liefert Datentyp apiInfoItem)
     */
    public static function apiInfoGet()
    {
        $json_content = self::connectMO('{"apiInfoGet":""}');

        return new moAPIapiinfo($json_content->apiInfoGetResponse->ReturnData);
    }

    /**
     * apisessionInfoGet -- Infos zur aktuellen Session
     *
     * @return moAPIapiinfo , ($ret->GetContent() liefert Datentyp apisessionInfoItem)
     */
    public static function apisessionInfoGet()
    {
        $json_content = self::connectMO('{"apisessionInfoGet":""}');

        return new moAPIapiinfo($json_content->apisessionInfoGetResponse->ReturnData);
    }
}

?>


