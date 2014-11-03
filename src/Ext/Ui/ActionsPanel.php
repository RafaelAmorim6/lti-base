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
class ActionsPanel extends \Mod\Menu\Renderer
{

    /**
     * @var integer
     */
    protected $maxDepth = 1;



    /**
     * iterate
     *
     * @param array $list
     * @param integer $nest
     * @return Dom\Template
     */
    protected function iterate($list, $nest=0)
    {
        if ($this->maxDepth > 0 && $nest >= $this->maxDepth) {
            return;
        }
        $ul = $this->getTemplate()->getRepeat('ul');

        /* @var $item \Mod\Menu\Item */
        foreach ($list as $item) {
            $request = $this->getRequest()->getRequestUri();
            $url = \Tk\Url::create($item->url);

            $li = $ul->getRepeat('li');

            if ($item->findByHref($request, true)) {
                //$li->addClass('li', 'active');
            }

            if ($item->title) {
                $li->setAttr('a', 'title', $item->title);
            }
            if ($item->target) {
                $li->setAttr('a', 'target', $item->target);
            }
            if ($item->rel) {
                $li->setAttr('a', 'rel', $item->rel);
            }
            if ($item->cssClass) {
                $li->addClass('a', $item->cssClass);
            }

            if ($item->icon) {
                $li->addClass('icon', $item->icon);
                $li->setChoice('icon');
            }

            $li->insertText('a-text', $item->text);
            $li->setAttr('a', 'href', $url->toString());

//            if ($item->hasChildren()) {
//                $li->addClass('li', 'parent');
//                $ul2 = $this->iterate($item->children, $nest++);
//                $li->appendTemplate('li', $ul2);
//            }
            $li->appendRepeat();
        }

        return $ul;
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
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-briefcase"></i> Actions</h3>
    <div class="buttons" choice="buttons"><a href="#" class="btn btn-mini"><i class="icon-remove"></i></a></div>
  </div>
  <div class="panel-body">
    <ul var="ul" repeat="ul" class="tk-iconNav">
      <li var="li" repeat="li" class=""><a href="#" var="a"><i choice="icon" var="icon"></i> <span var="a-text"></span></a></li>
    </ul>
  </div>
</div>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, $this->getClassName());
        return $template;
    }
}





