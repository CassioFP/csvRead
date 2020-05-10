<?php

namespace CsvRead;

use Exception;

class CsvRead
{
    private $pathFile;
    private $delimiter;
    private $hasColumnsName = true;
    private $rows;
    private $columnsName;

    /**
     * Receive a path with file name and columns delimiter
     * @param string pathFile, $delimiter
     * @throw exception if can't open file
     */
    public function __construct($pathFile, $delimiter)
    {
        $this->pathFile = $pathFile;
        $this->delimiter = $delimiter ?: ';';
    }

    /**
     * Returns an array with rows, without columns name
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Returns an array with columns name
     */
    public function getColumnsName()
    {
        return $this->columnsName;
    }

    /**
     * If file have title (columns name) in first line
     */
    public function setHasColumnsName(bool $hasColumnsName)
    {
        $this->hasColumnsName = $hasColumnsName;
        return $this;
    }

    /**
     * Process the file creating rows and columns name
     * @throw Exception
     */
    public function processFile()
    {
        $file = fopen($this->pathFile, 'r');
        
        if(!$file) {
            throw new Exception("Error opening the file {$this->pathFile}");
        }

        $fileContent = fread($file, filesize($this->pathFile));
        $content = explode("\n", $fileContent);
    
        if($this->hasColumnsName) {
            $this->columnsName = str_getcsv($content[0], $this->delimiter);
            unset($content[0]);
        }
        
        $content = $this->indexRows($content);
        $this->rows = $content;
    }

    /**
     * Create array with file rows using columns name as index 
     * @param array rows
     * @return array 
     */
    private function indexRows(array $rows)
    {
        $indexed = [];
        foreach($rows as $row) {
            if(!$row) continue;

            $csvLine = str_getcsv($row, $this->delimiter);
            $indexed[] = $this->columnsName ? array_combine($this->columnsName, $csvLine) : $csvLine;
        }
        return $indexed;
    }
    
    /**
     * Return value of an specific row and specific column
     * To more than one column, use an array with columns name: ['id', 'state']
     * @param int lineNumber
     * @param string|array column
     * @return array 
     */
    public function getRow($lineNumber, $column = '')
    {
        if(is_array($column)) {
            foreach($column as $currentColumn) {
                $line[$currentColumn] = $this->rows[$lineNumber][$currentColumn];  
            }
            return $line;
        }
        elseif($column) {
            return $this->rows[$lineNumber][$column];
        }

        return $this->rows[$lineNumber];
    }

    /**
     * Walk all lines and apply a lambda function in each line of file. Your function must take a row as a parameter
     * @param function function
     */
    public function processRows($function)
    {
        foreach($this->rows as $row) {
            $function($row);
        }
    }
}