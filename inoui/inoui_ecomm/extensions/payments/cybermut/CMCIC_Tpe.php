<?php

namespace app\extensions\payments\cybermut;

/*****************************************************************************
*
* Classe / Class : CMCIC_Tpe
*
*****************************************************************************/

class CMCIC_Tpe {


	public $sVersion;	// Version du TPE - TPE Version (Ex : 3.0)
	public $sNumero;	// Numero du TPE - TPE Number (Ex : 1234567)
	public $sCodeSociete;	// Code Societe - Company code (Ex : companyname)
	public $sLangue;	// Langue - Language (Ex : FR, DE, EN, ..)
	public $sUrlOK;		// Url de retour OK - Return URL OK
	public $sUrlKO;		// Url de retour KO - Return URL KO
	public $sUrlPaiement;	// Url du serveur de paiement - Payment Server URL (Ex : https://paiement.creditmutuel.fr/paiement.cgi)
	private $_sCle;		// La clé - The Key
	

	// ----------------------------------------------------------------------------
	//
	// Constructeur / Constructor
	//
	// ----------------------------------------------------------------------------
	
	function __construct(array $options = array()) {

		$this->sVersion = $options['CMCIC_VERSION'];
		$this->_sCle = $options['CMCIC_CLE'];
		$this->sNumero = $options['CMCIC_TPE'];
		$this->sUrlPaiement = $options['CMCIC_SERVEUR'];

		$this->sCodeSociete = $options['CMCIC_CODESOCIETE'];
		$this->sLangue = $options['LANG'];

		$this->sUrlOK = $options['CMCIC_URLOK'];
		$this->sUrlKO = $options['CMCIC_URLKO'];

	}

	// ----------------------------------------------------------------------------
	//
	// Fonction / Function : getCle
	//
	// Renvoie la clé du TPE / return the TPE Key
	//
	// ----------------------------------------------------------------------------

	public function getCle() {

		return $this->_sCle;
	}

}



// ----------------------------------------------------------------------------
// function getMethode 
//
// IN: 
// OUT: Données soumises par GET ou POST / Data sent by GET or POST
// description: Renvoie le tableau des données / Send back the data array
// ----------------------------------------------------------------------------

function getMethode()
{
    if ($_SERVER["REQUEST_METHOD"] == "GET")  
        return $_GET; 

    if ($_SERVER["REQUEST_METHOD"] == "POST")
	return $_POST;

    die ('Invalid REQUEST_METHOD (not GET, not POST).');
}

// ----------------------------------------------------------------------------
// function HtmlEncode
//
// IN:  chaine a encoder / String to encode
// OUT: Chaine encodée / Encoded string
//
// Description: Encode special characters under HTML format
//                           ********************
//              Encodage des caractères spéciaux au format HTML
// ----------------------------------------------------------------------------
function HtmlEncode ($data)
{
    $SAFE_OUT_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890._-";
    $encoded_data = "";
    $result = "";
    for ($i=0; $i<strlen($data); $i++)
    {
        if (strchr($SAFE_OUT_CHARS, $data{$i})) {
            $result .= $data{$i};
        }
        else if (($var = bin2hex(substr($data,$i,1))) <= "7F"){
            $result .= "&#x" . $var . ";";
        }
        else
            $result .= $data{$i};
            
    }
    return $result;
}
?>