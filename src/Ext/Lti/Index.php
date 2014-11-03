<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Lti;

/**
 *
 *
 */
class Index extends \Mod\Module
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

        $ltiSes = $this->getConfig()->getLtiSession();
        foreach($ltiSes->permissions as $p) {
            $template->setChoice($p);
        }



        $js = <<<JS
jQuery(function($) {
  
});
JS;
        //$template->appendJs($js);

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
<div>
  <h1>LTI Base Home Page</h1>
  <p><strong>Your Current Permissions:</strong></p>
  <ul>
    <li choice="public">Public</li>
    <li choice="student">Student</li>
    <li choice="staff">Staff</li>
    <li choice="admin">Admin</li>
  </ul>


<hr/>
  <div class="row">
    <div class="col-sm-4">
      <h2>Cell 1</h2>
      <p>
        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac
        cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit
        amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
      </p>
      <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
    </div>
    <div class="col-sm-4">
      <h2>Cell 2</h2>
      <p>
        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac
        cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
        Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
      </p>
      <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
   </div>
    <div class="col-sm-4">
      <h2>Cell 3</h2>
      <p>
        Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam.
        Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus
        commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
      </p>
      <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
    </div>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>z
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, $this->getClassName());
        return $template;
    }
}




