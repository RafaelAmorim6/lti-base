<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext;



/**
 * A mail factory object, just a place to compile all messages for the system....
 *
 * @package Ext
 */
class Application extends \Tk\Application
{

    /**
     * @var \Plg\Factory
     */
    protected $pluginFactory = null;

    /**
     * __construct
     *
     * @param \Tk\FrontController $frontController
     */
    public function __construct($frontController)
    {
        parent::__construct($frontController);
        $this->getConfig()->importFromDb();
    }


    /**
     *  startup
     *
     */
    protected function startup()
    {
        $config = $this->getConfig();

        // Init Global Objects
        $config->getRequest();
        $config->getSession();
        $config->getLog();
        if (method_exists($config, 'getPluginFactory')) {
            $this->pluginFactory = $config->getPluginFactory();
        }
    }


    /**
     * execute
     *
     */
    protected function run()
    {
        // Attach all FC commands
        $this->frontAttach(new \Tk\Controller\StartLog());

        // Add Build From Request Controllers
        $this->frontAttach(new \Mod\Controller\Dispatch());
        $this->frontAttach(new \Ext\Controller\PageClass());

        if ($this->getConfig()->isLti()) {
            $this->frontAttach(new \Ext\Controller\LtiLaunch());
        } else {
            $this->frontAttach(new \Usr\Controller\Auth());
        }

        $this->frontAttach(new \Mod\Controller\Theme());
        $this->frontAttach(new \Mod\Controller\BuildModules());
        
        // Add Check Security Controllers
        $this->frontAttach(new \Mod\Controller\Ssl());
        
        // Add Execution Controllers
        $this->frontAttach(new \Mod\Controller\Setup());
        $this->frontAttach(new \Mod\Controller\Execute());
        $this->frontAttach(new \Mod\Controller\Render());
        $this->frontAttach(new \Mod\Controller\WriteResponse());

        // Execute the Front Controller
        if ($this->pluginFactory)
            $this->frontController->attach(\Plg\Hook::create('preFcExecute', array('observer' => $this->frontController)));
        $this->frontController->execute();
        if ($this->pluginFactory)
            $this->frontController->attach(\Plg\Hook::create('postFcExecute', array('observer' => $this->frontController)));

    }

    /**
     * Attaches an SplObserver to
     * the ExceptionHandler to be notified
     * when an uncaught Exception is thrown.
     *
     * @param \Tk\Observer $obs      The observer to attach
     * @param string $name          (optional) The event name to attache the observer to
     * @param integer $idx          (optional) The position to insert the observer into
     * @return \Tk\Observer
     */
    public function frontAttach(\Tk\Observer $obs, $name = '', $idx = null)
    {
        $pre = 'pre'. $obs->getClassName(true);
        $post = 'post'. $obs->getClassName(true);
        if ($this->pluginFactory)
            $this->frontController->attach(\Plg\Hook::create($pre, array($obs->getClassName(true) => $obs)), $name, $idx);
        $this->frontController->attach($obs, $name, $idx);
        if ($this->pluginFactory)
            $this->frontController->attach(\Plg\Hook::create($post, array($obs->getClassName(true) => $obs)), $name, $idx);
        return $obs;
    }


    /**
     * Shutdown the application
     *
     */
    protected function shutdown()
    {
        exit();
    }

}
