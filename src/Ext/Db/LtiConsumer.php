<?php
/**
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Db;


/**
 *
 *
 */
class _LtiConsumer extends \Tk\Db\Model
{

    public $id = '';
    public $consumerKey = '';
    public $name = '';
    public $secret = '';
    public $ltiVersion = '';
    public $consumerName = '';
    public $consumerVersion = '';
    public $consumerGuid = '';
    public $cssPath = '';
    public $protected = false;
    public $enabled = true;
    /**
     * @var \Tk\Date
     */
    public $enabledFrom = null;
    /**
     * @var \Tk\Date
     */
    public $enabledTo = null;
    /**
     * @var \Tk\Date
     */
    public $lastAccess = null;
    /**
     * @var \Tk\Date
     */
    public $modified = null;
    /**
     * @var \Tk\Date
     */
    public $created = null;



    public function __construct()
    {
        $this->modified = \Tk\Date::create();
        $this->created = \Tk\Date::create();
    }

}


/**
 *
 *
 */
class LtiConsumerValidator extends \Tk\Validator
{

    public function validate()
    {
        if (!$this->obj->name) {
            $this->addError('name', 'Please supply a valid consumer name');
        }
        if (!preg_match('/^[a-z0-9]{1,64}$/i', $this->obj->consumerKey)) {
            $this->addError('consumerKey', 'Invalid characters used in key');
        }
        if (!preg_match('/^[a-z0-9]{1,64}$/i', $this->obj->secret)) {
            $this->addError('secret', 'Invalid characters used in key');
        }
        
    }

}