<?php
class Model_Wep extends Zend_Db_Table_Abstract
{

    protected $_name;

    public function listAll($tableName, $fieldName, $data){
        $this->_name = $tableName;
        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
        ->where("$fieldName = ?",$data);
        $result = $this->fetchAll($rowSet)->toArray();
        return $result;
    }

    public function prepPostKeys($table){
        $tableN = $table;
        foreach($data as $key => $eachData){
            /*if($key == 'attr_xmllang'){
             $key = 'attr_xml_lang';
             }*/
            $key = str_replace('attr_', '@', $key);
            $key = str_replace($tableN."_", '', $key);
            $data1[$key] = $eachData;
        }

        return $data1;
    }


    public function prepKeysForForm($table, $data){
        //        print_r($table);exit();
        //$data['@xml'] = 'ddd';
        foreach($data as $key => $eachData){
            /*if($key == '@xml:lang'){
             $key = '@xmllang';
             }*/
            if($key == 'text'){
                $key = $table."_".$key;
            }
            $string = 'attr_'. $table. "_";
            $key = str_replace('@', $string, $key);
            $data1[$key] = $eachData;
        }
        //print_r($data1);exit();
        return $data1;
    }

    /* public function getColumns($tableName){
     $this->_name = $tableName;
     //        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false);
     print_r($this->_getCols());
     }*/

    public function filterField($tableName)
    {
        $this->_name = $tableName;
        //        print($this->_name);
        //        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false);
        $colName = $this->_getCols();
        $i = 0;
        foreach ($colName as $tmpName) {
            if ($tmpName != 'id' && $tmpName != 'lang_id')
            $fieldName[$i] = $tmpName;
            $i++;
        }
        return $fieldName;
    }

    /**
     *
     *
     * @param $tblName
     * @param $fieldName
     * @param $data
     * @return array of data of the row
     */
    public function getRowsByFields($tblName, $fieldName, $data){
        $this->_name = $tblName;
        $rowSet = $this->select()->where("$fieldName = ?",$data);

        $result = $this->fetchAll($rowSet)->toArray();
//        print_r($result);exit;
        return $result;
    }
    
    public function fetchValueById($tblName, $id, $getField){
        $this->_name = $tblName;
        $rowSet = $this->select()->where("id =?", $id);
        $result = $this->fetchRow($rowSet)->toArray();
        return $result['Code'];
    }

    public function getCode($tblName, $codeid,$lang)
    {
        $this->_name = $tblName;
        if (isset($codeid))
        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
        ->where('id = ?', $codeid)
        ->where('lang_id = ?',$lang);
        else
        $rowSet = $this->select()
        ->where('lang_id = ?',$lang);

        $result[0] = $this->fetchAll($rowSet)->toArray();
        $result[1] = $this->_getCols($rowSet);
        return $result;
    }
    
    
    
    public function getCodeArray($tblName, $codeid, $lang)
    {
        $this->_name = $tblName;
        if (isset($codeid))
        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
        ->where('id = ?', $codeid)->where('lang_id = ?',$lang);
        else
        $rowSet = $this->select()->where('lang_id = ?',$lang)->order(array('Code ASC'));
        
        $result = $this->fetchAll($rowSet)->toArray();
//        print_r($result);exit();
        $finalResult = array();
        foreach($result as $key => $eachResult)
        {
            $name = '';
            if(key_exists('Name', $eachResult)){
                $name = " - ".$eachResult['Name'];
            }
            if(key_exists('Abbreviation', $eachResult)){
                $name = " - ".$eachResult['Abbreviation'];
            }
            
            $finalResult[$eachResult['id']] = $eachResult['Code']. $name;
        }
        return $finalResult;
    }

    public function insertRowsToTable($tblName, $data){
        $this->_name = $tblName;
        return parent::insert($data);
    }

    public function updateRowsToTable($tblName, $data){
        $this->_name = $tblName;
        

        return parent::update($data,array('id= ?' => $data['id']));
    }
    
    public function deleteRowById($id,$tblName) {
        $this->_name = $tblName;
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }

    public function getDefaults($tableName, $fieldName, $data)
    {
        $this->_name = $tableName;
        $defaults = $this->listAll($tableName, $fieldName, $data);
        $defaultArray = unserialize($defaults[0]['object']);
        return $defaultArray;
    }
    
    public function getIdByField($tableName, $fieldName, $data)
    {
        $this->_name = $tableName;
        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
        ->where("$fieldName = ?",$data);

        $result = $this->fetchRow($rowSet)->toArray();
        return $result['id'];
    }
    
    public function findIdByFieldData($tblName, $data, $lang){
        $this->_name = $tblName;
        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
        ->where('Code = ?', $data)
        ->where('lang_id = ?',$lang);
        return $this->fetchAll($rowSet)->toArray();
    }
    
    public function listOrganisation($tableName)
    {
        $this->_name = $tableName;
        $rowSet = $this->select();
        $result = $this->fetchAll($rowSet)->toArray();
        return $result;
//        $select->where()
    }
    
    public function getRowById($tableName, $fieldName, $data)
    {
        $this->_name = $tableName;
        $rowSet = $this->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
         ->where("$fieldName = ?",$data);
         
        $result = $this->fetchRow($rowSet);
        if($result){
            $result = $result->toArray();
        }
        return $result;
        
    }
   

}