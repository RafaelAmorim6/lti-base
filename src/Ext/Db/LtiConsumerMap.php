<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Db;

/**
 *
 *
 */
class _LtiConsumerMap extends \Tk\Db\Mapper
{

    /**
     * Create the data map
     *
     * @return \Tk\Model\DataMap
     */
    protected function makeDataMap()
    {
        $dataMap = new \Tk\Model\DataMap(__CLASS__);
        $this->setTable('ltiConsumer');

        $dataMap->addIdProperty(\Tk\Model\Map\Integer::create('id'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('consumerKey'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('name'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('secret'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('ltiVersion'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('consumerName'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('consumerVersion'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('consumerGuid'));
        $dataMap->addProperty(\Tk\Model\Map\String::create('cssPath'));
        $dataMap->addProperty(\Tk\Model\Map\Boolean::create('protected'));
        $dataMap->addProperty(\Tk\Model\Map\Boolean::create('enabled'));
        $dataMap->addProperty(\Tk\Model\Map\Date::create('enabledFrom'));
        $dataMap->addProperty(\Tk\Model\Map\Date::create('enabledTo'));
        $dataMap->addProperty(\Tk\Model\Map\Date::create('lastAccess'));
        $dataMap->addProperty(\Tk\Model\Map\Date::create('modified'));
        $dataMap->addProperty(\Tk\Model\Map\Date::create('created'));

        return $dataMap;
    }



    /**
     * Find a consumer by its key
     *
     * @param string $key
     * @return \Ext\Db\LtiConsumer
     */
    public function findByConsumerKey($key)
    {
        $where = sprintf('`consumerKey` = %s ', $this->getDb()->quote($key));
        return $this->selectMany($where)->current();
    }

    /**
     * Find filtered records
     *
     * @param array $filter
     * @param \Tk\Db\Tool $tool
     * @return \Tk\Db\ArrayObject
     */
    public function findFiltered($filter = array(), $tool = null)
    {
        $where = '';
        if (!empty($filter['keywords'])) {
            $kw = '%' . $this->getDb()->escapeString($filter['keywords']) . '%';
            $w = '';
            $w .= sprintf('`consumerKey` LIKE %s OR ', $this->getDb()->quote($kw));
            $w .= sprintf('`name` LIKE %s OR ', $this->getDb()->quote($kw));
            if (is_numeric($filter['keywords'])) {
                $id = (int)$filter['keywords'];
                $w .= sprintf('`id` = %d OR ', $id);
            }
            if ($w) {
                $where .= '(' . substr($w, 0, -3) . ') AND ';
            }
        }

        if (!empty($filter['consumerKey'])) {
            $where .= sprintf('`consumerKey` = %s AND ', $this->getDb()->quote($filter['userId']));
        }
        if ($where) {
            $where = substr($where, 0, -4);
        }
        return $this->selectMany($where, $tool);
    }



}