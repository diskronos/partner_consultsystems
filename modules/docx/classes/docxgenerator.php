<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
/*-->docxGenerator.php<--*/ 
//Класс, генерирующий docx-файлы на базе шаблонов 
 
class docxGenerator { 
 private $_zipObject; //Для открытия zip-архива 
 private $_tmpFilename; //Имя временного файла, создаваемого при работе класса 
 private $_docxContent; //Хранит содержимое ./word/document.xml 
 
 public function __construct($filename, $tempfilepath){ 
  //Конструтор класса, берет шаблон $filename 
 
  //1) Создаем копию шаблона для безопасной работы 
  $this->_tmpFilename = $tempfilepath .'/'.time().'.docx'; // Функция dirname извлекает путь к каталогу с файлом filename 
  copy($filename, $this->_tmpFilename); // Копируем содержимое шаблона во временный файл 
 
  //2) С помощью встроенного в PHP класса вытаскиваем содержимое 
  $this->_zipObject = new ZipArchive(); //Создали экземпляр класса для работы с Zip-архивом 
  $this->_zipObject->open($this->_tmpFilename); //Открыли временный файл архиватором, т.к. docx - это и есть архив 
  $this->_docxContent = $this->_zipObject->getFromName('word/document.xml'); //Вытащили текст документа с разметкой из файла ./word/document.xml внутри архива 
 }//__construct 
 
 public function val($search, $replace) { 
  //Функция замены меток с названием $search на значение $replace
  $search = '%'.$search.'%'; //Прибавляем амперсанды в виде специальных символов
  $replace = htmlspecialchars($replace); //Заменяем все спецсимволы в добавляемом тексте на их веб-эквивалент
  $this->_docxContent = str_ireplace($search, $replace, $this->_docxContent); //Собственно процесс замены это обычная замена подстрок в текстовом документе 
 }
 
 public function val_all($replaces = array())
 {
     foreach ($replaces as $search => $replace)
     {
         $this->val($search, $replace);
     }
 }
 
 public function save($filename){ 
  //Сохраняет полученный из шаблона файл с именем $filename. Существующие файлы перезаписываются. 
 
  //1) Если файл $filename уже существует, то нужно его удалить 
  if(file_exists($filename)){ 
   unlink($filename); 
  }//if file_exists 
 
  //2) Дописываем измененное xml-содержимое в документ 
  $this->_zipObject->addFromString('word/document.xml', $this->_docxContent); 
 
  //3) Пытаемся сохранить изменения 
  if($this->_zipObject->close() === false){ 
   throw new Exception('Не удалось сохранить изменения в документе.'); 
  }//if close 
  rename($this->_tmpFilename, $filename); 
 }//save 
}//docxGenerator 

