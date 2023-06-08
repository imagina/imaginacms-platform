<?php

namespace Modules\Icommerceepayco\Entities;

use Illuminate\Database\Eloquent\Model;

class Epayco
{

	  private $urlAction; 
  	private $publicKey;
    private $currency;
  	private $referenceCode;
  	private $amount;
  	private $redirectUrl;
  	
  	private $_htmlFormCode;
  	private $_htmlCode;
  	private $nameForm;

  	function __construct($url='',$publicKey='',$referenceCode='',$amount=0,$currency='',$redirectUrl=''){

        $this->setReferenceCode($referenceCode);
        $this->setAmount($amount);
        $this->setPublicKey($publicKey);
        $this->setUrlgate($url);
        $this->setCurrency($currency);
        $this->setRedirectUrl($redirectUrl);
  
  }

  public function setUrlgate($url){
    $this->urlAction=$url;
  }

  public function setPublicKey($publicKey){
    $this->publicKey = $publicKey;
  }

  public function setCurrency($currency){
    $this->currency = $currency;
  }

  public function setReferenceCode($referenceCode){
  	    $this->referenceCode = $referenceCode;
  }

  /**
  * Amount in Cents
  */
  public function setAmount($amount){
  	   $this->amount = $amount * 100;
  }
  
  public function setRedirectUrl($redirectUrl){
  	   $this->redirectUrl =$redirectUrl;
  }

  /**
  * FORM - Set Form Name
  */
  public function setNameForm($name = 'payForm')
  {
        $this->nameForm = $name;
  }

  /**
  * FORM - Add input
  */
  private function _addInput($string, $value)
  {
        return '<input type="hidden" name="' .$string. '" value="' . htmlentities($value, ENT_COMPAT, 'UTF-8') . '"/>' . "\n";
  }

  /**
  * FORM - Add make fields
  */
  public function _makeFields(){
  
    $this->_htmlFormCode.=$this->_addInput('public-key',$this->publicKey);
    $this->_htmlFormCode.=$this->_addInput('currency',$this->currency);
    $this->_htmlFormCode.=$this->_addInput('amount-in-cents',$this->amount);
		$this->_htmlFormCode.=$this->_addInput('reference',$this->referenceCode);
    $this->_htmlFormCode.=$this->_addInput('redirect-url',$this->redirectUrl);

  }
  
  /**
  * FORM - Make Form
  */
  private function _makeForm()
  {
        $this->_htmlCode .= '<form action="' . $this->urlAction . '" method="GET" id="'.$this->nameForm.'" name="'.$this->nameForm.'"/>' . "\n";
        $this->_htmlCode .=$this->_htmlFormCode;

  }
 
  /**
  * FORM - Render
  */
  public function renderPaymentForm()
  {
  		$this->setNameForm();

      $time = time();
      error_log("---Payment page sampledan gelen loglar---".$time,0);

      $this->_makeFields();
      $this->_makeForm();

      return $this->_htmlCode;
  }

  /**
  * Execute Redirection
  */
  public function executeRedirection($config)
  {

    $cssBtn ='<style>.epayco-button-render{display:none;} </style>';

    $formInit = '<form>';

    $formEnd = '</form>';


    $cTest = $config->test ? 'true' : 'false';
    $cAutoClick = $config->autoClick ? 'true' : 'false';

    $script = ' <script
                  src="'.$config->url.'"
                  class="epayco-button"
                  data-epayco-key="'.$config->publicKey.'"
                  data-epayco-amount="'.$config->amount.'"
                  data-epayco-name="'.$config->name.'"
                  data-epayco-description="'.$config->description.'"
                  data-epayco-currency="'.$config->currency.'"
                  data-epayco-country="'.$config->country.'"
                  data-epayco-test="'.$cTest.'"
                  data-epayco-external="true"
                  data-epayco-response="'.$config->responseUrl.'"
                  data-epayco-confirmation="'.$config->confirmationUrl.'"
                  data-epayco-invoice="'.$config->invoice.'"
                  data-epayco-extra1="'.$config->extra1.'"
                  data-epayco-autoclick="'.$cAutoClick.'"
                  >
            </script>';

    $final = $cssBtn."".$formInit."".$script."".$formEnd;

    echo $final;
    /*
    echo $this->renderPaymentForm();
    echo '<script>document.forms["'.$this->nameForm.'"].submit();</script>';
    */

  }
	

}