<?php

/* 
** Importa o arquivo da classe 
*/
include ("makeCsv.class.php");

/*  
** Instância a classe
*/
$exemplo = new exportData();

/* 
** Específica um diretório para que o arquivo seja salvo (opcional)
** Caso esse atributo não seja setado, a classe irá usar o diretório temporário padrão do sistema operacional
** Alguns sistemas Linux necessitam de um diretório personalizado com permissões.
*/
#$exemplo->dirTemp = "/home/sirdrone.com/www";

/* Específica um nome padrão para o arquivo a ser gerado (opcional)
** Caso esse atributo não seja setado, a classe irá utilizar uma nomeclatura padrão no nome do arquivo.
*/
#$exemplo->fileName = "myCsvfile"

/*
** Específica um delimitador para quebra de colunas (opcional)
** Por padrão, este atributo é settado no construtor da classe como ',', conforme a norma RFC4180
** Porém, programas como o Microsoft Excel, só lê a quebra com o delimitador ';'.
*/
#$exemplo->delimiter = ",";	


/*
** Define a matriz de dados (necessário)
** Para iniciar, é necessário inserir novas linhas/colunas na matrix dataMatrix. Para isso é necessário utilizar
** o comando array_push($array, $linha), para mais informações sobre o comando, acesse: php.net/manual/pt_BR/function.array-push.php
**
*/
array_push($exemplo->dataMatrix, array("Nome", "Idade", "Profissão"));
array_push($exemplo->dataMatrix, array("Allex", 17.6, "Estagiário"));
array_push($exemplo->dataMatrix, array("João", 19, "Universitário"));
array_push($exemplo->dataMatrix, array("Alice", 18, "Estudante"));


/*
** Executa a conversão de dados para download (necessário)
*/
$exemplo->csv();


/*
** Em caso de dúvidas, você pode entrar em contato via
** E-mail: allexlima97@gmail.com
*/

?>