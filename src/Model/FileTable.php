<?php
/**
 * FileTable.php - File Table
 *
 * Table Model for File
 *
 * @category Model
 * @package File
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\File\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class FileTable extends CoreEntityTable {

    /**
     * FileTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'file-single';
    }

    /**
     * Get File Entity
     *
     * @param int $id
     * @param string $sKey
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id,$sKey = 'File_ID') {
        # Use core function
        return $this->getSingleEntity($id,$sKey);
    }

    /**
     * Save File Entity
     *
     * @param File $oFile
     * @return int File ID
     * @since 1.0.0
     */
    public function saveSingle(File $oFile) {
        $aDefaultData = [
            'label' => $oFile->label,
        ];

        return $this->saveSingleEntity($oFile,'File_ID',$aDefaultData);
    }

    /**
     * Generate new single Entity
     *
     * @return File
     * @since 1.0.0
     */
    public function generateNew() {
        return new File($this->oTableGateway->getAdapter());
    }
}