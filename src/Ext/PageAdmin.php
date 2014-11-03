<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext;
use Mod\AdminPageInterface;

/**
 *
 *
 * @package Ext
 */
class PageAdmin extends AdminPageInterface
{

    /**
     *
     * show
     */
    public function show()
    {
        $template = $this->getTemplate();


        $template->setTitleText($this->getConfig()->getSiteTitle() . ' - ' . $template->getTitleText());
        $template->insertText('__pageTitle__', $this->getTitle());
        $template->insertText('__siteTitle__', $this->getConfig()->getSiteTitle());
        $template->insertText('__version__', $this->getConfig()->get('system.site.version'));

        $template->insertText('__username__', $this->getConfig()->getUser()->username);
        $template->insertText('__public__', $this->getConfig()->getUser()->username);
        $template->setAttr('__home__', 'href', \Tk\Url::createHomeUrl('/index.html'));

        $siteUrl = $this->getConfig()->getSiteUrl();
        $tplUrl = $this->getConfig()->getSelectedThemeUrl();
        $dataUrl = $this->getConfig()->getDataUrl();
        // Deprecated, shold not have public access to lib folder
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


        // Any Page Debug Settings
        if ($this->getConfig()->isDebug() && !$this->getConfig()->isLive()) {
            $template->setTitleText('DBG - ' . $template->getTitleText());
            if ($this->getConfig()->isDev()) {
                $template->setTitleText('DEV - ' . $template->getTitleText());
            } else if ($this->getConfig()->isTest()) {
                $template->setTitleText('TEST - ' . $template->getTitleText());
            }
        }
    }

}
