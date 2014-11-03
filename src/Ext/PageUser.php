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
class PageUser extends Page
{
    /**
     * @var Module\User\ContentTop
     */
    public $contentTop = null;


    public function __construct($theme = null)
    {
        parent::__construct($theme);
        $this->setSecure(true);
        $this->setPermission(\Tk\Auth\Auth::P_USER);

        $this->contentTop = new Module\User\ContentTop();
        $this->addChild($this->contentTop, \Mod\Page::VAR_PAGE_HEADER);
    }

    /**
     * Get the content top
     *
     * @return Module\User\ContentTop
     */
    public function getContentTop()
    {
        return $this->contentTop;
    }

    /**
     * show
     */
    public function show()
    {
        $template = $this->getTemplate();

        

    }

}
