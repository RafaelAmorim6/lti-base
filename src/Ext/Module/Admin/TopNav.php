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
class TopNav extends \Mod\Module
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
        $template->insertText('username', $this->getConfig()->getUser()->username);

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
<ul class="nav navbar-nav navbar-right navbar-user">
    <li class="dropdown messages-dropdown" choice="hide">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages <span class="badge">7</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li class="dropdown-header">7 New Messages</li>
        <li class="message-preview">
          <a href="#">
            <span class="avatar"><img src="http://placehold.it/50x50"/></span>
            <span class="name">John Smith:</span>
            <span class="message">Hey there, I wanted to ask you something...</span>
            <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
          </a>
        </li>
        <li class="divider"></li>
        <li class="message-preview">
          <a href="#">
            <span class="avatar"><img src="http://placehold.it/50x50"/></span>
            <span class="name">John Smith:</span>
            <span class="message">Hey there, I wanted to ask you something...</span>
            <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
          </a>
        </li>
        <li class="divider"></li>
        <li class="message-preview">
          <a href="#">
            <span class="avatar"><img src="http://placehold.it/50x50"/></span>
            <span class="name">John Smith:</span>
            <span class="message">Hey there, I wanted to ask you something...</span>
            <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
          </a>
        </li>
        <li class="divider"></li>
        <li><a href="#">View Inbox <span class="badge">7</span></a></li>
      </ul>
    </li>
    <li class="dropdown alerts-dropdown" choice="hide">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Alerts <span class="badge">3</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#">Default <span class="label label-default">Default</span></a></li>
        <li><a href="#">Primary <span class="label label-primary">Primary</span></a></li>
        <li><a href="#">Success <span class="label label-success">Success</span></a></li>
        <li><a href="#">Info <span class="label label-info">Info</span></a></li>
        <li><a href="#">Warning <span class="label label-warning">Warning</span></a></li>
        <li><a href="#">Danger <span class="label label-danger">Danger</span></a></li>
        <li class="divider"></li>
        <li><a href="#">View All</a></li>
      </ul>
    </li>
    <li class="dropdown user-dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span var="username">John Smith</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="/admin/profile.html"><i class="fa fa-user"></i> Profile</a></li>
        <li choice="hide"><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">7</span></a></li>
        <li><a href="/admin/settings.html"><i class="fa fa-gear"></i> Settings</a></li>
        <li class="divider"></li>
        <li><a href="/logout.html"><i class="fa fa-power-off"></i> Log Out</a></li>
      </ul>
    </li>
    <li><a href="/logout.html"><i class="fa fa-power-off"></i> Log Out</a></li>
</ul>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, get_class($this));
        return $template;
    }
}




