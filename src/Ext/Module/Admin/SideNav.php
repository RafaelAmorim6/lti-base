<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Module\Admin;

/**
 *
 *
 * @package Ext\Module\Admin
 */
class SideNav extends \Mod\Module
{
    public $boxEnable = false;
    public $actionEnable = false;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->setInsertMethod(self::INS_REPLACE);
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
        if ($this->getConfig()->isDev()) {
            $template->setChoice('dev');
        }
        if (class_exists('\Plg\Factory')) {
            $template->setChoice('plugins');
        }
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
<ul class="nav navbar-nav side-nav">
    <li class="active"><a href="/admin/index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i> System <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="/admin/settings.html">Settings</a></li>
        <li><a href="/admin/user/manager.html">Users</a></li>
        <li><a href="/admin/consumer/manager.html">LTI Consumers</a></li>
        <li choice="themes"><a href="/admin/theme/manager.html">Themes</a></li>
        <li choice="plugins"><a href="/admin/plugin/manager.html">Plugins</a></li>
        <li><a href="/admin/mail/log/manager.html">Log</a></li>
      </ul>
    </li>


    <li class="dropdown" choice="dev">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-exclamation-triangle "></i> Dev Tools <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="/admin/_dev/tailLog.html" target="_blank">Tail Log</a></li>
        <li><a href="/admin/_dev/pageList.html">Dispacher List</a></li>
        <li><a href="/admin/_dev/migrate.html">SQL Migration</a></li>
        <li><a href="/admin/_dev/pluginHookList.html" choice="plugins">Plugin API List</a></li>
      </ul>
    </li>
    <li class="dropdown" choice="dev">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-exclamation-triangle "></i> Design <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="/admin/_dev/type.html">Typography</a></li>
        <li><a href="/admin/_dev/form.html">Form</a></li>
        <li><a href="/admin/_dev/formTabs.html">Form Tabs</a></li>
        <li><a href="/admin/_dev/formStatic.html">Form Static</a></li>
        <li><a href="/admin/_dev/table.html">Tables</a></li>
        <li><a href="/admin/_dev/ui.html">UI</a></li>
      </ul>
    </li>
    <li class="divider"></li>
    <li style="position: absolute; bottom: 70px; left: 10px;"><small class=""><a href="http://www.tropotek.com/" target="_blank" style="color: #666;">&copy; Tropotek 2013</a></small></li>
</ul>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, $this->getClassName());
        return $template;
    }
}




