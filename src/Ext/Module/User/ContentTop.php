<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Module\User;

/**
 *
 *
 * @package Ext\Module\User
 */
class ContentTop extends \Mod\Module
{

    /**
     * __construct
     */
    public function __construct()
    {

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

        $template->insertText('username', '('.$this->getConfig()->getUser()->username.')');
        $template->insertText('fullname', $this->getConfig()->getUser()->publicName);

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
<div class="user-content-top">
  <div class="container">
    <h1><span var="fullname"></span> <small var="username"></small></h1>
    <div class="pull-right" var="misc" choice="show"></div>
  </div>
</div>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, get_class($this));
        return $template;
    }
}




