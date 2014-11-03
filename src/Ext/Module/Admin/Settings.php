<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Module\Admin;

use Mod\AdminPageInterface;

/**
 *
 *
 * @package Ext\Module\Admin
 */
class Settings extends \Mod\Module
{


    /**
     * @var \Form\Form
     */
    protected $form = null;

    
    public function __construct()
    {
        $this->setPageTitle('Site Settings');
    }

    /**
     * init
     */
    public function init()
    {

        $ff = \Form\Factory::getInstance();

        $arr = $this->getConfig()->exportFormArray();
        $this->form = $ff->createForm('Settings', $arr);

        $se = new SettingsSaveEvent('update', 'icon-arrow-left icon-white');
        $this->form->attach($se->setRedirectUrl(\Tk\Url::createHomeUrl('/index.html')), 'update');
        $se = new SettingsSaveEvent('save');
        $this->form->attach($se->setRedirectUrl(\Tk\Request::getInstance()->getRequestUri()), 'save');
        $this->form->attach($ff->createEventLink('cancel'), 'cancel')->setRedirectUrl(\Tk\Url::createHomeUrl('/index.html'));

        // Site
        $this->form->addField($ff->createFieldText('system-site-title'))->setTabGroup('Site')->setRequired()->setLabel('Site Title');

        $this->form->addField($ff->createFieldText('system-site-email'))->setTabGroup('Site')->setLabel('Site Email')->setRequired()->setNotes('This email is used for site notifications like user sign-up, contact forms, etc.');
        $this->form->addField($ff->createFieldText('system-site-email-support'))->setTabGroup('Site')->setLabel('Support Email')->setRequired()->setNotes('This email is used for any site support forms or errors that are generated.');
        $this->form->addField($ff->createFieldText('system-site-email-dev'))->setTabGroup('Site')->setLabel('Developer Email')->setRequired()->setNotes('This email is used for any site error emails and notifications to developers.');

        $this->form->addField($ff->createFieldText('system-google-apikey'))->setTabGroup('Site')->setRequired()->setLabel('Google API Key');

        $this->form->addField($ff->createFieldTimezoneSelect('system-timezone'))->setTabGroup('Site')->setRequired()->prependOption('-- Select --', '')->setLabel('Timezone');

        $this->form->addField($ff->createFieldText('system-site-proxy'))->setTabGroup('Site')->setLabel('Site Proxy')->setNotes('Only set this if you require a proxy to access the outside network.');

        $this->form->addField($ff->createFieldCheckbox('system-enableSsl'))->setTabGroup('Site')->setLabel('Enable SSL')->setNotes('Only check this option if you have a valid SSL cert installed.');



        // Maintenance
        $this->form->addField($ff->createFieldCheckbox('system-maintenance-enable'))->setTabGroup('Maintenance')->setLabel('Enable')->setNotes('If enabled, the site is disabled with only the access given to those below.');
        $this->form->addField($ff->createFieldTextarea('system-maintenance-message'))->addStyle('width', '600px')->addStyle('height', '100px')->setTabGroup('Maintenance')->setLabel('Message')->setNotes('Enter the message (HTML) that will be displayed when in maintenance mode.');
        $this->form->addField($ff->createFieldText('system-maintenance-access-ip'))->setTabGroup('Maintenance')->setLabel('IP Access')->setNotes('Enter a comma separated list of allowable IP addresses in maintenance mode');

        $list = array(
            array('Admin', \Tk\Auth\Auth::P_ADMIN),
            array('User', \Tk\Auth\Auth::P_USER) );
        $this->form->addField($ff->createFieldCheckbox('system-maintenance-access-permission', $list))->setTabGroup('Maintenance')->setLabel('Permission Access')->setNotes('Select user permissions allowed to access the site in maintenance mode');

        $this->addChild($ff->createFormRenderer($this->form), $this->form->getId());

    }

    /**
     * doDefault
     */
    public function doDefault()
    {
        if (!$this->form->isSubmitted()) {
            $this->form->setFieldValue('system-maintenance-access-permission', explode(',', $this->getConfig()->get('system.maintenance.access.permission')));
        }
    }

    /**
     * show
     */
    public function show()
    {
        $template = $this->getTemplate();


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
<div class="Settings_Edit">

  <div var="Settings"></div>

</div>
HTML;
        $template = \Mod\Dom\Loader::load($xmlStr, get_class($this));
        return $template;
    }

}

/**
 *
 *
 * @package Ext\Module\Staff
 */
class SettingsSaveEvent extends \Form\Event\Button
{

    /**
     * execute
     *
     * @param Tk_Form $form
     */
    public function update($form)
    {
        if (!preg_match('/.{1,64}/', $form->getFieldValue('system-site-title'))) {
            $form->addFieldError('system-site-title', 'Please enter a title. (1-64 length)');
        }
        if (!preg_match(\Tk\Validator::REG_EMAIL, $form->getFieldValue('system-site-email'))) {
            $form->addFieldError('system-site-email', 'Please enter a valid email address');
        }
        if (!$form->getFieldValue('system-timezone')) {
            $form->addFieldError('system-timezone', 'Please enter a valid timezone');
        }

        if ($form->hasErrors()) {
            \Mod\Notice::addError('The form has errors. No data has been modified.');
            return;
        }
        
        $this->getConfig()->exportToDb(\Tk\ArrayObject::createArray($form->getValuesArray()));

        \Mod\Notice::addSuccess('The site settings have been saved.', 'Settings Saved');

    }

}

