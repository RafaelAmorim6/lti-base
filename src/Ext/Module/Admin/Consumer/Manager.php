<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Module\Admin\Consumer;

/**
 *
 *
 */
class Manager extends \Mod\Module
{

    /**
     * @var \Table\Table
     */
    protected $table = null;


    /**
     * @var \LTI_Tool_Provider
     */
    protected $tool = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->setPageTitle('Consumers');

        $this->set(\Mod\AdminPageInterface::CRUMBS_RESET, true);
        $this->add(\Mod\AdminPageInterface::PANEL_ACTIONS_LINKS, \Mod\Menu\Item::create('Add Consumer', \Tk\Url::createHomeUrl('/consumer/edit.html'), 'fa fa-user'));
    }


    /**
     * init
     */
    public function init()
    {
        $this->tool = $this->getConfig()->getLtiToolProvider();

        // Create Table structure
        $ff = \Form\Factory::getInstance();
        $tf = \Table\Factory::getInstance();

        $this->table = $tf->createTable('Manager');
        $this->table->addCell(Checkbox::create());

        $this->table->addCell(NameCell::create('name'))->setKey()->setUrl(\Tk\Url::createHomeUrl('/consumer/edit.html'));
        $this->table->addCell(KeyCell::create('key'));
        $this->table->addCell($tf->createCellString('secret'));
        //$this->table->addCell($tf->createCellString('consumer_version'))->setLabel('Version');
        $this->table->addCell($tf->createCellBoolean('enabled'));
        $this->table->addCell($tf->createCellBoolean('protected'));
        $this->table->addCell(DateCell::create('updated'));
        $this->table->addCell(DateCell::create('created'));

        $this->table->addAction(DeleteAction::create());
        $this->addChild($tf->createTableRenderer($this->table), 'Manager');
    }

    /**
     * execute
     */
    public function doDefault()
    {
        $list = $this->tool->data_connector->Tool_Consumer_list();
        $this->table->setList($list);
    }

    /**
     * show
     */
    public function show()
    {
        $template = $this->getTemplate();
    }


    /**
     * makeTemplate
     *
     * @return string
     */
    public function __makeTemplate()
    {
        $xmlStr = <<<HTML
<?xml version="1.0" encoding="UTF-8"?>
<div>
  <div var="Manager"></div>
</div>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, $this->getClassName());
        return $template;
    }

}



class KeyCell extends \Table\Cell\Iface
{
    static function create($property, $name = '')
    {
        $obj = new self($property, $name);
        return $obj;
    }
    public function getPropertyValue($obj)
    {
        return $obj->getKey();
    }
}

class NameCell extends \Table\Cell\Iface
{
    static function create($property, $name = '')
    {
        $obj = new self($property, $name);
        return $obj;
    }

    /**
     * get the table data from an object if available
     *   Overide getTd() to add data to the cell.
     *
     * This is the HTML rendered output of the data.
     *
     * @param \Tk\Object $obj
     * @return \Dom\Template Alternativly you can return a plain HTML string
     */
    public function getTd($obj)
    {
        $this->rowClass = array(); // reset row class list
        $url = $this->getUrl();
        if ($url) {
            $url->set('key', $obj->getKey());
            $str = '<a href="' . htmlentities($url->toString()) . '">' . htmlentities($this->getPropertyValue($obj)) . '</a>';
        } else {
            $str = htmlentities($this->getPropertyValue($obj));
        }
        return $str;
    }
}

class DateCell extends \Table\Cell\Iface
{
    /**
     * @var string
     */
    protected $format = \Tk\Date::MED_DATE;


    static function create($property, $name = '')
    {
        $obj = new self($property, $name);
        return $obj;
    }
    /**
     * Change the format of the date
     *
     * @param $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }


    /**
     * Get the property value from the object using the supplied property name
     *
     * @param \Tk\Date $obj
     * @return string
     */
    public function getPropertyValue($obj)
    {
        $value = parent::getPropertyValue($obj);
        return \Tk\Date::create($value)->toString($this->format);
    }

    /**
     * Returns a property value ready to insert into a csv file
     * Override this for types that you want to render differently in csv
     *
     *
     * @param stdClass $obj
     * @return string
     */
    public function getCsv($obj)
    {
        $value = parent::getPropertyValue($obj);
        return \Tk\Date::create($value)->toString();
    }

}


class Checkbox extends \Table\Cell\Checkbox
{

    static function create()
    {
        $obj = new self();
        return $obj;
    }
    /**
     * Get the table data
     *
     * @param \Tk\Object $obj
     * @return string
     */
    public function getTd($obj)
    {
        $str = '<input type="checkbox" name="' . $this->getObjectKey(self::CB_NAME) . '[]" value="' . $obj->getkey() . '" />';
        return $str;
    }

}

class DeleteAction extends \Table\Action\Delete
{

    /**
     * Create a delete action
     *
     * @return \Table\Action\Delete
     */
    static function create()
    {
        $obj = new self('delete', \Tk\Request::getInstance()->getRequestUri(), 'fa fa-times');
        $obj->setLabel('Delete Selected');
        return $obj;
    }

    /**
     * setConfirm
     *
     * @param string $str
     * @return \Table\Action\Delete
     */
    public function setConfirm($str)
    {
        $this->confirmMsg = $str;
        return $this;
    }



    /**
     * (non-PHPdoc)
     * @see \Table\Action\Iface::execute()
     */
    public function execute($list)
    {
        $selected = $this->getRequest()->get($this->getObjectKey(\Table\Cell\Checkbox::CB_NAME));
        if (count($selected)) {
            $i = 0;
            foreach ($list as $obj) {
                if (in_array($obj->getKey(), $selected)) {
                    $this->getConfig()->getLtiDataConnector()->Tool_Consumer_delete($obj);
                    $i++;
                }
            }
            $p = '';
            if ($i > 1) {
                $p = '`s';
            }
            \Mod\Notice::addSuccess('Record'.$p.' successfully deleted.');
        }
        $url = $this->getUri();
        $url->redirect();
    }

    /**
     * Get the action HTML to insert into the Table.
     * If you require to use form data be sure to submit the form using javascript not just a url anchor.
     * Use submitForm() found in Js/Util.js to submit a form with an event
     *
     * @param array $list
     * @return \Dom\Template You can also return HTML string
     */
//    public function getHtml($list)
//    {
//        //$js = sprintf('submitForm(document.getElementById(\'%s\'), \'%s\');',
//        $js = sprintf('tkFormSubmit(document.getElementById(\'%s\'), \'%s\');',
//            $this->getTable()->getForm()->getId(), $this->getObjectKey($this->event));
//        $js = sprintf("if(confirm('%s')) { %s } else { $(this).unbind('click'); }", $this->confirmMsg, $js);
//        $ico = '';
//        if ($this->getIcon()) {
//            $ico = '<i class="'.$this->getIcon().'"></i> ';
//        }
//        return sprintf('<a class="%s btn btn-default btn-xs" href="javascript:;" onclick="%s" title="%s" onmousedown="$(window).unbind(\'beforeunload\');">%s%s</a>',
//            $this->getClassString(), $js, $this->notes, $ico, $this->label);
//    }


}
