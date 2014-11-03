<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Ui;

/**
 *
 *
 * @package Ext
 */
class ContentPanel extends \Mod\Renderer
{
    /**
     * @var \Mod\Module
     */
    protected $module = null;

    protected $span = '';

    protected $icon = '';

    protected $padding = true;

    protected $tabUrls = array();

    protected $compareQuery = false;


    /**
     * construct
     *
     * @param \Mod\Module $module
     * @param string $span
     * @param string $icon
     */
    public function __construct(\Mod\Module $module, $span = 'span12', $icon = 'fa fa-bars')
    {
        $this->module = $module;
        $this->span = $span;
        $this->icon = $icon;
    }

    /**
     * create
     *
     * @param \Mod\Module $module
     * @param string $span
     * @param string $icon
     * @return \Ext\Box
     */
    static function create(\Mod\Module $module, $span = 'span12', $icon = 'fa fa-bars')
    {
        return new self($module, $span, $icon);
    }

    /**
     * Should we have padding around the box
     *
     * @param boolean $b
     * @return $this
     */
    public function setPadding($b = true)
    {
        $this->padding = $b;
        return $this;
    }

    /**
     * Add a tab url to the widget box
     *
     * @param $name
     * @param \Tk\Url $url
     * @return \Ext\Box
     */
    public function addTabUrl($name, \Tk\Url $url)
    {
        $this->tabUrls[$name] = $url;
        return $this;
    }

    /**
     * addTabList
     *
     * @param array $array
     * @return \Ext\Box
     */
    public function addTabList($array)
    {
        foreach ($array as $k => $v) {
            $this->addTabUrl($k, $v);
        }
        return $this;
    }

    /**
     * By default the selected tab is found by looking at the URI path only
     * By setting this to true it will compare the entire URI and query string.
     *
     * @param bool $b
     * @return $this
     */
    public function enableTabCompareQuery($b = true)
    {
        $this->compareQuery = $b;
        return $this;
    }


    /**
     * Iterate through the page's children and
     * render their template and append them to their canvas areas
     *
     * @return string
     */
    public function show()
    {
        $template = $this->makeTemplate();

        if ($this->module->getPage()->getTitle()) {
            $template->insertText('title', $this->module->getPage()->getTitle());
        }
        if ($this->module->getTitle()) {
            $template->insertText('title', $this->module->getTitle());
        }
        if ($this->icon) {
            $template->setChoice('icon');
            $template->setAttr('icon', 'class', $this->icon);
        }
        if (!$this->padding) {
            $template->addClass('widget', 'nopad');
        }


        $css = <<<CSS
.w-tabs {
  margin:  8px 10px 0px 10px;
  padding: 0px 0px 0px 0px;
  float: right;
  list-style: none;
  line-height: 1;

}
.w-tabs li {
  margin:  0px 0px 0px 0px;
  padding: 0px 0px 0px 0px;
  display: inline-block;
  border: solid;
  border-width: 1px 1px 0 1px;
  border-color: #999;
  line-height: 1;
}
.w-tabs li a {
  margin:  0px 0px 0px 0px;
  padding: 5px 10px 5px 10px;
  display: inline-block;
  line-height: 1;
  text-decoration: none;
}
.w-tabs li.selected a,
.w-tabs li a:hover {
  background-color: #FFF;
  text-decoration: none;
}

CSS;
        $template->appendCss($css);

        if (count($this->tabUrls)) {
            foreach($this->tabUrls as $name => $url) {
                $li = $template->getRepeat('li');
                $li->insertText('a', $name);
                $li->setAttr('a', 'href', $url->toString());
                if ($this->compareQuery) {
                    if ($this->getUri()->toString() == $url->toString()) {
                        $li->addClass('li', 'selected');
                    }
                } else {
                    if ($this->getUri()->getPath(true) == $url->getPath(true)) {
                        $li->addClass('li', 'selected');
                    }
                }
                $li->appendRepeat();
            }
            $template->setChoice('tabs');
        }


        // Have to stealthly insert the box into the module template without disturbing Dom\Template node references.
        // Tricky Hey!->firstChild->nextSibling->firstChild->nextSibling->nextSibling->nextSibling
        $this->getTemplate()->setHeaderList(array_merge($this->getTemplate()->getHeaderList(), $template->getHeaderList()));
        $bDoc = $template->getDocument();
        $mDoc = $this->getTemplate()->getDocument(false);
        $bNode = $mDoc->importNode($bDoc->documentElement, true);
        //$ctnNode = $bNode->firstChild->nextSibling->firstChild->nextSibling->firstChild->nextSibling->nextSibling->nextSibling;

        // TODO: Check here this could be the problem
        $ctnNode = $bNode->firstChild->nextSibling->nextSibling->nextSibling;
        while ($mDoc->documentElement->childNodes->length > 1) {
            if (!$mDoc->documentElement->childNodes->item(0)->isSameNode($bNode))
                $ctnNode->appendChild($mDoc->documentElement->childNodes->item(0));
        }
        $mDoc->documentElement->appendChild($bNode);

    }



    /**
     * makeTemplate
     *
     * @return \Dom\Template
     */
    public function makeTemplate()
    {
        $xmlStr = <<<HTML
<?xml version="1.0" encoding="UTF-8"?>
<div class="panel panel-default" var="widget">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-bars" var="icon" choice="icon"></i> <span var="title">Panel title</span></h3>
    <ul class="w-tabs" choice="tabs">
      <li repeat="li" var="li"><a href="#edit" var="a">Tab</a></li>
    </ul>
    <div class="buttons" choice="buttons"><a href="#" class="btn btn-xs"><i class="fa fa-times"></i></a></div>
  </div>
  <div class="panel-body" var="content"></div>
</div>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, $this->getClassName());
        return $template;
    }
}