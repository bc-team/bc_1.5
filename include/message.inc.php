<?php
Class Message {
	
	private static $instance;
	
	public static function getInstance()
	{
	      $config = Config::getInstance()->getConfigurations();
		if(!isset(self::$instance))
		{
			self::$instance=new Message($config['language']);
		}
		return self::$instance;
	}
	
	var $messages = Array(
			"it" => Array(
					"000" => "Attenzione",
					"001" => "Sei Sicuro ?",
					"501" => "Non ci sono elementi",
					"601" => "vuoto",
					"602" => "rimuovi",
					"701" => "Attenzione: inserire {label} !",
					"702" => "Sei Sicura/o ?",
					"703" => "Attenzione: selezionare {label} !",
					"704" => "Indicare il motivo del rigetto della pubblicazione !",
					"705" => "Attenzione: selezionare {label} !",
					"706" => "Attenzione: selezionare almeno un {label} !",
					"707" => "Attenzione: inserire o selezionare {label} !",
					"708" => "Attenzione: tipo di file errato per {label} !",
					"709" => "Attenzione: indicate anche ora e minuti per {label} !",
					"801" => "L'inserimento � stato effettuato con successo !",
					"802" => "L'aggiornamento � stato effettuato con successo !",
					"803" => "La cancellazione � avvenuta con successo !",
					"804" => "L'elemento selezionato per la cancellazione non pu� essere rimosso perch� in uso.",
					"900" => "Database: Errore Generico ",
					"901" => "Database: Error in opening database ",
					"902" => "Database: Error in opening connection to database ",
					"903" => "Database: Error in creating table ",
					"904" => "Database: Error in querying ",
					"905" => "Attenzione: la chiave risulta gi� presente, modifica per procedere!",
					"906" => "Attenzione: l'inserimento � annullato perch� la transazione � gi� avvenuta!",
					"907" => "Attenzione: errore in interrogazione query, probabilmente non � stata definita una presentazione (setPresentation) per la tabella ",
					"908" => "Database: entit� specificata nella relazione inesistente",
					"909" => "Attenzione: solo form relative a Relazioni possono essere messe in cascata ",
					"910" => "Attenzione: non � possibile adottare un RelationManager per questo tipo di form ",
					"911" => "Attenzione: si � verificato un errore di inserimento nella relazione ",
					"912" => "Attenzione: operazione non ammissibile, sessione non aperta ",
					"913" => "Attenzione: errore di cancellazione ",
					"914" => "Attezione: il sistema non pu� essere inizializzato ",
					"915" => "Attezione: errore di tipi nell'inizializzazione ",
					"1001" => "Pubblica",
					"1002" => "Rifiuta",
					"1003" => "Aggiungi",
					"1004" => "Modifica",
					"1005" => "Rimuovi",
					"1006" => "Tue/Tuoi",
					"1011" => "<b>Grazie!</b><br><br>L'informazione � stata <u>pubblicata</u> e l'autore verr� informato!",
					"1012" => "<b>Grazie!</b><br><br>L'informazione � stata <u>rifiutata</u> e l'autore verr� informato!",
					"1013" => "<b>Attenzione!</b><br><br>La moderazione � stata gi� processata da un altro Editor!",
					"1101" => "Sempre",
					"1102" => "Batch Selettivo",
					"1103" => "Selettivo",
					"1104" => "RSS enabled",
					"1105" => "RSS enabled"
			),
			"en" => Array(
					"000" => "Warning",
					"001" => "Are you sure ?",
					"501" => "There are no items!",
					"601" => "none",
					"602" => "delete",
					"701" => "Warning: please insert {label} !",
					"702" => "Are you sure ?",
					"703" => "Warning: please select {label} !",
					"704" => "Please specify to the author why this item is rejected !",
					"705" => "Warning: please select {label} !",
					"706" => "Warning: please select at least one {label} !",
					"707" => "Warning: please enter or select {label} !",
					"708" => "Warning: the select file type for {label} is not correct !",
					"709" => "Warning: please enter also the time for {label} !",
					"801" => "The item has been correctly added!",
					"802" => "The item has been correctly updated!",
					"803" => "The item has been removed!",
					"804" => "The deletion cannot take place, because the item you selected is still in use!",
					"900" => "Database: Generic Error ",
					"901" => "Database: Error in opening database ",
					"902" => "Database: Error in opening connection to database ",
					"903" => "Database: Error in creating table ",
					"904" => "Database: Error in querying ",
					"905" => "Warning: duplicate key, enter another value to proceed!",
					"906" => "Warning: transaction cannot take place since already executed!",
					"907" => "Warning: error in querying, likely a presentation has been not defined for table ",
					"908" => "Database: unknown entity in the specified relation",
					"909" => "Warning: only Relation-based form can be in cascade triggered ",
					"910" => "Warning: a RelationManager object cannot be used for this form ",
					"911" => "Warning: an error occourred while inserting tuples into the relation ",
					"912" => "Warning: the operation is not allowed as the session has been not created ",
					"913" => "Warning: error in deletion ",
					"914" => "Warning: the system cannot be bootstrapped ",
					"915" => "Warning: likely a datatype error occurred in the initialization, eg. INT requires 0 valued field if bank is intended ",
					"1001" => "Publish",
					"1002" => "Reject",
					"1002" => "Rifiuta",
					"1003" => "Add",
					"1004" => "Save",
					"1005" => "Delete",
					"1006" => "Your",
					"1011" => "<b>Thank you!</b><br><br>The content has been <u>published</u>, the author is going to be informed!",
					"1012" => "<b>Thank you!</b><br><br>The content has been <u>rejected</u> and the author is going to be informed!",
					"1013" => "<b>Warning!</b><br><br>The content has been already validated by another Editor!",
					"1101" => "Sempre",
					"1102" => "Batch Selettivo",
					"1103" => "Selettivo",
					"1104" => "RSS enabled",
					"1105" => "RSS enabled"
			)
	),
	$language = "it";

	function __construct($language) {
		$this->language = $language;
	}

	function getMessage($code, $data = "") {
		if (is_array($data)) {
			$buffer = $this->messages[$this->language][$code];
			if ((count($data) > 0) && ($data != "")){
				foreach($data as $key => $value) {
					if (is_string($value)) {
						$buffer = str_replace('\{'.$key.'\}', $value, $buffer);
					}
					#echo $buffer;
					#echo " ";
				}
			}
			return $buffer;
		} else {
			return Parser::xmlchars($this->messages[$this->language][$code]);
		}
	}
}