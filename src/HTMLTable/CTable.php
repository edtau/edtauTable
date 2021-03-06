<?php
namespace Edtau\HTMLTable;
use Exception;
use InvalidArgumentException;
class CTable
{
    private $tableHeader = null;
    private $rows = null;
    private $displayExceptions = false;
    private $exception = null;
    private $id = null;
    /**
     * Constructor takes boolean for showing execptions or not
     * Default value is false - no exceptions displays but saves
     * to exception so they can be retrived later
     * @param boolean displayExceptions
     */
    public function __construct($displayExceptions = false)
    {
        $this->displayExceptions = $displayExceptions;
    }
    /**
     * Method to get the exception
     * @return string|false if set
     * @return string|false
     */
    public function getExecption() {
        return $this->exception;
    }
    /**
     * Method to get the table header
     * @return string tableheader
     */
    public function getHeader()
    {
        return $this->tableHeader;
    }
    /**
     * Method to get the table rows
     * Method to get the table rows 
     * @return string[] with rows
     */
    public function getRows()
    {
        return $this->rows;
    }
    /**
     * Method to check that it is a array
     * Save execption if not array and
     * can show execption if set in constructor
     * @param array the table data
     * @return boolean or false
     */
    public function validateArray($array)
    {
        try {
                if (is_array($array) === false)
                throw new Exception("is not a valid array: " . $array);
        } catch (Exception $e) {
            if ($this->displayExceptions) {
                echo  $e->getMessage();
            }
            $this->exception = $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * @param $array the values used to get a table row
     * @return string the table row
     */
    public function addRow($array)
    {
        if ($this->validateArray($array)) {
            $td = "<tr>";
            foreach ($array as $value) {
                $td .= "<td>$value</td>";
            }
            $td .= "</tr>";
            $this->rows[] = $td;
            return $td;
        }
        return false;
    }
    /**
     * Function to generate the tablehead
     * @param $theadData the data for the tablehead
     * @return string the tablehead
     */
    public function addHeader($array)
    {
        if ($this->validateArray($array)) {
            $this->tableHeader = "<thead>\n<tr>\n";
            foreach ($array as $head) {
                $this->tableHeader .= "<th>$head</th>";
            }
            $this->tableHeader .= "</tr>\n</thead>\n";
            return $this->tableHeader;
        }
        return false;
    }
    /**
     * Function to get the generated table
     * Uses the custom functions addRows and andHeader to
     * build table
     * @param $array the table data
     * @param null $id optional to use id for table
     * @return string the complete table
     */
    public function getTable($id = null)
    {
        if($this->checkValidTable()){
            $this->setId($id);
            $table = "<table $this->id>";
            $table .= $this->tableHeader;
            
            foreach ($this->rows as $row) {
                $table .= $row;
            }
            $table .= "</table>";
            return $table;
        }
         return false;
    }
    /**
     * Function to check that the table is set
     * @return true|false
     */
    private function checkValidTable(){
        try {
            if ($this->tableHeader == null || $this->rows == null) {
                throw new InvalidArgumentException("You have not added the table header and rows");
            }
          }
          catch (Exception $e) {
            $this->exception = $e->getMessage();
            return false;
        }
      return true;
    }
    /**
     * Function to get the generated table
     * the first row in the array becomes the head of
     * the table if the tableheader is not set
     * @param $array the table data
     * @param null $id optional to use id for table
     * @return string the complete table
     */
    public function simpleTable($array, $id = null)
    {
        if ($this->validateArray($array) === false) {
            return false;
        }

        $table = $this->setId($id);
        $table .= $this->setTableHead($array);

        $row = "";
        foreach ($array as $value) {
            $row .= $this->addRow($value);
        }
        $table .= $row;
        $table .= "</table>\n";
        return $table;
    }
    /**
     * Function to check and set id on a table
     * @param id
     * @return string table tag with id if it is present
     */
    private function setId($id = null) {
        $this->id = ($id === null) ? null : " id='$id'";
    }
    /**
     * Function to build the table header
     * @param array the table data
     * @return string table header
     */
    private function setTableHead($array = null) {
        $tableHeader =  $this->getHeader();
        if ($tableHeader == null) {
            $theadData = array_shift($array);
            $tableHeader =  $this->addHeader($theadData);
        }
        return $tableHeader;
    }
}
