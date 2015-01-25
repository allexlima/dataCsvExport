<?php

/*
** -- Criada por Allex Lima
** -- Converte informações de uma matriz em um arquivo CSV
** ~Fork me on GitHub: github.com/allexlima

** -- Em caso de dúvidas sobre os arquivos .CSV, por favor leia este artigo: http://pt.wikipedia.org/wiki/Comma-separated_values
*/

class exportData{
	public $dataMatrix;
	public $delimiter;
	public $dirTemp;
	public $fileName;
	private $cols;
	private $rows;
	protected $accumulator;
	

	function __construct(){
		date_default_timezone_set("America/Manaus");
		setlocale(LC_ALL, 'pt_BR');		
		$this->dataMatrix = array();
		$this->delimiter = ",";		
		$this->dirTemp = sys_get_temp_dir();
		$this->fileName = "exportData-".date("His-dmY");		
	}
	
	private function warnings($code){
		$return = "<output style='font-size:0.8em;font-family:Arial;cursor:not-allowed'><h3>exportData.class</h3> <b>Erro:</b> <span style='color:red'>";
		switch($code){
			case 001: $return .= "A matriz <b>dataMatrix</b> não recebeu nenhuma linha!"; break;
			case 002: $return .= "As linhas não possuem o mesmo número de colunas!"; break;	
			case 003: $return .= "O delimitador, atribuído pelo atributo <b>delimiter</b> é inválido!<br><br>Escolha entre ';' (ponto-vírgula) ou ',' (vírgula)."; break;	
			case 004: $return .= "Erro ao criar arquivo temporário, favor verifique as permissões da classe e/ou usuário logado!<br><br>Não foi possível acessar o diretório: <i>".$this->dirTemp.DIRECTORY_SEPARATOR."</i>"; break;
			case 005: $return .= "Diretório inválido!"; break;	
		}
		$return .= "</span></output>";
		return $return;
	}
	
	private function validations(){
		$this->accumulator = "";
		if(empty($this->dataMatrix))die($this->warnings(001));
		else if(($this->delimiter != ";") && ($this->delimiter != ","))die($this->warnings(003));
		else if(!is_dir($this->dirTemp))die($this->warnings(005));
	}
	
	private function download($file, $name){
		set_time_limit(0);
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		readfile($file);	
	}
	
	public function csv(){
		$this->validations();
		$this->rows = count($this->dataMatrix);
		
		for($i=1;$i<$this->rows;$i++){
			if(count($this->dataMatrix[$i]) == count($this->dataMatrix[$i-1]))
				continue;
			else
				die($this->warnings(002));
		}
		$this->cols = count($this->dataMatrix[$i-1]);
		for($i=0;$i<$this->rows;$i++){
			for($j=0;$j<$this->cols;$j++){
				$this->accumulator .= (is_string($this->dataMatrix[$i][$j]))?"\"{$this->dataMatrix[$i][$j]}\"":$this->dataMatrix[$i][$j];
				if($j != $this->cols-1) $this->accumulator .= $this->delimiter;
			}
			if($i != $this->rows-1) $this->accumulator .= "\n";	
		}
		$tempCsv = $this->dirTemp.DIRECTORY_SEPARATOR.$this->fileName.".csv";
		if(!$CsvFile = @fopen($tempCsv, "w"))die($this->warnings(004));
		fwrite($CsvFile, $this->accumulator);
		header('Content-Type: text/csv; charset=utf-8');
		$this->download($tempCsv, $this->fileName.".csv");
		fclose($CsvFile);
	}
}

?>