<?php
/**
 * FileController.php - Main Controller
 *
 * Main Controller File Module
 *
 * @category Controller
 * @package File
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\File\Controller;

use Application\Controller\CoreUpdateController;
use Application\Model\CoreEntityModel;
use OnePlace\File\Model\FileTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;

class InstallController extends CoreUpdateController {
    /**
     * FileController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param FileTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter, FileTable $oTableGateway, $oServiceManager)
    {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'file-single';
        parent::__construct($oDbAdapter, $oTableGateway, $oServiceManager);

        if ($oTableGateway) {
            # Attach TableGateway to Entity Models
            if (! isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    public function checkdbAction()
    {
        # Set Layout based on users theme
        $this->setThemeBasedLayout('file');

        $oRequest = $this->getRequest();

        if(! $oRequest->isPost()) {

            $bTableExists = false;

            try {
                $this->oTableGateway->fetchAll(false);
                $bTableExists = true;
            } catch (\RuntimeException $e) {

            }

            return new ViewModel([
                'bTableExists' => $bTableExists,
                'sVendor' => 'oneplace',
                'sModule' => 'oneplace-file',
            ]);
        } else {
            $sSetupConfig = $oRequest->getPost('plc_module_setup_config');

            $sSetupFile = 'vendor/oneplace/oneplace-file/data/install.sql';
            if(file_exists($sSetupFile)) {
                echo 'got install file..';
                $this->parseSQLInstallFile($sSetupFile,CoreUpdateController::$oDbAdapter);
            }

            if($sSetupConfig != '') {
                $sConfigStruct = 'vendor/oneplace/oneplace-file/data/structure_'.$sSetupConfig.'.sql';
                if(file_exists($sConfigStruct)) {
                    echo 'got struct file for config '.$sSetupConfig;
                    $this->parseSQLInstallFile($sConfigStruct,CoreUpdateController::$oDbAdapter);
                }
                $sConfigData = 'vendor/oneplace/oneplace-file/data/data_'.$sSetupConfig.'.sql';
                if(file_exists($sConfigData)) {
                    echo 'got data file for config '.$sSetupConfig;
                    $this->parseSQLInstallFile($sConfigData,CoreUpdateController::$oDbAdapter);
                }
                $sCustomLangFile = 'vendor/oneplace/oneplace-file/data/de_DE_'.$sSetupConfig.'.po';
                if(file_exists($sCustomLangFile)) {
                    echo 'got lang file for config '.$sSetupConfig;
                    copy($sCustomLangFile,'vendor/oneplace/oneplace-file/language/de_DE.po');
                    $sCustomLangFile = 'vendor/oneplace/oneplace-file/data/de_DE_'.$sSetupConfig.'.mo';
                    copy($sCustomLangFile,'vendor/oneplace/oneplace-file/language/de_DE.mo');
                    echo $sCustomLangFile. " to ".'vendor/oneplace/oneplace-file/language/de_DE.mo';
                }
//                return;
            }

            $oModTbl = new TableGateway('core_module', CoreUpdateController::$oDbAdapter);
            $oModTbl->insert([
                'module_key'=>'oneplace-file',
                'type'=>'module',
                'version'=>\OnePlace\File\Module::VERSION,
                'label'=>'onePlace File',
                'vendor'=>'oneplace',
            ]);

            try {
                $this->oTableGateway->fetchAll(false);
                $bTableExists = true;
            } catch (\RuntimeException $e) {

            }
            $bTableExists = false;

            $this->flashMessenger()->addSuccessMessage('File DB Update successful');
            $this->redirect()->toRoute('application', ['action' => 'checkforupdates']);
        }
    }
}
