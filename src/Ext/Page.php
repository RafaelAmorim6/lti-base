<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext;

/**
 * Module are the controller and view for the model or data
 * It is done this way for code effecientcy and the ability
 * to create a Module execution tree
 *
 *
 * @package Mod
 */
class Page extends \Mod\Page
{


    /**
     * __construct
     *
     * @param \Mod\Theme $theme
     */
    public function __construct(\Mod\Theme $theme = null)
    {
        parent::__construct($theme);
        $this->addChild(\Mod\Notice::getInstance(), self::VAR_PAGE_CONTENT_HEAD);
        $this->setPermission(\Tk\Auth\Auth::P_PUBLIC);
    }

    /**
     *
     * show
     */
    public function render()
    {
        $template = $this->getTemplate();

        $template->setTitleText($this->getConfig()->getSiteTitle() . ' - ' . $template->getTitleText());
        $template->insertText('__pageTitle__', $this->getTitle());
        $template->insertText('__siteTitle__', $this->getConfig()->getSiteTitle());
        $template->insertText('__version__', $this->getConfig()->get('system.site.version'));
        
        if ($this->getConfig()->getUser() && is_object($this->getConfig()->getUser()))  {
            $template->insertText('__username__', $this->getConfig()->getUser()->username);
            $template->insertText('__public__', $this->getConfig()->getUser()->username);
            $template->setAttr('__home__', 'href', \Tk\Url::create($this->getConfig()->getUser()->getHomePath() . '/index.html'));
            $template->setChoice('__logged-in__');
        } else {
            $template->setChoice('__logged-out__');
        }

        $siteUrl = $this->getConfig()->getSiteUrl();
        $tplUrl = $this->getConfig()->getSelectedThemeUrl();
        $dataUrl = $this->getConfig()->getDataUrl();
        // Deprecated, should not have public access to lib folder
        $libUrl = $this->getConfig()->getLibUrl();
        
        // Show general javascripts and styles.
        $js = <<<JS
// PROJECT CONSTANTS
var config = {
  siteUrl  : "$siteUrl",
  dataUrl  : "$dataUrl",
  libUrl   : "$libUrl",
  themeUrl : "$tplUrl"
};
JS;
        $template->appendJs($js);
        
        $ret = parent::render();

        if ($this->getConfig()->exists('system.releaseMode')) {
            $template->setChoice($this->getConfig()->get('system.releaseMode'));
        }
        

        // Any Page Debug Settings
        if ($this->getConfig()->isDebug() && !$this->getConfig()->isLive()) {
            $template->setTitleText('DBG - ' . $template->getTitleText());
            if ($this->getConfig()->isDev()) {
                $template->setTitleText('DEV - ' . $template->getTitleText());
            } else if ($this->getConfig()->isTest()) {
                $template->setTitleText('TEST - ' . $template->getTitleText());
            }
        }

        return $ret;
    }





}
