<?php

/**
 * <b>Basisklasse für alle API-Handler</b>
 * Version: 18.1.0
 * API-Schema:  91
 * erstellt:    28.05.21
 */

/**
 *Zugriffs-URL MonKey Office Connect
 */
  $moapi_url = "http://127.0.0.1:8084/monkeyOfficeConnectJSON";
/**
 * Zugriffs-Login MonKey Office Connect
 */
  $moapi_login = "";
/**
 * Zugriffs-Passwort MonKey Office Connect
 */
  $moapi_pass = "";
/**
 * Selektiere Firma für Zugriffe
 */
  $moapi_firma = "";


/**
* abstrakte Basisklasse aller API-Module
* benötigt php-Modul Curl
* kapselt Kommunikation mit MonKey Office Connect
* besitzt einfache Dump-Funktionen für Debug
*/
class moAPIHandlerBase {
/**
 * interne Variable für Content als JSON-Objekt
 */
  protected $m_json;
  

/**
 * @param[in] $json Content des Objektes
*/
  public function __construct($json) {
    $this->m_json = $json;
  }

/**
 * @return liefert true wenn Content gesetzt ist
 */
  public function HasContent(){
    return isset($this->m_json);
  }

/**
 * @return liefert Content-Datenstruktur
 */
  public function GetContent(){
    return $this->m_json;
  }

/**
 * @return gibt Content als HTML-Tabelle aus, für Debug
 */
  public function ContentTableDump() {
    $str  =  "<table border='1' cellpadding='4' cellspacing='0' bordercolor='#E0E0E0'>";
    $str .= "<tr><th align='left' valign='top' colspan='2'>TableDump</th></tr>";
    $str .= "<tr><th align='left' valign='top'>Key</th><th align='left' valign='top'>Value</th></tr>";
    foreach($this->m_json as $key => $val) {
      $str .= "<tr><td align='left' valign='top'>" . $key . "</td><td align='left' valign='top'>" .  htmlentities(json_encode($val,JSON_UNESCAPED_UNICODE)) . "</td></tr>";
    }
    $str .= "</table>";
    return $str;
  }

/**
 * @return liefert true wenn InsertIdent bekannt ist
 */
  public function HasInsertIdent(){
    return ($this->HasStatus() && isset($this->GetContent()->ReturnStatus->Insert_ID));
  }

/**
 * @return liefert InsertIdent
 */
  public function InsertIdent() {
    if($this->HasInsertIdent()) {
      $str = $this->GetContent()->ReturnStatus->Insert_ID;
      return $str;
    }
    return "";
  }

/**
 * @return liefert true wenn Status gesetzt ist
 */
  public function HasStatus(){
    return ($this->HasContent() && isset($this->GetContent()->ReturnStatus));
  }

/**
 * @return liefert Statustext als String-Array
*/
  public function StatusText() {
    if($this->HasStatus() && isset($this->GetContent()->ReturnStatus->StatustextItem)) {
      $str = $this->GetContent()->ReturnStatus->StatustextItem;
      return (array)$str;
    }
    return "";
  }

/**
 * @return gibt StatusText als HTML-Tabelle aus, für Debug
*/
  public function StatusTextDump() {
    if($this->HasStatus() && isset($this->GetContent()->ReturnStatus->StatustextItem)) {
      $texte = $this->StatusText();
      $str  =  "<table border='1' cellpadding='4' cellspacing='0' bordercolor='#E0E0E0'>";
      $str .= "<tr><th align='left' valign='top'>StatusDump</th></tr>";
      $str .= "<tr><th align='left' valign='top'>Key</th></tr>";
      foreach($texte as $txt) {
        $str .= "<tr><td align='left' valign='top'>" . $txt->StatustextItem . "</td></tr>";
      }
      $str .= "</table>";
      return $str;
    }
    return "";
  }

/**
 * @return gibt StatusCode zurück
*/
  public function StatusCode() {
    if($this->HasStatus()) {
      $str = $this->GetContent()->ReturnStatus->Statuscode;
      return $str;
    }
    return "";
  }

/**
 * @return liefert true wenn StatusCode vorhanden ist und StatusCode OK ist
 */
  public function StatusOk() {
    return ($this->HasStatus() && $this->StatusCode()==0);
  }

/**
 führt einen Zugriff auf MonKey Office Connect aus
 @param[in] $query_json JSON-Datenstruktur für Anfrage
 @return Output Antwort als JSON-Objekt
*/

/**
* hält geöffnetes curl-Handle,
* wird von ConnectMO() gesetzt
* gilt bis Aufruf DisConnectMO() bzw Scriptende
*/
  protected static $ch;

/**
führt einen Zugriff auf MonKey Office Connect aus
@param[in] $query_json JSON-Datenstruktur für Anfrage
@return Output Antwort als JSON-Objekt
*/
  protected static function ConnectMO($query_json) {
    global $moapi_url;
    global $moapi_login;
    global $moapi_pass;
    global $moapi_firma;
    global $moapi_wirtschaftsjahr;
    if(!isset(self::$ch)){
       self::$ch = curl_init();
       curl_setopt(self::$ch, CURLOPT_URL            , $moapi_url);
       curl_setopt(self::$ch, CURLOPT_HEADER         , false);
       curl_setopt(self::$ch, CURLOPT_VERBOSE        , true);
       curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER , true);
       curl_setopt(self::$ch, CURLOPT_FOLLOWLOCATION , true);
       curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER , false);
       curl_setopt(self::$ch, CURLOPT_HTTPHEADER     , array('Content-Length: ' . strlen($query_json)));
       curl_setopt(self::$ch, CURLOPT_USERPWD        , $moapi_login.":".$moapi_pass);
       curl_setopt(self::$ch, CURLOPT_HTTPAUTH       ,  CURLAUTH_ANY);
       curl_setopt(self::$ch, CURLOPT_POST           , true);
       curl_setopt(self::$ch, CURLOPT_POSTFIELDS     , $query_json);
    }else{
       curl_setopt(self::$ch, CURLOPT_HTTPHEADER     , array('Content-Length: ' . strlen($query_json)));
       curl_setopt(self::$ch,  CURLOPT_POSTFIELDS    , $query_json);
    }
    if($moapi_firma!="")  {
      curl_setopt(self::$ch, CURLOPT_HTTPHEADER     , array('mbl-ident: ' . $moapi_firma));
    }
    $json = curl_exec(self::$ch);
    $json_content = json_decode($json);
    return $json_content;
  }

/**
 * Schliesst offene Verbindung
*/
  public static function DisConnectMO() {
    if(isset(self::$ch)){
      curl_close(self::$ch);
      self::$ch=NULL;
    }
  }

/**
 * @param[in] $in zu konvertierende Variable
 * @return Konvertierte Variable $in für Zugriffsfunktionen
*/
  protected static function  DecodeParameter($in) {
    if($in instanceof moAPIHandlerBase){
      $ret=json_encode($in->GetContent());
    }elseif($in==""){
      $ret= '""';
    }else{
      $ret= $in;
    }
    return $ret;
  }
}
?>

<?php
/**
 * <b>Zugriffsmodul für Firmen</b>
 */
