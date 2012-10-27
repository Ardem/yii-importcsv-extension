<?php
/**
 * ImportCSV Module
 *
 * @author Artem Demchenkov <lunoxot@mail.ru>
 * @version 0.0.1
 *
 *  Usage:
 *
 *  1) Copy all the 'importcsv' folder under /protected/modules
 *
 *  2) Register module in /protected/config/main.php
 *     'modules'=>array(
 *		.........
 *               'importcsv'=>array(
 *			'path'=>'upload/importCsv/', // path to folder for saving csv file and file with import params
 *		),
 *              ......
 *	),
 *
 *  3) Do not forget to set permissions for directory 'path'
 *
 *  4) The module is available at http://yourproject/importcsv
 *
 */

class ImportCsv extends CFormModel
{
    /*
     *
     *  Insert new rows to database
     *
     *  $table - db table
     *  $linesArray - lines with values from csv
     *  $columns - list of csv columns
     *  $tableColumns - list of table columns
     *
     */

    public function InsertAll($table, $linesArray, $columns, $tableColumns)
    {
            // $columnsLength - size of columns array
            // $tableString - rows in table
            // $tableString - items in csv
            // $linesLength - size of lines for insert array

            $columnsLength   = sizeof($columns);
            $tableString = '';
            $csvString   = '';
            $n = 0;
            $linesLength = sizeof($linesArray);

            // watching all strings in array
            
            for($k=0; $k<$linesLength; $k++) {

                // watching all columns in POST

                $n_in = 0;
                
                for($i=0; $i<$columnsLength; $i++) {
                    if($columns[$i]!='') {
                        if($k == 0) $tableString = ($n!=0) ? $tableString.", ".$tableColumns[$i] : $tableColumns[$i];

                        if($k == 0 && $n == 0) $csvString = "(";
                        if($k != 0 && $n_in == 0) $csvString = $csvString."), (";

                        $csvString   = ($n_in!=0) ? $csvString.", '".CHtml::encode(stripslashes($linesArray[$k][$columns[$i]-1]))."'" : $csvString."'".CHtml::encode(stripslashes($linesArray[$k][$columns[$i]-1]))."'";
                        
                        $n++;
                        $n_in++;
                    }
                }

            }

            $csvString = $csvString.")";

            // insert $csvString to database
            
            $sql="INSERT INTO ".$table."(".$tableString.") VALUES ".$csvString."";
            $command=Yii::app()->db->createCommand($sql);

            if($command->execute()) 
                 return (1);
            else
                 return (0);
    }

    /*
     * 
     *  Update old rows
     *  $table - db table
     *  $csvLine - one line from csv
     *  $columns - list of csv columns
     *  $tableColumns - list of table columns
     *  $needle - value for compare from csv
     *  $tableKey - key for compare from table
     * 
     */

    public function updateOld($table, $csvLine, $columns, $tableColumns, $needle, $tableKey)
    {
        // $columnsLength - size of columns array
        // $tableString - rows in table
        // $csvLine - items from csv
        
        $columnsLength = sizeof($columns);
        $tableString = '';
        $n           = 0;
        
        for($i=0; $i<$columnsLength; $i++) {
            if($columns[$i]!='') {
                $tableString = ($n!=0) ? $tableString.", ".$tableColumns[$i]."='".CHtml::encode(stripslashes($csvLine[$columns[$i]-1]))."'" : $tableColumns[$i]."='".CHtml::encode(stripslashes($csvLine[$columns[$i]-1]))."'";

                $n++;
            }
        }

        // update row in database

        $sql="UPDATE ".$table." SET ".$tableString." WHERE ".$tableKey."='".$needle."'";
        $command=Yii::app()->db->createCommand($sql);

        if($command->execute())
             return (1);
        else
             return (0);
    }

    /*
     * get columns from selected table
     * $table - db table
     * @return array list of db columns
     *
     */

    public function tableColumns($table)
    {
        return Yii::app()->getDb()->getSchema()->getTable($table)->getColumnNames();
    }

    /*
     * get attribute from all rows from selected table
     *
     * $table - db table
     * $attribute - columns in db table
     * @return - rows array
     *
     */

    public function selectRows($table, $attribute)
    {
        $sql = "SELECT ".$attribute." FROM ".$table;
        $command=Yii::app()->db->createCommand($sql);
        return ($command->queryAll());
    }
}

?>
