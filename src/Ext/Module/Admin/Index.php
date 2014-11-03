<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Module\Admin;

use Mod\AdminPageInterface;
/**
 *
 *
 * @package Ext\Module\Admin
 */
class Index extends AdminPageInterface
{

    /**
     * __construct
     */
    public function __construct()
    {
        $this->setPageTitle('Dashboard');
        $this->set(AdminPageInterface::PANEL_ACTIONS_ENABLE, false);
        $this->set(AdminPageInterface::PANEL_CONTENT_ENABLE, false);
        $this->set(AdminPageInterface::CRUMBS_ENABLE, false);



    }


    /**
     * init
     */
    public function init()
    {
        

    }

    /**
     * doDefault
     */
    public function doDefault()
    {

    }

    /**
     * show
     */
    public function show()
    {
        $template = $this->getTemplate();

    }

}




