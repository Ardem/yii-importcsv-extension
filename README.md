About
============

ImportCSV is used for load positions from CSV file to database. This is an extension for Yii Framework.

Import occurs in three steps:

1. Upload file;
2. Select delimiters and table;
3. Select mode and columns in table.

Module has 3 modes:

1. Insert all - Add all rows;
2. Insert new - Add new rows. Old rows remain unchanged;
3. Insert new and replace old - Add new rows. Old rows replace.

All parameters from the previous imports will be saved in a special .php file in upload folder.

Requirements
============

Yii 1.1

Usage
============

1) Copy all the 'importcsv' folder under /protected/modules;

2) Register this module in /protected/config/main.php

    'modules'=>array(
        .........
        'importcsv'=>array(
            'path'=>'upload/importCsv/', // path to folder for saving csv file and file with import params
        ),
        ......
    ),

3) Create a directory which you use in 'path'. Do not forget to set access permissions for directory 'path';

4) The module is available here: 

http://yourproject/importcsv. 

Or here: 

http://yourproject/index.php?r=importcsv.

 
Or somewhere else:-) It depends from path settings in your project;

5) ATTENTION! The first row of your csv-file must will be a row with column names.
