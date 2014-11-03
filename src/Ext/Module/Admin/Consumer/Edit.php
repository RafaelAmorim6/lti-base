<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Module\Admin\Consumer;

/**
 *
 *
 */
class Edit extends \Mod\Module
{
    /**
     * @var \LTI_Tool_Consumer
     */
    public $consumer = null;

    /**
     * @var \Form\Form
     */
    public $form = null;


    /**
     *
     *
     */
    public function __construct()
    {
        $this->setPageTitle('Edit Consumer');

        $this->consumer = new \LTI_Tool_Consumer(null, $this->getConfig()->getLtiDataConnector());
        $this->consumer->enabled = true;
        $this->consumer->secret = '';
        $key = $this->getRequest()->get('consumer_key');
        if ($this->getRequest()->get('key')) {
            $key = $this->getRequest()->get('key');
        }
        if ($key) {
            $this->consumer = new \LTI_Tool_Consumer($key, $this->getConfig()->getLtiDataConnector());
        }
    }

    /**
     * init
     */
    public function init()
    {
        $ff = \Form\Factory::getInstance();

        $this->form = $ff->createForm('Edit', $this->consumer);

        $this->form->attach(new Save('save', 'fa fa-refresh'))->setRedirectUrl($this->getBackUrl());
        $this->form->attach($ff->createEventLink('cancel'))->setRedirectUrl($this->getBackUrl());


        //$this->form->attach(new EditEvent());
        $this->form->addField($ff->createFieldText('name'))->setRequired();
        $cc = $this->form->addField($ff->createFieldText('key'))->setRequired();
//        if ($this->consumer->getKey()) {
//            $cc->setEnabled(false);
//        }
        $this->form->addField($ff->createFieldText('secret'))->setRequired();
        $this->form->addField($ff->createFieldText('css_path'));


        $this->form->addField($ff->createFieldCheckbox('enabled'));
        //$this->form->addField($ff->createFieldDate('enabledFrom'));
        //$this->form->addField($ff->createFieldDate('enabledTo'));
        //$this->form->addField($ff->createFieldCheckbox('protected'));

        $this->addChild($ff->createFormRenderer($this->form), $this->form->getId());

    }

    /**
     * execute
     */
    public function doDefault()
    {
        if (!$this->form->isSubmitted()) {
            // Load consumer values
            $this->form->setFieldValue('name', $this->consumer->name);
            $this->form->setFieldValue('key', $this->consumer->getKey());
            $this->form->setFieldValue('secret', $this->consumer->secret);
            $this->form->setFieldValue('css_path', $this->consumer->css_path);
            $this->form->setFieldValue('enabled', $this->consumer->enabled);
            //$this->form->setFieldValue('protected', $this->consumer->protected);
        }
    }

    /**
     * show
     */
    public function show()
    {
        $t = $this->getTemplate();

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
  <div var="Edit"></div>
</div>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, $this->getClassName());
        return $template;
    }
}

class Save extends \Form\Event\Button
{

    /**
     * __construct
     *
     * @param string $name
     * @param string $icon
     */
    public function __construct($name, $icon = 'fa fa-check')
    {
        parent::__construct($name, $icon);
    }

    /**
     * execute
     *
     * @param \Form\Form $form
     */
    public function update($form)
    {
        $object = new \LTI_Tool_Consumer($form->getFieldValue('key'), $this->getConfig()->getLtiDataConnector());

        // Load object
        $object->name = $form->getFieldValue('name');
        $object->secret = $form->getFieldValue('secret');
        $object->enabled = $form->getFieldValue('enabled');
        $object->protected = $form->getFieldValue('protected');
        $object->css_path = $form->getFieldValue('css_path');
        $object->updated = \Tk\Date::create()->getTimestamp();

        // validate object
        if (!$object->name) {
            $form->addFieldError('name', 'Please supply a valid consumer name');
        }
        if (!preg_match('/^[a-z0-9_-]{1,64}$/i', $object->getKey())) {
            $form->addFieldError('consumerKey', 'Invalid characters used in key field');
        }
        if (!preg_match('/^[a-z0-9]{1,64}$/i', $object->secret)) {
            $form->addFieldError('secret', 'Invalid characters used in secret field');
        }

        if ($form->hasErrors()) {
            if (!\Mod\Notice::hasMessages()) {
                \Mod\Notice::addError('The form contains errors.');
            }
            return;
        }

        if (!$this->getConfig()->getLtiDataConnector()->Tool_Consumer_save($object)) {
            if (!\Mod\Notice::hasMessages()) {
                \Mod\Notice::addError('Error saving consumer to DB.');
            }
            return;
        }

        //$this->getRedirectUrl()->set('key', $object->getKey())->redirect();
        $this->getRedirectUrl()->redirect();

    }

}
