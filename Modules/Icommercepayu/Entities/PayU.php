<?php

namespace Modules\Icommercepayu\Entities;

class PayU
{
    private $_url_action;

    private $_merchantId; //valor  numerico quitar caracteres y deja solo numeros quitar comillas

    private $_accountId; //valor numerico quitar caracteres y deja solo numeros quitar comillas

    private $_apiKey;

    private $_description;

    private $_referenceCode;

    private $_amount;

    private $_tax; // 0 valor del impuesto asociado a la venta

    private $_taxReturnBase; // 0 valor de devolución del impuesto
    //private $_shipmentValue;

    private $_currency;

    private $_lng; //Idioma en el que se desea mostrar la pasarela de pagos.

    private $_responseUrl; //responseUrl sourceUrl

    private $_confirmationUrl;

    private $_signature;

    private $_test;

    private $_buyerEmail;

    private $_htmlFormCode;

    private $_htmlCode;

    private $_setNameForm;

    public function __construct($accountId = '', $url = '', $apiKey = '', $test = '', $description = '', $referenceCode = '', $amount = '', $tax = '', $taxReturnBase = '', $shipmentValue = '', $currency = '', $lng = '', $responseUrl = '', $buyerEmail = '', $merchantId = '', $confirmationUrl = '')
    {
        $this->setDescription($description);
        $this->setReferenceCode($referenceCode);
        $this->setAmount($amount);
        $this->setBuyerEmail($buyerEmail);
        $this->setTest($test);
        $this->setApikey($apiKey);
        $this->setMerchantid($merchantId);
        $this->setUrlgate($url);
        $this->setAccountid($accountId);
        $this->setCurrency($currency);

        $this->setTax($tax);
        $this->setTaxReturnBase($taxReturnBase);
        //$this->setShipmentValue($shipmentValue);

        $this->setLng($lng);
        $this->setResponseUrl($responseUrl);
        $this->setConfirmationUrl($confirmationUrl);
    }

  public function setBuyerEmail($buyerEmail)
  {
      $this->_buyerEmail = $buyerEmail;
  }

  public function setDescription($description)
  {
      $this->_description = $description;
  }

  public function setReferenceCode($referenceCode)
  {
      $this->_referenceCode = $referenceCode;
  }

  public function setAmount($amount)
  {
      $this->_amount = $amount;
  }

  public function setTax($tax)
  {
      $this->_tax = $tax;
  }

  public function setTaxReturnBase($taxReturnBase)
  {
      $this->_taxReturnBase = $taxReturnBase;
  }

  public function setShipmentValue($shipmentValue)
  {
      $this->_shipmentValue = $shipmentValue;
  }

  public function setCurrency($currency)
  {
      $this->_currency = $currency;
  }

  public function setLng($lng)
  {
      $this->_lng = $lng;
  }

  public function setResponseUrl($responseUrl)
  {
      $this->_responseUrl = $responseUrl;
  }

  public function setConfirmationUrl($confirmationUrl)
  {
      $this->_confirmationUrl = $confirmationUrl;
  }

  public function setTest($test)
  {
      $this->_test = $test;
  }

  public function setApikey($apiKey)
  {
      $this->_apiKey = $apiKey;
  }

  public function setMerchantid($merchantId)
  {
      $this->_merchantId = $merchantId;
  }

  public function setUrlgate($url)
  {
      $this->_url_action = $url;
  }

  public function setAccountid($accountId)
  {
      $this->_accountId = $accountId;
  }

  public function setNameForm($name = 'payForm')
  {
      $this->_setNameForm = $name;
  }

  /**Agregar inputs**/
  private function _addInput($string, $value)
  {
      return '<input type="hidden" name="'.$string.'" value="'.htmlentities($value, ENT_COMPAT, 'UTF-8').'"/>'."\n";
  }

  public function _makeFields()
  {
      $this->_htmlFormCode .= $this->_addInput('merchantId', $this->_merchantId);
      $this->_htmlFormCode .= $this->_addInput('accountId', $this->_accountId);
      $this->_htmlFormCode .= $this->_addInput('description', $this->_description);
      $this->_htmlFormCode .= $this->_addInput('referenceCode', $this->_referenceCode);
      $this->_htmlFormCode .= $this->_addInput('amount', $this->_amount);
      $this->_htmlFormCode .= $this->_addInput('tax', $this->_tax);
      $this->_htmlFormCode .= $this->_addInput('taxReturnBase', $this->_taxReturnBase);
      //$this->_htmlFormCode.=$this->_addInput('shipmentValue',$this->_shipmentValue);

      $this->_htmlFormCode .= $this->_addInput('currency', $this->_currency);
      $this->_htmlFormCode .= $this->_addInput('lng', $this->_lng);
      $this->_htmlFormCode .= $this->_addInput('test', $this->_test);
      $this->_htmlFormCode .= $this->_addInput('buyerEmail', $this->_buyerEmail);
      $this->_htmlFormCode .= $this->_addInput('signature', $this->_signature);

      $this->_htmlFormCode .= $this->_addInput('responseUrl', $this->_responseUrl);

      $this->_htmlFormCode .= $this->_addInput('confirmationUrl', $this->_confirmationUrl);
  }

  private function _makeForm()
  {
      $this->_htmlCode .= '<form action="'.$this->_url_action.'" method="POST" id="'.$this->_setNameForm.'" name="'.$this->_setNameForm.'"/>'."\n";
      $this->_htmlCode .= $this->_htmlFormCode;
  }

  public function renderPaymentForm()
  {
      $this->setNameForm();

      $time = time();
      error_log('---Payment page sampledan gelen loglar---'.$time, 0);

      $this->setSignature();
      $this->_makeFields();
      $this->_makeForm();

      return $this->_htmlCode;
  }

  public function setSignature()
  {
      $this->_signature = md5($this->_apiKey.'~'.$this->_merchantId.'~'.$this->_referenceCode.'~'.$this->_amount.'~'.$this->_currency);
  }

  public function executeRedirection()
  {
      echo $this->renderPaymentForm();
      //exit;
      echo '<script>document.forms["'.$this->_setNameForm.'"].submit();</script>';
  }
}