class moAPIfirmen extends moAPIHandlerBase {
 
/**
 * firmaList -- Listet verfügbare Firmen
 * @return moAPIfirmen , (GetContent() liefert Array vom Datentyp FirmaListItem)
*/
  public static function firmaList(){
    $json_content = self::connectMO('{"firmaList":""}');
    $ret = new moAPIfirmen($json_content->firmaListResponse->ReturnData);
    return $ret;
  }
 
/**
 * firmaGet -- Infos zur aktuell selektierten Firma
 * @return moAPIfirmen , ($ret->GetContent() liefert Datentyp FirmaItem)
*/
  public static function firmaGet(){
    $json_content = self::connectMO('{"firmaGet":""}');
    $ret = new moAPIfirmen($json_content->firmaGetResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Vorgaben</b>
 */
class moAPIvorgaben extends moAPIHandlerBase {
 
/**
 * kostenstellenList -- Liefert definierte Kostenstellen
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp KostenstelleListItem)
*/
  public static function kostenstellenList(){
    $json_content = self::connectMO('{"kostenstellenList":""}');
    $ret = new moAPIvorgaben($json_content->kostenstellenListResponse->ReturnData);
    return $ret;
  }
 
/**
 * nummernkreisList -- Liefert definierte Nummerkreise
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp NummernkreisListItem)
*/
  public static function nummernkreisList(){
    $json_content = self::connectMO('{"nummernkreisList":""}');
    $ret = new moAPIvorgaben($json_content->nummernkreisListResponse->ReturnData);
    return $ret;
  }
 
/**
 * steuersatzList -- Liefert definierte Steuersätze
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp SteuersatzListItem)
*/
  public static function steuersatzList(){
    $json_content = self::connectMO('{"steuersatzList":""}');
    $ret = new moAPIvorgaben($json_content->steuersatzListResponse->ReturnData);
    return $ret;
  }
 
/**
 * waehrungList -- Liefert definierte Währungen
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp WaehrungListItem)
*/
  public static function waehrungList(){
    $json_content = self::connectMO('{"waehrungList":""}');
    $ret = new moAPIvorgaben($json_content->waehrungListResponse->ReturnData);
    return $ret;
  }
 
/**
 * preislisteVerkaufList -- Liefert definierte VK-Preisliste
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp VerkaufpreislisteListItem)
*/
  public static function preislisteVerkaufList(){
    $json_content = self::connectMO('{"preislisteVerkaufList":""}');
    $ret = new moAPIvorgaben($json_content->preislisteVerkaufListResponse->ReturnData);
    return $ret;
  }
 
/**
 * zahlungsbedingungEinkaufList -- Liefert definierte Zahlungsbedingungen Einkauf
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp ZahlungsBedingungEinkaufListItem)
*/
  public static function zahlungsbedingungEinkaufList(){
    $json_content = self::connectMO('{"zahlungsbedingungEinkaufList":""}');
    $ret = new moAPIvorgaben($json_content->zahlungsbedingungEinkaufListResponse->ReturnData);
    return $ret;
  }
 
/**
 * zahlungsbedingungVerkaufList -- Liefert definierte Zahlungsbedingungen Verkauf
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp ZahlungsBedingungVerkaufListItem)
*/
  public static function zahlungsbedingungVerkaufList(){
    $json_content = self::connectMO('{"zahlungsbedingungVerkaufList":""}');
    $ret = new moAPIvorgaben($json_content->zahlungsbedingungVerkaufListResponse->ReturnData);
    return $ret;
  }
 
/**
 * druckformularFilterTemplate -- Liefert Filter für Druckformulare
 * @return moAPIvorgaben , ($ret->GetContent() liefert Datentyp DruckFormularFilter)
*/
  public static function druckformularFilterTemplate(){
    $json_content = self::connectMO('{"druckformularFilterTemplate":""}');
    $ret = new moAPIvorgaben($json_content->druckformularFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * druckformularList -- Liefert definierte Druckformulare
 * @param[in] DruckFormularFilter (Datenstruktur) 
 * @return moAPIvorgaben , (GetContent() liefert Array vom Datentyp DruckFormularListItem)
*/
  public static function druckformularList($DruckFormularFilter){
    $json_content = self::connectMO('{"druckformularList":'.self::decodeParameter($DruckFormularFilter).'}');
    $ret = new moAPIvorgaben($json_content->druckformularListResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Adressen</b>
 */
class moAPIadressen extends moAPIHandlerBase {
 
/**
 * adresseFilterTemplate -- Vorlage für Adressen-Filter
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AdresseFilter)
*/
  public static function adresseFilterTemplate(){
    $json_content = self::connectMO('{"adresseFilterTemplate":""}');
    $ret = new moAPIadressen($json_content->adresseFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseList -- liefert alle Adressen als Liste
 * @param[in] AdresseFilter (Datenstruktur) 
 * @return moAPIadressen , (GetContent() liefert Array vom Datentyp AdresseListItem)
*/
  public static function adresseList($AdresseFilter){
    $json_content = self::connectMO('{"adresseList":'.self::decodeParameter($AdresseFilter).'}');
    $ret = new moAPIadressen($json_content->adresseListResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseGet -- liefert Details einer Adresse
 * @param[in] Adresse_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AdresseItem)
*/
  public static function adresseGet($Adresse_ID){
    $json_content = self::connectMO('{"adresseGet":{"Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAdd -- fügt eine Adresse hinzu
 * @param[in] AdresseAddItem (Datenstruktur) 
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseAdd($AdresseAddItem){
    $json_content = self::connectMO('{"adresseAdd":'.self::decodeParameter($AdresseAddItem).'}');
    $ret = new moAPIadressen($json_content->adresseAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseModify -- modifiziert vorhandene Adresse
 * @param[in] AdresseItem (Datenstruktur) 
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseModify($AdresseItem){
    $json_content = self::connectMO('{"adresseModify":'.self::decodeParameter($AdresseItem).'}');
    $ret = new moAPIadressen($json_content->adresseModifyResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseDelete -- löscht vorhandene Adresse
 * @param[in] Adresse_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseDelete($Adresse_ID){
    $json_content = self::connectMO('{"adresseDelete":{"Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseTemplate -- liefert AdresseAddItem als Vorlage
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AdresseAddItem)
*/
  public static function adresseTemplate(){
    $json_content = self::connectMO('{"adresseTemplate":""}');
    $ret = new moAPIadressen($json_content->adresseTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseKategorieList -- ermittelt alle Adress-Kategorien 
 * @return moAPIadressen , (GetContent() liefert Array vom Datentyp AdresseKategorieItem)
*/
  public static function adresseKategorieList(){
    $json_content = self::connectMO('{"adresseKategorieList":""}');
    $ret = new moAPIadressen($json_content->adresseKategorieListResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAddAttachment -- fügt ein Attachment einer Adresse hinzu
 * @param[in] Adresse_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseAddAttachment($Adresse_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"adresseAddAttachment":{"Adresse_ID":"' . $Adresse_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIadressen($json_content->adresseAddAttachmentResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAnsprechpartnerTemplate -- liefert AnsprechpartnerAddItem als Vorlage
 * @param[in] Adresse_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AnsprechpartnerAddItem)
*/
  public static function adresseAnsprechpartnerTemplate($Adresse_ID){
    $json_content = self::connectMO('{"adresseAnsprechpartnerTemplate":{"Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseAnsprechpartnerTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAnsprechpartnerList -- liefert alle Ansprechpartner einer Adresse
 * @param[in] Adresse_ID
 * @return moAPIadressen , (GetContent() liefert Array vom Datentyp AnsprechpartnerListItem)
*/
  public static function adresseAnsprechpartnerList($Adresse_ID){
    $json_content = self::connectMO('{"adresseAnsprechpartnerList":{"Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseAnsprechpartnerListResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAnsprechpartnerAdd -- fügt Ansprechpartner zu Adresse hinzu
 * @param[in] AnsprechpartnerAddItem (Datenstruktur) 
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseAnsprechpartnerAdd($AnsprechpartnerAddItem){
    $json_content = self::connectMO('{"adresseAnsprechpartnerAdd":'.self::decodeParameter($AnsprechpartnerAddItem).'}');
    $ret = new moAPIadressen($json_content->adresseAnsprechpartnerAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAnsprechpartnerGet -- liefert Details eines einzelnen Ansprechpartner
 * @param[in] Ansprechpartner_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp AnsprechpartnerItem)
*/
  public static function adresseAnsprechpartnerGet($Ansprechpartner_ID){
    $json_content = self::connectMO('{"adresseAnsprechpartnerGet":{"Ansprechpartner_ID":"' . $Ansprechpartner_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseAnsprechpartnerGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAnsprechpartnerModify -- modifiziert vorhandenen Ansprechpartner
 * @param[in] AnsprechpartnerItem (Datenstruktur) 
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseAnsprechpartnerModify($AnsprechpartnerItem){
    $json_content = self::connectMO('{"adresseAnsprechpartnerModify":'.self::decodeParameter($AnsprechpartnerItem).'}');
    $ret = new moAPIadressen($json_content->adresseAnsprechpartnerModifyResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseAnsprechpartnerDelete -- löscht eine Ansprechpartner
 * @param[in] Ansprechpartner_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseAnsprechpartnerDelete($Ansprechpartner_ID){
    $json_content = self::connectMO('{"adresseAnsprechpartnerDelete":{"Ansprechpartner_ID":"' . $Ansprechpartner_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseAnsprechpartnerDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseSepaMandatList -- Auflistung angelegter SEPA-Mandate für Adresse
 * @param[in] Adresse_ID
 * @return moAPIadressen , (GetContent() liefert Array vom Datentyp SepaMandatListItem)
*/
  public static function adresseSepaMandatList($Adresse_ID){
    $json_content = self::connectMO('{"adresseSepaMandatList":{"Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseSepaMandatListResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseSepaMandatTemplate -- Vorlage für neues SEPA-Mandat
 * @param[in] Adresse_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp SepaMandatAddItem)
*/
  public static function adresseSepaMandatTemplate($Adresse_ID){
    $json_content = self::connectMO('{"adresseSepaMandatTemplate":{"Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseSepaMandatTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseSepaMandatAdd -- Anlegen eines SEPA-Mandat für Adresse
 * @param[in] SepaMandatAddItem (Datenstruktur) 
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseSepaMandatAdd($SepaMandatAddItem){
    $json_content = self::connectMO('{"adresseSepaMandatAdd":'.self::decodeParameter($SepaMandatAddItem).'}');
    $ret = new moAPIadressen($json_content->adresseSepaMandatAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseSepaMandatGet -- liefert Details eines vorhandenen SEPA-Mandat
 * @param[in] SepaMandat_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp SepaMandatItem)
*/
  public static function adresseSepaMandatGet($SepaMandat_ID){
    $json_content = self::connectMO('{"adresseSepaMandatGet":{"SepaMandat_ID":"' . $SepaMandat_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseSepaMandatGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseSepaMandatModify -- modifiziert vorhandenes SEPA-Mandat
 * @param[in] SepaMandatItem (Datenstruktur) 
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseSepaMandatModify($SepaMandatItem){
    $json_content = self::connectMO('{"adresseSepaMandatModify":'.self::decodeParameter($SepaMandatItem).'}');
    $ret = new moAPIadressen($json_content->adresseSepaMandatModifyResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseSepaMandatDelete -- löscht vorhandenes SEPA-Mandat
 * @param[in] SepaMandat_ID
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function adresseSepaMandatDelete($SepaMandat_ID){
    $json_content = self::connectMO('{"adresseSepaMandatDelete":{"SepaMandat_ID":"' . $SepaMandat_ID . '"}}');
    $ret = new moAPIadressen($json_content->adresseSepaMandatDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * adresseSepaMandatPrintPDF -- gibt SEPA-Mandat als PDF aus
 * @param[in] SepaMandat_ID, DruckformularName
 * @return moAPIadressen , ($ret->GetContent() liefert Datentyp SepaMandatPrintItem)
*/
  public static function adresseSepaMandatPrintPDF($SepaMandat_ID, $DruckformularName){
    $json_content = self::connectMO('{"adresseSepaMandatPrintPDF":{"SepaMandat_ID":"' . $SepaMandat_ID . '", "DruckformularName":"' . $DruckformularName . '"}}');
    $ret = new moAPIadressen($json_content->adresseSepaMandatPrintPDFResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Artikel und Leistungen</b>
 */
class moAPIartikel extends moAPIHandlerBase {
 
/**
 * warengruppeTemplate -- liefert WarengruppeAddItem als Vorlage
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp WarengruppeAddItem)
*/
  public static function warengruppeTemplate(){
    $json_content = self::connectMO('{"warengruppeTemplate":""}');
    $ret = new moAPIartikel($json_content->warengruppeTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * warengruppeList -- Auflistung Warengruppen
 * @return moAPIartikel , (GetContent() liefert Array vom Datentyp WarengruppeListItem)
*/
  public static function warengruppeList(){
    $json_content = self::connectMO('{"warengruppeList":""}');
    $ret = new moAPIartikel($json_content->warengruppeListResponse->ReturnData);
    return $ret;
  }
 
/**
 * warengruppeGet -- Liefert Details einer Warengruppe
 * @param[in] Warengruppe_ID
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp WarengruppeItem)
*/
  public static function warengruppeGet($Warengruppe_ID){
    $json_content = self::connectMO('{"warengruppeGet":{"Warengruppe_ID":"' . $Warengruppe_ID . '"}}');
    $ret = new moAPIartikel($json_content->warengruppeGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * warengruppeAdd -- fügt eine Warengruppe hinzu
 * @param[in] WarengruppeAddItem (Datenstruktur) 
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function warengruppeAdd($WarengruppeAddItem){
    $json_content = self::connectMO('{"warengruppeAdd":'.self::decodeParameter($WarengruppeAddItem).'}');
    $ret = new moAPIartikel($json_content->warengruppeAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * warengruppeDelete -- löscht eine vorhandene Warengruppe
 * @param[in] Warengruppe_ID
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function warengruppeDelete($Warengruppe_ID){
    $json_content = self::connectMO('{"warengruppeDelete":{"Warengruppe_ID":"' . $Warengruppe_ID . '"}}');
    $ret = new moAPIartikel($json_content->warengruppeDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelTemplate -- liefert ArtikelAddltem als Vorlage
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelAddltem)
*/
  public static function artikelTemplate(){
    $json_content = self::connectMO('{"artikelTemplate":""}');
    $ret = new moAPIartikel($json_content->artikelTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelList -- Auflistung Artikel
 * @param[in] ArtikelFilter (Datenstruktur) 
 * @return moAPIartikel , (GetContent() liefert Array vom Datentyp ArtikelListItem)
*/
  public static function artikelList($ArtikelFilter){
    $json_content = self::connectMO('{"artikelList":'.self::decodeParameter($ArtikelFilter).'}');
    $ret = new moAPIartikel($json_content->artikelListResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelGet -- Liefert Details eines Artikel/Leistung
 * @param[in] Artikel_ID
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelItem)
*/
  public static function artikelGet($Artikel_ID){
    $json_content = self::connectMO('{"artikelGet":{"Artikel_ID":"' . $Artikel_ID . '"}}');
    $ret = new moAPIartikel($json_content->artikelGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelAdd -- fügt einen Artikel/Leistung hinzu
 * @param[in] ArtikelAddltem (Datenstruktur) 
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function artikelAdd($ArtikelAddltem){
    $json_content = self::connectMO('{"artikelAdd":'.self::decodeParameter($ArtikelAddltem).'}');
    $ret = new moAPIartikel($json_content->artikelAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelDelete -- löscht einen vorhandene Artikel/Leistung
 * @param[in] Artikel_ID
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function artikelDelete($Artikel_ID){
    $json_content = self::connectMO('{"artikelDelete":{"Artikel_ID":"' . $Artikel_ID . '"}}');
    $ret = new moAPIartikel($json_content->artikelDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelModify -- ändert einen vorhandenen Artikel/Leistung
 * @param[in] ArtikelItem (Datenstruktur) 
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function artikelModify($ArtikelItem){
    $json_content = self::connectMO('{"artikelModify":'.self::decodeParameter($ArtikelItem).'}');
    $ret = new moAPIartikel($json_content->artikelModifyResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelFilterTemplate -- Vorlage für Filter Artikel/Leistungen
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelFilter)
*/
  public static function artikelFilterTemplate(){
    $json_content = self::connectMO('{"artikelFilterTemplate":""}');
    $ret = new moAPIartikel($json_content->artikelFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelAddAttachment -- fügt ein Attachment einem Artikel hinzu
 * @param[in] Artikel_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function artikelAddAttachment($Artikel_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"artikelAddAttachment":{"Artikel_ID":"' . $Artikel_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIartikel($json_content->artikelAddAttachmentResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelBildGet -- Abrufen eines Artikelbildes
 * @param[in] Artikel_ID, Bildposition
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelBildItem)
*/
  public static function artikelBildGet($Artikel_ID, $Bildposition){
    $json_content = self::connectMO('{"artikelBildGet":{"Artikel_ID":"' . $Artikel_ID . '", "Bildposition":"' . $Bildposition . '"}}');
    $ret = new moAPIartikel($json_content->artikelBildGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelBildTemplate -- Abrufen einer Datenstruktur ArtikelBildAddlItem
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ArtikelBildAddlItem)
*/
  public static function artikelBildTemplate(){
    $json_content = self::connectMO('{"artikelBildTemplate":""}');
    $ret = new moAPIartikel($json_content->artikelBildTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * artikelBildAdd -- fügt ein Artikelbild hinzu
 * @param[in] Artikel_ID, ArtikelBildAddlItem (Datenstruktur) 
 * @return moAPIartikel , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function artikelBildAdd($Artikel_ID, $ArtikelBildAddlItem){
    $json_content = self::connectMO('{"artikelBildAdd":{"Artikel_ID":"' . $Artikel_ID . '", '.self::decodeParameter($ArtikelBildAddlItem).'}}');
    $ret = new moAPIartikel($json_content->artikelBildAddResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Lager</b>
 */
class moAPIlager extends moAPIHandlerBase {
 
/**
 * lagerartikelList -- Listet alle Lagerartikel
 * @return moAPIlager , (GetContent() liefert Array vom Datentyp ArtikelListItem)
*/
  public static function lagerartikelList(){
    $json_content = self::connectMO('{"lagerartikelList":""}');
    $ret = new moAPIlager($json_content->lagerartikelListResponse->ReturnData);
    return $ret;
  }
 
/**
 * lagerjournalFilterTemplate -- Vorlage für Lagerjournal-Filter
 * @return moAPIlager , ($ret->GetContent() liefert Datentyp LagerjournalFilter)
*/
  public static function lagerjournalFilterTemplate(){
    $json_content = self::connectMO('{"lagerjournalFilterTemplate":""}');
    $ret = new moAPIlager($json_content->lagerjournalFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * lagerjournalList -- Liefert Lagerjournal(mit filter)
 * @param[in] LagerjournalFilter (Datenstruktur) 
 * @return moAPIlager , (GetContent() liefert Array vom Datentyp LagerjournalArtikelItem)
*/
  public static function lagerjournalList($LagerjournalFilter){
    $json_content = self::connectMO('{"lagerjournalList":'.self::decodeParameter($LagerjournalFilter).'}');
    $ret = new moAPIlager($json_content->lagerjournalListResponse->ReturnData);
    return $ret;
  }
 
/**
 * lagerjournalGet -- Liefert Lagerjournal für Artikel (mit ID)
 * @param[in] Artikel_ID, NurLetzeBewegung
 * @return moAPIlager , ($ret->GetContent() liefert Datentyp LagerjournalItem)
*/
  public static function lagerjournalGet($Artikel_ID, $NurLetzeBewegung){
    $json_content = self::connectMO('{"lagerjournalGet":{"Artikel_ID":"' . $Artikel_ID . '", "NurLetzeBewegung":"' . $NurLetzeBewegung . '"}}');
    $ret = new moAPIlager($json_content->lagerjournalGetResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Verkaufsbelege</b>
 */
class moAPIverkauf extends moAPIHandlerBase {
 
/**
 * verkaufbelegFilterTemplate -- Vorlage für Verkaufbeleg-Filter
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegFilter)
*/
  public static function verkaufbelegFilterTemplate(){
    $json_content = self::connectMO('{"verkaufbelegFilterTemplate":""}');
    $ret = new moAPIverkauf($json_content->verkaufbelegFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegList -- Auflistung Verkaufbelege
 * @param[in] VerkaufbelegFilter (Datenstruktur) 
 * @return moAPIverkauf , (GetContent() liefert Array vom Datentyp VerkaufbelegListitem)
*/
  public static function verkaufbelegList($VerkaufbelegFilter){
    $json_content = self::connectMO('{"verkaufbelegList":'.self::decodeParameter($VerkaufbelegFilter).'}');
    $ret = new moAPIverkauf($json_content->verkaufbelegListResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegGet -- Liefert Details eines Verkaufbeleg
 * @param[in] Verkaufbeleg_ID
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegItem)
*/
  public static function verkaufbelegGet($Verkaufbeleg_ID){
    $json_content = self::connectMO('{"verkaufbelegGet":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '"}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegTemplate -- liefert VerkaufbelegAddItem als Vorlage
 * @param[in] VerkaufbelegArt, Adresse_ID, VKPreisliste_ID, ArtikelAddPostenList (Datenstruktur) 
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegAddItem)
*/
  public static function verkaufbelegTemplate($VerkaufbelegArt, $Adresse_ID, $VKPreisliste_ID, $ArtikelAddPostenList){
    $json_content = self::connectMO('{"verkaufbelegTemplate":{"VerkaufbelegArt":"' . $VerkaufbelegArt . '", "Adresse_ID":"' . $Adresse_ID . '", "VKPreisliste_ID":"' . $VKPreisliste_ID . '", '.self::decodeParameter($ArtikelAddPostenList).'}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegDuplikatTemplate -- Vorlage für einen duplizierten Verkaufbeleg
 * @param[in] Verkaufbeleg_ID, Adresse_ID
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegAddItem)
*/
  public static function verkaufbelegDuplikatTemplate($Verkaufbeleg_ID, $Adresse_ID){
    $json_content = self::connectMO('{"verkaufbelegDuplikatTemplate":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", "Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegDuplikatTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegWeiterleitungTemplate -- Vorlage für einen weitergeleiteten Verkaufbeleg
 * @param[in] Verkaufbeleg_ID, VerkaufbelegArt
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegAddItem)
*/
  public static function verkaufbelegWeiterleitungTemplate($Verkaufbeleg_ID, $VerkaufbelegArt){
    $json_content = self::connectMO('{"verkaufbelegWeiterleitungTemplate":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", "VerkaufbelegArt":"' . $VerkaufbelegArt . '"}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegWeiterleitungTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegPositionTemplate -- liefert VerkaufbelegPositionAddItem als Vorlage
 * @param[in] Artikel_ID, Adresse_ID, VKPreisliste_ID, Artikelmenge
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegPositionAddItem)
*/
  public static function verkaufbelegPositionTemplate($Artikel_ID, $Adresse_ID, $VKPreisliste_ID, $Artikelmenge){
    $json_content = self::connectMO('{"verkaufbelegPositionTemplate":{"Artikel_ID":"' . $Artikel_ID . '", "Adresse_ID":"' . $Adresse_ID . '", "VKPreisliste_ID":"' . $VKPreisliste_ID . '", "Artikelmenge":"' . $Artikelmenge . '"}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegPositionTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegPreview -- berechnet einen Verkaufbeleg ohne ihn zu sichern
 * @param[in] VerkaufbelegAddItem (Datenstruktur) 
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegItem)
*/
  public static function verkaufbelegPreview($VerkaufbelegAddItem){
    $json_content = self::connectMO('{"verkaufbelegPreview":'.self::decodeParameter($VerkaufbelegAddItem).'}');
    $ret = new moAPIverkauf($json_content->verkaufbelegPreviewResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegAdd -- fügt einen neuen Verkaufbeleg hinzu
 * @param[in] VerkaufbelegAddItem (Datenstruktur) 
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function verkaufbelegAdd($VerkaufbelegAddItem){
    $json_content = self::connectMO('{"verkaufbelegAdd":'.self::decodeParameter($VerkaufbelegAddItem).'}');
    $ret = new moAPIverkauf($json_content->verkaufbelegAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegWeiterleitung -- fügt einen Verkaufbeleg als Weiterleitung hinzu
 * @param[in] VerkaufbelegAddItem (Datenstruktur) 
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function verkaufbelegWeiterleitung($VerkaufbelegAddItem){
    $json_content = self::connectMO('{"verkaufbelegWeiterleitung":'.self::decodeParameter($VerkaufbelegAddItem).'}');
    $ret = new moAPIverkauf($json_content->verkaufbelegWeiterleitungResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegDelete -- löscht einen Verkaufbeleg
 * @param[in] Verkaufbeleg_ID
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function verkaufbelegDelete($Verkaufbeleg_ID){
    $json_content = self::connectMO('{"verkaufbelegDelete":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '"}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegAddAttachment -- fügt ein Attachment einem Verkaufbeleg hinzu
 * @param[in] Verkaufbeleg_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function verkaufbelegAddAttachment($Verkaufbeleg_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"verkaufbelegAddAttachment":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegAddAttachmentResponse->ReturnData);
    return $ret;
  }
 
/**
 * verkaufbelegPrintPDF -- liefert einen Verkaufbeleg als PDF
 * @param[in] Verkaufbeleg_ID, DruckformularName, MarkAsPrinted
 * @return moAPIverkauf , ($ret->GetContent() liefert Datentyp VerkaufbelegPrintItem)
*/
  public static function verkaufbelegPrintPDF($Verkaufbeleg_ID, $DruckformularName, $MarkAsPrinted){
    $json_content = self::connectMO('{"verkaufbelegPrintPDF":{"Verkaufbeleg_ID":"' . $Verkaufbeleg_ID . '", "DruckformularName":"' . $DruckformularName . '", "MarkAsPrinted":"' . $MarkAsPrinted . '"}}');
    $ret = new moAPIverkauf($json_content->verkaufbelegPrintPDFResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Einkaufsbelege</b>
 */
class moAPIeinkauf extends moAPIHandlerBase {
 
/**
 * einkaufbelegFilterTemplate -- Vorlage für Einkaufbeleg-Filter
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegFilter)
*/
  public static function einkaufbelegFilterTemplate(){
    $json_content = self::connectMO('{"einkaufbelegFilterTemplate":""}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegList -- Auflistung Einkaufbelege
 * @param[in] EinkaufbelegFilter (Datenstruktur) 
 * @return moAPIeinkauf , (GetContent() liefert Array vom Datentyp EinkaufbelegListitem)
*/
  public static function einkaufbelegList($EinkaufbelegFilter){
    $json_content = self::connectMO('{"einkaufbelegList":'.self::decodeParameter($EinkaufbelegFilter).'}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegListResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegGet -- Liefert Details eines Einkaufbeleg
 * @param[in] Einkaufbeleg_ID
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegItem)
*/
  public static function einkaufbelegGet($Einkaufbeleg_ID){
    $json_content = self::connectMO('{"einkaufbelegGet":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '"}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegTemplate -- liefert EinkaufbelegAddItem als Vorlage
 * @param[in] EinkaufbelegArt, Adresse_ID, ArtikelAddPostenList (Datenstruktur) 
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegAddItem)
*/
  public static function einkaufbelegTemplate($EinkaufbelegArt, $Adresse_ID, $ArtikelAddPostenList){
    $json_content = self::connectMO('{"einkaufbelegTemplate":{"EinkaufbelegArt":"' . $EinkaufbelegArt . '", "Adresse_ID":"' . $Adresse_ID . '", '.self::decodeParameter($ArtikelAddPostenList).'}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegDuplikatTemplate -- Vorlage für einen duplizierten Einkaufbeleg
 * @param[in] Einkaufbeleg_ID, Adresse_ID
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegAddItem)
*/
  public static function einkaufbelegDuplikatTemplate($Einkaufbeleg_ID, $Adresse_ID){
    $json_content = self::connectMO('{"einkaufbelegDuplikatTemplate":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", "Adresse_ID":"' . $Adresse_ID . '"}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegDuplikatTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegWeiterleitungTemplate -- Vorlage für einen weitergeleiteten Einkaufbeleg
 * @param[in] Einkaufbeleg_ID, EinkaufbelegArt
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegAddItem)
*/
  public static function einkaufbelegWeiterleitungTemplate($Einkaufbeleg_ID, $EinkaufbelegArt){
    $json_content = self::connectMO('{"einkaufbelegWeiterleitungTemplate":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", "EinkaufbelegArt":"' . $EinkaufbelegArt . '"}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegWeiterleitungTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegPositionTemplate -- liefert EinkaufbelegPositionAddItem als Vorlage
 * @param[in] Artikel_ID, Adresse_ID, Artikelmenge
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegPositionAddItem)
*/
  public static function einkaufbelegPositionTemplate($Artikel_ID, $Adresse_ID, $Artikelmenge){
    $json_content = self::connectMO('{"einkaufbelegPositionTemplate":{"Artikel_ID":"' . $Artikel_ID . '", "Adresse_ID":"' . $Adresse_ID . '", "Artikelmenge":"' . $Artikelmenge . '"}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegPositionTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegPreview -- berechnet einen Einkaufbeleg ohne zu sichern
 * @param[in] EinkaufbelegAddItem (Datenstruktur) 
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegItem)
*/
  public static function einkaufbelegPreview($EinkaufbelegAddItem){
    $json_content = self::connectMO('{"einkaufbelegPreview":'.self::decodeParameter($EinkaufbelegAddItem).'}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegPreviewResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegAdd -- fügt einen neuen Einkaufbeleg hinzu
 * @param[in] EinkaufbelegAddItem (Datenstruktur) 
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function einkaufbelegAdd($EinkaufbelegAddItem){
    $json_content = self::connectMO('{"einkaufbelegAdd":'.self::decodeParameter($EinkaufbelegAddItem).'}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegWeiterleitung -- fügt einen weitergeleiteten Einkaufbeleg hinzu
 * @param[in] EinkaufbelegAddItem (Datenstruktur) 
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function einkaufbelegWeiterleitung($EinkaufbelegAddItem){
    $json_content = self::connectMO('{"einkaufbelegWeiterleitung":'.self::decodeParameter($EinkaufbelegAddItem).'}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegWeiterleitungResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegDelete -- löscht einen Einkaufbeleg
 * @param[in] Einkaufbeleg_ID
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function einkaufbelegDelete($Einkaufbeleg_ID){
    $json_content = self::connectMO('{"einkaufbelegDelete":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '"}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegAddAttachment -- fügt ein Attachment einem Einkaufbeleg hinzu
 * @param[in] Einkaufbeleg_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function einkaufbelegAddAttachment($Einkaufbeleg_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"einkaufbelegAddAttachment":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegAddAttachmentResponse->ReturnData);
    return $ret;
  }
 
/**
 * einkaufbelegPrintPDF -- liefert einen Einkaufbeleg als PDF
 * @param[in] Einkaufbeleg_ID, DruckformularName, MarkAsPrinted
 * @return moAPIeinkauf , ($ret->GetContent() liefert Datentyp EinkaufbelegPrintItem)
*/
  public static function einkaufbelegPrintPDF($Einkaufbeleg_ID, $DruckformularName, $MarkAsPrinted){
    $json_content = self::connectMO('{"einkaufbelegPrintPDF":{"Einkaufbeleg_ID":"' . $Einkaufbeleg_ID . '", "DruckformularName":"' . $DruckformularName . '", "MarkAsPrinted":"' . $MarkAsPrinted . '"}}');
    $ret = new moAPIeinkauf($json_content->einkaufbelegPrintPDFResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Buchungen</b>
 */
class moAPIbuchungen extends moAPIHandlerBase {
 
/**
 * buchungFilterTemplate -- Vorlage für Buchung-Filter
 * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp BuchungFilter)
*/
  public static function buchungFilterTemplate(){
    $json_content = self::connectMO('{"buchungFilterTemplate":""}');
    $ret = new moAPIbuchungen($json_content->buchungFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * buchungList -- Listet alle Buchungen
 * @param[in] BuchungFilter (Datenstruktur) 
 * @return moAPIbuchungen , (GetContent() liefert Array vom Datentyp BuchungListItem)
*/
  public static function buchungList($BuchungFilter){
    $json_content = self::connectMO('{"buchungList":'.self::decodeParameter($BuchungFilter).'}');
    $ret = new moAPIbuchungen($json_content->buchungListResponse->ReturnData);
    return $ret;
  }
 
/**
 * buchungGet -- Liefert Eigenschaften einer Buchung
 * @param[in] Buchung_ID
 * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp BuchungItem)
*/
  public static function buchungGet($Buchung_ID){
    $json_content = self::connectMO('{"buchungGet":{"Buchung_ID":"' . $Buchung_ID . '"}}');
    $ret = new moAPIbuchungen($json_content->buchungGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * buchungTemplate -- liefert BuchungAddItem als Vorlage
 * @param[in] PositionenAnzahl
 * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp BuchungAddItem)
*/
  public static function buchungTemplate($PositionenAnzahl){
    $json_content = self::connectMO('{"buchungTemplate":{"PositionenAnzahl":"' . $PositionenAnzahl . '"}}');
    $ret = new moAPIbuchungen($json_content->buchungTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * buchungAdd -- fügt neue Buchung hinzu
 * @param[in] BuchungAddItem (Datenstruktur) 
 * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function buchungAdd($BuchungAddItem){
    $json_content = self::connectMO('{"buchungAdd":'.self::decodeParameter($BuchungAddItem).'}');
    $ret = new moAPIbuchungen($json_content->buchungAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * buchungAddAttachment -- fügt ein Attachment einer Buchung hinzu
 * @param[in] Buchung_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIbuchungen , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function buchungAddAttachment($Buchung_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"buchungAddAttachment":{"Buchung_ID":"' . $Buchung_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIbuchungen($json_content->buchungAddAttachmentResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Debitoren</b>
 */
class moAPIdebitoren extends moAPIHandlerBase {
 
/**
 * debitorenRechnungFilterTemplate -- Vorlage für Filter Debitorenrechnungen
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungFilter)
*/
  public static function debitorenRechnungFilterTemplate(){
    $json_content = self::connectMO('{"debitorenRechnungFilterTemplate":""}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenRechnungList -- Auflistung Debitorenrechnungen
 * @param[in] DebitorenRechnungFilter (Datenstruktur) 
 * @return moAPIdebitoren , (GetContent() liefert Array vom Datentyp DebitorenRechnungListItem)
*/
  public static function debitorenRechnungList($DebitorenRechnungFilter){
    $json_content = self::connectMO('{"debitorenRechnungList":'.self::decodeParameter($DebitorenRechnungFilter).'}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungListResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenRechnungGet -- Liefert Details einer Debitorenrechnung
 * @param[in] Posten_ID
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungItem)
*/
  public static function debitorenRechnungGet($Posten_ID){
    $json_content = self::connectMO('{"debitorenRechnungGet":{"Posten_ID":"' . $Posten_ID . '"}}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenRechnungTemplate -- liefert DebitorenRechnungAddItem als Vorlage
 * @param[in] Adresse_ID, Datum, PositionenAnzahl
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungAddItem)
*/
  public static function debitorenRechnungTemplate($Adresse_ID, $Datum, $PositionenAnzahl){
    $json_content = self::connectMO('{"debitorenRechnungTemplate":{"Adresse_ID":"' . $Adresse_ID . '", "Datum":"' . $Datum . '", "PositionenAnzahl":"' . $PositionenAnzahl . '"}}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenRechnungPreview -- berechnet eine neue Debitorenrechnung, ohne speichern
 * @param[in] DebitorenRechnungAddItem (Datenstruktur) 
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenRechnungItem)
*/
  public static function debitorenRechnungPreview($DebitorenRechnungAddItem){
    $json_content = self::connectMO('{"debitorenRechnungPreview":'.self::decodeParameter($DebitorenRechnungAddItem).'}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungPreviewResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenRechnungAdd -- fügt eine neue Debitorenrechnung hinzu
 * @param[in] DebitorenRechnungAddItem (Datenstruktur) 
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function debitorenRechnungAdd($DebitorenRechnungAddItem){
    $json_content = self::connectMO('{"debitorenRechnungAdd":'.self::decodeParameter($DebitorenRechnungAddItem).'}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenRechnungDelete -- löscht eine vorhandene Debitorenrechnung
 * @param[in] Posten_ID
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function debitorenRechnungDelete($Posten_ID){
    $json_content = self::connectMO('{"debitorenRechnungDelete":{"Posten_ID":"' . $Posten_ID . '"}}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenRechnungAddAttachment -- fügt ein Attachment einer Debitorenrechnung hinzu
 * @param[in] Posten_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function debitorenRechnungAddAttachment($Posten_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"debitorenRechnungAddAttachment":{"Posten_ID":"' . $Posten_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIdebitoren($json_content->debitorenRechnungAddAttachmentResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenZahlungFilterTemplate -- Vorlage für Filter Debitorenzahlungen
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenZahlungFilter)
*/
  public static function debitorenZahlungFilterTemplate(){
    $json_content = self::connectMO('{"debitorenZahlungFilterTemplate":""}');
    $ret = new moAPIdebitoren($json_content->debitorenZahlungFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenZahlungList -- Auflistung Debitorenzahlungen
 * @param[in] DebitorenZahlungFilter (Datenstruktur) 
 * @return moAPIdebitoren , (GetContent() liefert Array vom Datentyp DebitorenZahlungListItem)
*/
  public static function debitorenZahlungList($DebitorenZahlungFilter){
    $json_content = self::connectMO('{"debitorenZahlungList":'.self::decodeParameter($DebitorenZahlungFilter).'}');
    $ret = new moAPIdebitoren($json_content->debitorenZahlungListResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenZahlungGet -- Liefert Details einer Debitorenzahlung
 * @param[in] Zahlung_ID
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp DebitorenZahlungItem)
*/
  public static function debitorenZahlungGet($Zahlung_ID){
    $json_content = self::connectMO('{"debitorenZahlungGet":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');
    $ret = new moAPIdebitoren($json_content->debitorenZahlungGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenZahlungCreate -- erzeugt Zahlung für Debitorenrechnung
 * @param[in] Posten_ID, Datum, Konto, Zahlungsart (Datenstruktur) 
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function debitorenZahlungCreate($Posten_ID, $Datum, $Konto, $Zahlungsart){
    $json_content = self::connectMO('{"debitorenZahlungCreate":{"Posten_ID":"' . $Posten_ID . '", "Datum":"' . $Datum . '", "Konto":"' . $Konto . '", '.self::decodeParameter($Zahlungsart).'}}');
    $ret = new moAPIdebitoren($json_content->debitorenZahlungCreateResponse->ReturnData);
    return $ret;
  }
 
/**
 * debitorenZahlungDelete -- löscht eine vorhandene Debitorenzahlung
 * @param[in] Zahlung_ID
 * @return moAPIdebitoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function debitorenZahlungDelete($Zahlung_ID){
    $json_content = self::connectMO('{"debitorenZahlungDelete":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');
    $ret = new moAPIdebitoren($json_content->debitorenZahlungDeleteResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Kreditoren</b>
 */
class moAPIkreditoren extends moAPIHandlerBase {
 
/**
 * kreditorenRechnungFilterTemplate -- Vorlage für Filter Kreditorenrechnungen
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungFilter)
*/
  public static function kreditorenRechnungFilterTemplate(){
    $json_content = self::connectMO('{"kreditorenRechnungFilterTemplate":""}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenRechnungList -- Auflistung Kreditorenrechnungen
 * @param[in] KreditorenRechnungFilter (Datenstruktur) 
 * @return moAPIkreditoren , (GetContent() liefert Array vom Datentyp KreditorenRechnungListItem)
*/
  public static function kreditorenRechnungList($KreditorenRechnungFilter){
    $json_content = self::connectMO('{"kreditorenRechnungList":'.self::decodeParameter($KreditorenRechnungFilter).'}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungListResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenRechnungGet -- Liefert Details einer Kreditorenrechnung
 * @param[in] Posten_ID
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungItem)
*/
  public static function kreditorenRechnungGet($Posten_ID){
    $json_content = self::connectMO('{"kreditorenRechnungGet":{"Posten_ID":"' . $Posten_ID . '"}}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenRechnungTemplate -- liefert KreditorenRechnungAddItem als Vorlage
 * @param[in] Adresse_ID, Datum, PositionenAnzahl
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungAddItem)
*/
  public static function kreditorenRechnungTemplate($Adresse_ID, $Datum, $PositionenAnzahl){
    $json_content = self::connectMO('{"kreditorenRechnungTemplate":{"Adresse_ID":"' . $Adresse_ID . '", "Datum":"' . $Datum . '", "PositionenAnzahl":"' . $PositionenAnzahl . '"}}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenRechnungPreview -- berechnet eine neue Kreditorenrechnung, ohne speichern
 * @param[in] KreditorenRechnungAddItem (Datenstruktur) 
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenRechnungItem)
*/
  public static function kreditorenRechnungPreview($KreditorenRechnungAddItem){
    $json_content = self::connectMO('{"kreditorenRechnungPreview":'.self::decodeParameter($KreditorenRechnungAddItem).'}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungPreviewResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenRechnungAdd -- fügt eine neue Kreditorenrechnung hinzu
 * @param[in] KreditorenRechnungAddItem (Datenstruktur) 
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function kreditorenRechnungAdd($KreditorenRechnungAddItem){
    $json_content = self::connectMO('{"kreditorenRechnungAdd":'.self::decodeParameter($KreditorenRechnungAddItem).'}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungAddResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenRechnungDelete -- löscht eine vorhandene Kreditorenrechnung
 * @param[in] Posten_ID
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function kreditorenRechnungDelete($Posten_ID){
    $json_content = self::connectMO('{"kreditorenRechnungDelete":{"Posten_ID":"' . $Posten_ID . '"}}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungDeleteResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenRechnungAddAttachment -- fügt ein Attachment einer Kreditorenrechnung hinzu
 * @param[in] Posten_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function kreditorenRechnungAddAttachment($Posten_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"kreditorenRechnungAddAttachment":{"Posten_ID":"' . $Posten_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIkreditoren($json_content->kreditorenRechnungAddAttachmentResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenZahlungFilterTemplate -- Vorlage für Filter Kreditorenzahlungen
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenZahlungFilter)
*/
  public static function kreditorenZahlungFilterTemplate(){
    $json_content = self::connectMO('{"kreditorenZahlungFilterTemplate":""}');
    $ret = new moAPIkreditoren($json_content->kreditorenZahlungFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenZahlungList -- Auflistung Kreditorenzahlungen
 * @param[in] KreditorenZahlungFilter (Datenstruktur) 
 * @return moAPIkreditoren , (GetContent() liefert Array vom Datentyp KreditorenZahlungListItem)
*/
  public static function kreditorenZahlungList($KreditorenZahlungFilter){
    $json_content = self::connectMO('{"kreditorenZahlungList":'.self::decodeParameter($KreditorenZahlungFilter).'}');
    $ret = new moAPIkreditoren($json_content->kreditorenZahlungListResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenZahlungGet -- Liefert Details einer Kreditorenzahlung
 * @param[in] Zahlung_ID
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp KreditorenZahlungItem)
*/
  public static function kreditorenZahlungGet($Zahlung_ID){
    $json_content = self::connectMO('{"kreditorenZahlungGet":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');
    $ret = new moAPIkreditoren($json_content->kreditorenZahlungGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenZahlungCreate -- erzeugt Zahlung für Kreditorenrechnung
 * @param[in] Posten_ID, Datum, Konto, Zahlungsart (Datenstruktur) 
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function kreditorenZahlungCreate($Posten_ID, $Datum, $Konto, $Zahlungsart){
    $json_content = self::connectMO('{"kreditorenZahlungCreate":{"Posten_ID":"' . $Posten_ID . '", "Datum":"' . $Datum . '", "Konto":"' . $Konto . '", '.self::decodeParameter($Zahlungsart).'}}');
    $ret = new moAPIkreditoren($json_content->kreditorenZahlungCreateResponse->ReturnData);
    return $ret;
  }
 
/**
 * kreditorenZahlungDelete -- löscht eine vorhandene Kreditorenzahlung
 * @param[in] Zahlung_ID
 * @return moAPIkreditoren , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function kreditorenZahlungDelete($Zahlung_ID){
    $json_content = self::connectMO('{"kreditorenZahlungDelete":{"Zahlung_ID":"' . $Zahlung_ID . '"}}');
    $ret = new moAPIkreditoren($json_content->kreditorenZahlungDeleteResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Offene Posten</b>
 */
class moAPIoffenePosten extends moAPIHandlerBase {
 
/**
 * offenePostenFilterTemplate -- Vorlage für Offene Posten-Filter
 * @return moAPIoffenePosten , ($ret->GetContent() liefert Datentyp OffenePostenFilter)
*/
  public static function offenePostenFilterTemplate(){
    $json_content = self::connectMO('{"offenePostenFilterTemplate":""}');
    $ret = new moAPIoffenePosten($json_content->offenePostenFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * offenePostenListDebitoren -- Auflistung offener Posten Debitoren
 * @param[in] OffenePostenFilter (Datenstruktur) 
 * @return moAPIoffenePosten , (GetContent() liefert Array vom Datentyp OffenePostenListItem)
*/
  public static function offenePostenListDebitoren($OffenePostenFilter){
    $json_content = self::connectMO('{"offenePostenListDebitoren":'.self::decodeParameter($OffenePostenFilter).'}');
    $ret = new moAPIoffenePosten($json_content->offenePostenListDebitorenResponse->ReturnData);
    return $ret;
  }
 
/**
 * offenePostenListKreditoren -- Auflistung offener Posten Kreditoren
 * @param[in] OffenePostenFilter (Datenstruktur) 
 * @return moAPIoffenePosten , (GetContent() liefert Array vom Datentyp OffenePostenListItem)
*/
  public static function offenePostenListKreditoren($OffenePostenFilter){
    $json_content = self::connectMO('{"offenePostenListKreditoren":'.self::decodeParameter($OffenePostenFilter).'}');
    $ret = new moAPIoffenePosten($json_content->offenePostenListKreditorenResponse->ReturnData);
    return $ret;
  }
 
/**
 * offenePostenGet -- Liefert Details eines Posten
 * @param[in] Posten_ID
 * @return moAPIoffenePosten , ($ret->GetContent() liefert Datentyp OffenePostenItem)
*/
  public static function offenePostenGet($Posten_ID){
    $json_content = self::connectMO('{"offenePostenGet":{"Posten_ID":"' . $Posten_ID . '"}}');
    $ret = new moAPIoffenePosten($json_content->offenePostenGetResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Projekte</b>
 */
class moAPIprojekte extends moAPIHandlerBase {
 
/**
 * projektFilterTemplate -- Vorlage für Projekt-Filter
 * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ProjektFilter)
*/
  public static function projektFilterTemplate(){
    $json_content = self::connectMO('{"projektFilterTemplate":""}');
    $ret = new moAPIprojekte($json_content->projektFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * projektList -- Listet vorhandene Projekte
 * @param[in] ProjektFilter (Datenstruktur) 
 * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ProjektListItem)
*/
  public static function projektList($ProjektFilter){
    $json_content = self::connectMO('{"projektList":'.self::decodeParameter($ProjektFilter).'}');
    $ret = new moAPIprojekte($json_content->projektListResponse->ReturnData);
    return $ret;
  }
 
/**
 * projektGet -- Liefert ein Projekt für die ID
 * @param[in] Projekt_ID
 * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ProjektItem)
*/
  public static function projektGet($Projekt_ID){
    $json_content = self::connectMO('{"projektGet":{"Projekt_ID":"' . $Projekt_ID . '"}}');
    $ret = new moAPIprojekte($json_content->projektGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * projektAddAttachment -- fügt ein Attachment einem Projekt hinzu
 * @param[in] Projekt_ID, AttachmentAddItem (Datenstruktur) 
 * @return moAPIprojekte , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function projektAddAttachment($Projekt_ID, $AttachmentAddItem){
    $json_content = self::connectMO('{"projektAddAttachment":{"Projekt_ID":"' . $Projekt_ID . '", '.self::decodeParameter($AttachmentAddItem).'}}');
    $ret = new moAPIprojekte($json_content->projektAddAttachmentResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für Attachment-Verwaltung</b>
 */
class moAPIattachment extends moAPIHandlerBase {
 
/**
 * attachmentFilterTemplate -- Vorlage für Attachment-Filter
 * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentFilter)
*/
  public static function attachmentFilterTemplate(){
    $json_content = self::connectMO('{"attachmentFilterTemplate":""}');
    $ret = new moAPIattachment($json_content->attachmentFilterTemplateResponse->ReturnData);
    return $ret;
  }
 
/**
 * attachmentList -- listet vorhandenen Attachments
 * @param[in] AttachmentFilter (Datenstruktur) 
 * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentListItem)
*/
  public static function attachmentList($AttachmentFilter){
    $json_content = self::connectMO('{"attachmentList":'.self::decodeParameter($AttachmentFilter).'}');
    $ret = new moAPIattachment($json_content->attachmentListResponse->ReturnData);
    return $ret;
  }
 
/**
 * attachmentGet -- Liefert Details eines Attachments
 * @param[in] Attachment_ID
 * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentItem)
*/
  public static function attachmentGet($Attachment_ID){
    $json_content = self::connectMO('{"attachmentGet":{"Attachment_ID":"' . $Attachment_ID . '"}}');
    $ret = new moAPIattachment($json_content->attachmentGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * attachmentLoad -- Download Attachment-File. Die Daten des Dokuments sind als Base64 codiert
 * @param[in] Attachment_ID
 * @return moAPIattachment , ($ret->GetContent() liefert Datentyp AttachmentItemData)
*/
  public static function attachmentLoad($Attachment_ID){
    $json_content = self::connectMO('{"attachmentLoad":{"Attachment_ID":"' . $Attachment_ID . '"}}');
    $ret = new moAPIattachment($json_content->attachmentLoadResponse->ReturnData);
    return $ret;
  }
 
/**
 * attachmentDelete -- löscht ein Attachment
 * @param[in] Attachment_ID
 * @return moAPIattachment , ($ret->GetContent() liefert Datentyp ReturnStatus)
*/
  public static function attachmentDelete($Attachment_ID){
    $json_content = self::connectMO('{"attachmentDelete":{"Attachment_ID":"' . $Attachment_ID . '"}}');
    $ret = new moAPIattachment($json_content->attachmentDeleteResponse->ReturnData);
    return $ret;
  }
}
/**
 * <b>Zugriffsmodul für API Information</b>
 */
class moAPIapiinfo extends moAPIHandlerBase {
 
/**
 * apiInfoGet -- Infos zum aktuellenAPI
 * @return moAPIapiinfo , ($ret->GetContent() liefert Datentyp apiInfoItem)
*/
  public static function apiInfoGet(){
    $json_content = self::connectMO('{"apiInfoGet":""}');
    $ret = new moAPIapiinfo($json_content->apiInfoGetResponse->ReturnData);
    return $ret;
  }
 
/**
 * apisessionInfoGet -- Infos zur aktuellen Session
 * @return moAPIapiinfo , ($ret->GetContent() liefert Datentyp apisessionInfoItem)
*/
  public static function apisessionInfoGet(){
    $json_content = self::connectMO('{"apisessionInfoGet":""}');
    $ret = new moAPIapiinfo($json_content->apisessionInfoGetResponse->ReturnData);
    return $ret;
  }
}
?>


