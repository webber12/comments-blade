<?php

include_once("TreeView.php");

use Comments\LastView;
use Helpers\Config;
use Helpers\FS;
use Comments\Traits\DocLister as CommentsTrait;
use Helpers\Lexicon;

/**
 * Class TreeView
 */
class TreeViewCustomDocLister extends \TreeViewDocLister
{
    use CommentsTrait;

    public function getDocs($tvlist = '')
    {
        $this->_docs = parent::getDocs($tvlist);
        $this->toPlaceholders(count($this->_docs), 1, 'comments_count');
        if (1 == $this->getCFGDef('tree', '0')) {
            $tree = $this->treeBuild('id', 'idNearestAncestor');
            $this->toPlaceholders(count($tree), 1, 'comments_count_first_level');
        }
        return $this->_docs;
    }

    public function render ($tpl = '')
    {
        switch ($this->mode) {
            case 'recent':
                $this->outData = $this->_renderRecent($tpl);
                break;
            case 'comments':
                if (1 == $this->getCFGDef('tree', '0')) {
                    $this->outData = '';
                    foreach ($this->_tree as $item) {
                        $this->outData .= $this->renderTree($item);
                    }
                    $this->outData = $this->renderWrap($this->outData);
                } else {
                    $this->outData = $this->_render($tpl);
                }
                //$this->outData = $this->_render($tpl);
                break;
            default:
                break;
        }

        return $this->outData;
    }

}
