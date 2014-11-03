<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext;

/**
 * A base page object
 *
 * @package Ext
 */
class PagePublic extends Page
{

    public function __construct($theme = null)
    {
        parent::__construct($theme);
    }

    /**
     * show
     */
    public function show()
    {
        $template = $this->getTemplate();
        
        

    }

}
