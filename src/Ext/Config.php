<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext;

/**
 *
 *
 * @package Ext
 */
class Config extends \Mod\Config
{

    /**
     * Init the config
     *
     * @param string $sitePath
     * @param string $siteUrl
     */
    protected function init($sitePath = '', $siteUrl = '')
    {
        parent::init($sitePath, $siteUrl);

        // User auth config
        $this->parseConfigFile($this->getLibPath().'/auth-user/config/auth-user.php');
        $this->parseConfigFile($this->getLibPath().'/auth-user/config/dispatch.php');

        // Mail config
        $this->parseConfigFile($this->getLibPath().'/mail/config/mail.php');
        $this->parseConfigFile($this->getLibPath().'/mail/config/dispatch.php');

        // Local config files
        $this->parseConfigFile(dirname(dirname(__FILE__)).'/config/localSystem.php');
        $this->parseConfigFile(dirname(dirname(__FILE__)).'/config/dispatch.php');

        // User config prefs
        $this->parseConfigFile(dirname(dirname(__FILE__)).'/config/config.php');

        // Init the plugin lib
        $this->getPluginFactory();
    }


    /**
     * Return true if this is an lti requested page.
     * Generally this is if the request path starts with /lit/*
     *
     *
     * @return bool
     */
    public function isLti()
    {
        return preg_match('/^\/lti/', $this->getUri()->getPath(true));
    }



    //-------------- FACTORY METHODS ------------------


    /**
     * Get the current lti session data if it exists.
     * Returns null if not lti session exists
     *
     * @param null $data
     * @return \Ext\LtiSession
     */
    public function getLtiSession($data = null)
    {
        if (!$this->exists('res.lti.session')) {
            $this->set('res.lti.session', \Ext\LtiSession::getInstance($data));
        }
        return $this->get('res.lti.session');

    }

    /**
     * Get the LTI data connector
     *
     * @return \LTI_Data_Connector
     */
    public function getLtiDataConnector()
    {
        if (!$this->exists('res.lti.connector')) {
            $this->set('res.lti.connector', \LTI_Data_Connector::getDataConnector(new \LTI_Data_Connector_PDO($this->getDb())));
        }
        return $this->get('res.lti.connector');
    }


    /**
     * Get the plugin instance...
     *
     * @param string|array $callbackHandler
     * @return \LTI_Tool_Provider
     */
    public function getLtiToolProvider($callbackHandler = null)
    {
        if (!$this->exists('res.lti.toolProvider')) {
            $tool = new \LTI_Tool_Provider($callbackHandler, $this->getLtiDataConnector());
            $tool->setParameterConstraint('oauth_consumer_key', TRUE, 50);
            $tool->setParameterConstraint('resource_link_id', TRUE, 50);
            $tool->setParameterConstraint('user_id', TRUE, 50);
            $tool->setParameterConstraint('roles', TRUE);
            $this->set('res.lti.toolProvider', $tool);
        }
        return $this->get('res.lti.toolProvider');
    }























    /**
     * createPage
     *
     * @param string $pageClass
     * @param array $params
     * @return \Mod\pageClass
     * @throws \Tk\Exception
     */
    function createPage($pageClass, $params = array())
    {
        $page = parent::createPage($pageClass, $params);
        if ($page instanceof \Ext\PageAdmin) {
            $page->setActionPanelClass('\Ext\Ui\ActionsPanel');
            $page->setContentPanelClass('\Ext\Ui\ContentPanel');
        }
        return $page;
    }

    /**
     * Get the plugin instance...
     *
     * @return \Plg\Factory
     */
    public function getPluginFactory()
    {
        if (!$this->exists('res.pluginFactory')) {
            $this['res.pluginFactory'] = \Plg\Factory::getInstance();
        }
        return $this->get('res.pluginFactory');
    }




    /**
     * Get the main application executable controller
     * call execute() on this object to start the app
     *
     * @param \Tk\FrontController $frontController
     * @return \Ext\Application
     */
    public function getApplication($frontController = null)
    {
        if (!$this->exists('res.application')) {
            if (!$frontController) {
                $frontController = new \Tk\FrontController();
            }
            $obj = new Application($frontController);
            $this['res.application'] = $obj;
        }
        return $this->get('res.application');
    }


    /**
     * Get an instance of the URL Dispatcher
     *
     * @return \Tk\Dispatcher
     */
    public function getDispatcher()
    {
        if (!$this->exists('res.dispatcher')) {
            $obj = new \Tk\Dispatcher\Dispatcher($this->getRequest()->getUri());
            $obj->attach(new \Tk\Dispatcher\Ajax());
            $obj->attach($this->getDispatcherStatic());
            $obj->attach(new \Tk\Dispatcher\Module());
            $obj->attach(new \Ext\Dispatcher\LtiModule());
            $this['res.dispatcher'] = $obj;
        }
        return $this->get('res.dispatcher');
    }

}
