<?
class PHPExcel_StringBinder extends PHPExcel_Cell_DefaultValueBinder implements PHPExcel_Cell_IValueBinder {
    protected $stringColumns = array();

    public function __construct(array $stringColumnList = array()) {
        // Accept a list of columns that will always be set as strings
        $this->stringColumns = $stringColumnList;
    }

    public function bindValue(PHPExcel_Cell $cell, $value = null) {
        // If the cell is one of our columns to set as a string...
        if (in_array($cell->getColumn(), $this->stringColumns)) {
            // ... then we cast it to a string and explicitly set it as a string
            $cell->setValueExplicit((string) $value, PHPExcel_Cell_DataType::TYPE_STRING);
            return true;
        }
        // Otherwise, use the default behaviour
        return parent::bindValue($cell, $value);
    }
}
?>