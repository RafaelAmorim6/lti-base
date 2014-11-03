<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Module;

/**
 *
 *
 * @package Ext\Module
 */
class Contact extends \Mod\Module
{
    /**
     * @var \Form\Form
     */
    protected $form = null;

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
        $ff = \Form\Factory::getInstance();

        $this->form = $ff->createForm('Contact');
        $this->form->attach(new Send('send'), 'send')->setRedirectUrl(\Tk\Url::create('/contactUs.html'));
        $this->form->attach($ff->createEventLink('cancel'), 'cancel')->setRedirectUrl(\Tk\Url::create('/index.html'));

        $this->form->addField($ff->createFieldText('name'))->setRequired();
        $this->form->addField($ff->createFieldText('email'))->setRequired();
        $this->form->addField($ff->createFieldTextarea('comments'))->setRequired();
        $this->form->addField($ff->createFieldCaptcha('valid'))->setRequired();

        $this->addChild($ff->createFormRenderer($this->form), $this->form->getId());

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


    }

}

/**
 *
 *
 * @package Ext\Module
 */
class Send extends \Form\Event\Button
{

    /**
     * execute
     *
     * @param \Form\Form $form
     */
    public function update($form)
    {
        $config = \Tk\Config::getInstance();
        $data = $form->getObject();

        /* @var $field \Form\Field\Interface */
        foreach($form->getFieldList() as $field) {
            if ($field->isRequired() && !$field->getValue() && $field->getName() != 'valid') {
                $field->addError('Please enter some valid data.');
            }
        }

        if ($form->hasErrors()) {
            return;
        }

        $message = '<table border="0" cellpadding="2" cellspacing="0" >';
        $message .= '<tr><th> Field </th><th> Value </th></tr>';

        $skip = array('__submitId', 'valid', 'send');
        /* @var $field \Form\Field\Interface */
        foreach($form->getFieldList() as $field) {
            if (in_array($field->getName(), $skip)) {
                continue;
            }
            if ($field->getValue()) {
                $message .= '<tr><th class="label"> ' . $field->getLabel() . ': </th><td class="value"> ' . nl2br(htmlentities($field->getValue())) . ' </td></tr>';
            }
        }
        $message .= '</table>';

        $mail = new \Tk\Mail\Message();
        $mail->addTo($this->getConfig()->get('system.site.email'), $this->getConfig()->get('system.site.title'));
        $mail->setFrom($form->getFieldValue('email'), $form->getFieldValue('name'));
        $mail->setSubject('Contact Us Form Sent From ' . $this->getRequest()->getServer('HTTP_HOST'));

        $mail->setBody($mail->createHtmlTemplate($message));

        $mail->send();
        \Mod\Notice::addSuccess('Message Submited Successfully. Thank You!');
        $this->getUri()->redirect();
    }

}



