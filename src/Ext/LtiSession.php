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
 *
 */
class LtiSession extends \Tk\Registry
{
    const ROLE_PUBLIC = 'public';
    const ROLE_STUDENT = 'student';
    const ROLE_STAFF = 'staff';
    const ROLE_ADMIN = 'admin';

    /**
     * @var \Tk\Config
     */
    static $instance = null;

// Uses magic methods to obtain these (Could be cleaner???)
//    public $consumerKey = '';
//    public $resourceId = '';
//    public $userConsumerKey = '';
//    public $userId = '';
//    public $permissions = array('public');
//
//    public $ldapUser = array();
//    public $launchRequest = array();



    /**
     * __construct
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->init($data);
    }


    /**
     * Get an instance of this object
     *
     * @param array $data
     * @return \Ext\LtiSession
     */
    static function getInstance($data = null)
    {
        if (self::$instance == null) {
            if ($data) {
                \Tk\Config::getInstance()->getSession()->set('res.lti.session.data', $data);
            }
            self::$instance = new self(\Tk\Config::getInstance()->getSession()->get('res.lti.session.data'));
        }
        return self::$instance;
    }


    /**
     *
     * @param $data
     * @throws \Tk\Exception
     */
    protected function init($data)
    {
        if (!$data) {
            throw new \Tk\Exception('Error initialising LTI session.');
        }

        $this->mergeArray($data['launchRequest']);
        $this->mergeArray($data);
        $this->importFromDb();

    }


    /**
     * load any data from a table and group combo
     * into the config.
     *
     * @param string $table
     * @param string $group
     * @return $this
     */
    public function importFromDb($table = 'config', $group = '--')
    {
        $group = $this->consumerKey;
        return parent::importFromDb($table, $group);
    }

    /**
     *
     *
     * @param null $arr
     * @param string $table
     * @param string $group
     * @return $this
     */
    public function exportToDb($arr = null, $table = 'config', $group = '--')
    {
        $group = $this->consumerKey;

        $reg = \Tk\Db\Registry::createDbRegistry($table, $group);
        $reg->importFormArray($arr);

        //$reg->saveToDb();
        foreach ($reg->getArray() as $k => $v) {
            if (!preg_match('/^lti-/', $k)) continue;
            $reg->dbSet($k, $v);
        }
        $this->mergeArray($arr);
        return $this;
    }


    /**
     *
     */
    public function save()
    {

    }

    /**
     *
     */
    protected function load()
    {

    }




    /**
     * Get the launch request array
     *
     * @return array
     */
    public function getLaunchRequest()
    {
        return $this->launchRequest;
    }

    /**
     * Test if the current session user has teh supplied role
     *
     * @param $role
     * @return bool
     */
    public function hasPermission($role)
    {
        return in_array($role, $this->permissions);
    }

    public function isStudent()
    {
        return $this->hasPermission(self::ROLE_STUDENT);
    }

    public function isStaff()
    {
        return $this->hasPermission(self::ROLE_STAFF);
    }

    public function isAdmin()
    {
        return $this->hasPermission(self::ROLE_ADMIN);
    }


    /**
     * A unique ID for the course from the LMS
     *
     * @return string
     */
    function getCourseId()
    {
        $id = $this->consumerKey . ':' . $this->context_id;
        //$id = md5($id);
        return $id;
    }


    /**
     * Update user Gradebook
     * A value 0 or less will delete the result
     *
     * @param $userId
     * @param float $grade
     * @throws \Tk\Exception
     * @return $this
     */
    public function setGrade($userId, $grade = 0.0)
    {
        $grade = floatval($grade);
        $consumer = new \LTI_Tool_Consumer($this->consumerKey, $this->getConfig()->getLtiDataConnector());
        $resource = new \LTI_Resource_Link($consumer, $this->resourceId);
        $user = new \LTI_User($resource, $userId);

        if ($this->isAdmin() || $this->isStaff()) {
            if($grade > 0) {
                $ltiOutcome = new \LTI_Outcome(NULL, $grade);
                if (!$resource->doOutcomesService(\LTI_Resource_Link::EXT_WRITE, $ltiOutcome, $user)) {
                    throw new \Tk\Exception('Error writing to grade-center.');
                }
            } else {
                $ltiOutcome = new \LTI_Outcome();
                if (!$resource->doOutcomesService(\LTI_Resource_Link::EXT_DELETE, $ltiOutcome, $user)) {
                    throw new \Tk\Exception('Error deleting grade from grade-center.');
                }
            }
        }
        return $this;
    }

    /**
     * Get the grade
     *
     * @param $userId
     * @throws \Tk\Exception
     * @return float
     */
    public function getGrade($userId)
    {
        $consumer = new \LTI_Tool_Consumer($this->consumerKey, $this->getConfig()->getLtiDataConnector());
        $resource = new \LTI_Resource_Link($consumer, $this->resourceId);
        $user = new \LTI_User($resource, $userId);
        $ltiOutcome = new \LTI_Outcome();

        if (!$resource->doOutcomesService(\LTI_Resource_Link::EXT_READ, $ltiOutcome, $user)) {
            throw new \Tk\Exception('Error reading from grade-center.');
        }
        return $ltiOutcome->getValue();
    }




}
