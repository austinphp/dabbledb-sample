<?php
class Dabbler
{
    /**
     * @var string (the URL to the dabble json data)
     */
    private $_dataUrl;
    
    /**
     * @var stdClass (the decoded JSON tree)
     */
    private $_data;
    
    /**
     * @var array (the parsed out data)
     */
    private $_entries;
    
    /**
     * @param string $dataUrl the URL to the dabbel json data
     */
    public function __construct($dataUrl)
    {
        if (!isset($dataUrl)) {
            throw new Exception('Must have a schema in order to do anything useful');
        } else {
            $this->_dataUrl = $dataUrl;
        }
        
        if (!$this->_loadData()) {
            throw new Exception('Unable to load JSON data from Dabble');
        }
    }
    
    /**
     * @return array
     */
    public function getEntries()
    {
        return $this->_entries;
    }
    
    /**
     * @param string $value the value to filter on
     * @param string $key the column to filter on
     */
    public function getEntry($value, $key)
    {
        foreach ($this->_entries as $entry) {
            if ($entry[$key] == $value) {
                return $entry;
            }
        }
        return null;
    }
    
    /**
     * @return bool
     */
    private function _loadData()
    {
        $jsContent = file_get_contents($this->_dataUrl);
        $objects = json_decode($jsContent);
        if ($objects) {
            $this->_data = $objects;
            
            foreach ($objects->entries as $entry) {
                $row = array();
                foreach ($entry->fields as $field) {
                    $fieldId = $field->field;
                    $key = $objects->fields->$fieldId->name;
                    $row[$key] = $field->value;
                }
                $this->_entries[] = $row;
            }
            
            return true;            
        }
        return false;
    }
}