<?php

//namespace Edtau\HTMLTable;
use Edtau\HTMLTable\CTable as CTable;

class CTableTest extends \PHPUnit_Framework_TestCase
{


    public function testAddHeader()
    {
        $table = new CTable(false);
        $header = $table->addHeader(array("data"));
        $this->assertContains("<thead>", $header);
        $this->assertContains("</thead>", $header);
        $this->assertContains("<tr>", $header);
        $this->assertContains("</tr>", $header);
        $this->assertContains("<th>", $header);
        $this->assertContains("</th>", $header);
        $this->assertContains("data", $header);

        $this->assertFalse($table->addHeader("string"));
    }

    public function testTableRow()
    {
        $table = new CTable(false);
        $row = $table->addRow(array("data"));
        $this->assertContains("<tr>", $row);
        $this->assertContains("<td>", $row);
        $this->assertContains("</td>", $row);
        $this->assertContains("</tr>", $row);
        $this->assertContains("data", $row);
        $row = $table->addRow("string instead of array");
        $this->assertFalse($row);
        $table = new CTable(false);
        $this->assertNull($table->getRows());

        $table->addRow(array("frank", "anna"));
        $table->addRow(array("frank", "anna"));
        $this->assertCount(2, $table->getRows());


    }

    public function testValidateArray()
    {
        $table = new CTable(false);
        $result = $table->validateArray("no-array");
        $this->assertFalse($result);
        $result = $table->validateArray(array("hello", "hello"));
        $this->assertTrue($result);
    }

    public function testGetTable()
    {
        $table = new CTable(false);
        $result = $table->getTable();
        $this->assertFalse($result);
        $table->addHeader(array("name", "age"));
        $table->addRow(array("frank", "anna"));

        $result = $table->getTable();

         $this->assertStringEndsWith('</table>', $result);
    }

    public function testGetHeader()
    {
        $table = new CTable();
        $this->assertNull($table->getHeader());
    }

    public function testSimpleTable()
    {
        $array = array(
            array("name", "age"),
            array("sven", "13"),
            array("lars", "14")
        );
        $table = new CTable();
        $result = $table->simpleTable("string");
        $this->assertFalse($result);

        $booleanResult = false;
        if (is_string($table->simpleTable($array))) {
            $booleanResult = true;
        }
        $this->assertTrue($booleanResult);
    }

    public function testGetException()
    {
        $table = new CTable();

        $this->assertNull($table->getExecption());
        $table = new CTable(true);
        $this->assertNull($table->getExecption());
        $result = $table->validateArray("string");
    }
}
