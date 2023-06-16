<?php

namespace Modules\Icommercecredibanco\Entities;

class Credibanco
{
    private $_acquirerId;

    private $_merchantId;

    private $_terminalCode;

    private $_xmlReq;

    private $_digitalLSign;

    private $_sessionKey;

    private $_url_action;

    private $_description;

    private $_htmlFormCode;

    private $_htmlCode;

    private $_setNameForm;

    public function __construct($description = '')
    {
        $this->setDescription($description);
    }

    public function setAcquirerId($acquirerId)
    {
        $this->_acquirerId = $acquirerId;
    }

    public function setMerchantid($merchantid)
    {
        $this->_merchantId = $merchantid;
    }

    public function setTerminalCode($terminalCode)
    {
        $this->_terminalCode = $terminalCode;
    }

    public function setXmlReq($xmlReq)
    {
        $this->_xmlReq = $xmlReq;
    }

    public function setDigitalSign($digitalSign)
    {
        $this->_digitalLSign = $digitalSign;
    }

    public function setSessionKey($sessionKey)
    {
        $this->_sessionKey = $sessionKey;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function setUrlgate($url)
    {
        $this->_url_action = $url;
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
        $this->_htmlFormCode .= $this->_addInput('IDACQUIRER', $this->_acquirerId);
        $this->_htmlFormCode .= $this->_addInput('IDCOMMERCE', $this->_merchantId);
        $this->_htmlFormCode .= $this->_addInput('TERMINALCODE', $this->_terminalCode);
        $this->_htmlFormCode .= $this->_addInput('XMLREQ', $this->_xmlReq);
        $this->_htmlFormCode .= $this->_addInput('DIGITALSIGN', $this->_digitalLSign);
        $this->_htmlFormCode .= $this->_addInput('SESSIONKEY', $this->_sessionKey);
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

        $this->_makeFields();
        $this->_makeForm();

        return $this->_htmlCode;
    }

    public function executeRedirection()
    {
        echo $this->renderPaymentForm();
        echo '<script>document.forms["'.$this->_setNameForm.'"].submit();</script>';

        //dd($this->renderPaymentForm());
    }
}
