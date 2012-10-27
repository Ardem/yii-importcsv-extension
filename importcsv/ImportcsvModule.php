<?php
/**
 * ImportCSV Module
 *
 * @author Artem Demchenkov <lunoxot@mail.ru>
 * @version 0.0.2
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

class ImportcsvModule extends CWebModule
{
        /*
         * path for csv file
         */
	public $path;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'importcsv.models.*',
			'importcsv.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
