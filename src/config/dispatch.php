<?php

$dispatcher = $config->getDispatcherStatic();

//$dispatcher->add('/index.html', 'Ext\Module\Index');
$dispatcher->add('/admin/index.html', 'Ext\Module\Admin\Index');


$dispatcher->add('/admin/consumer/manager.html', 'Ext\Module\Admin\Consumer\Manager');
$dispatcher->add('/admin/consumer/edit.html', 'Ext\Module\Admin\Consumer\Edit');








