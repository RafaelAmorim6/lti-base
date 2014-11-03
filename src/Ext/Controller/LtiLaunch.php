<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Controller;

/**

 * @package Ext\Controller
 */
class LtiLaunch extends \Tk\Object implements \Tk\Controller\Iface
{

    /**
     * Call after dispatcher is executed
     *
     * @param \Tk\FrontController $obs
     * @throws \Tk\Exception
     */
    public function update($obs)
    {
        tklog($this->getClassName().'::update()');
        if (!$this->getConfig()->isLti()) {
            return;
        }


        if (preg_match('/^\/lti\/launch.html/', $this->getUri()->getPath(true))) {
            $toolProvider = $this->getConfig()->getLtiToolProvider( array('connect' => array($this, 'doLaunch')) );
            $toolProvider->execute();
            if ($this->reason) {
                throw new \Tk\Exception($this->reason);
            }
            throw new \Tk\Exception('Access Error: Please check your `Key` and `Secret` values are correct.');
        }
        vd($this->getConfig()->getLtiSession());
    }

    /**
     *
     *
     * @param \LTI_Tool_Provider $toolProvider
     * @return bool|string
     */
    public function doLaunch($toolProvider)
    {
        tklog('---> doLaunch() ');
        // Check the user has an appropriate role
        if ($toolProvider->user->isLearner() || $toolProvider->user->isStaff() || $toolProvider->user->isAdmin()) {
            // Initialise the user/Lti session
            $permissions = array();
            if ($toolProvider->user->isLearner()) {
                $permissions[] = 'student';
            }
            if ($toolProvider->user->isStaff()) {
                $permissions[] = 'staff';
            }
            if ($toolProvider->user->isAdmin()) {
                $permissions[] = 'admin';
            }

            $ldapUser = null;
            if (isset($_POST['lis_person_contact_email_primary'])) {
                // Enable if using LDAP for extra data
//                $ldapUser = $this->getLdapUser($_POST['lis_person_contact_email_primary']);
            }
            $data = array(
                'consumerKey'      => $toolProvider->consumer->getKey(),
                'resourceId'       => $toolProvider->resource_link->getId(),
                'userConsumerKey'  => $toolProvider->user->getResourceLink()->getConsumer()->getKey(),
                'userId'           => $toolProvider->user->getId(),
                'permissions'      => $permissions,
                'ldapUser'         => $ldapUser,
                'launchRequest'    => array_merge($_POST, $_GET)    // NOTE: Using $_POST/$_GET to avoid junk values from $_REQUEST
            );

            \Ext\LtiSession::getInstance($data);
            \Tk\Url::create('/lti/index.html')->redirect();
        }
        $toolProvider->reason = 'Invalid role.';
        return false;
    }



    private function getLdapUser($email)
    {
        if (!$this->getConfig()->get('system.auth.ldap.enable')) {
            return;
        }
        $username = 'mifsudm';
        $password = '';

        $ldapUri = $this->getConfig()->get('system.auth.ldap.uri');
        $ldapPort = $this->getConfig()->get('system.auth.ldap.port');
        $ldapBaseDn = $this->getConfig()->get('system.auth.ldap.baseDn');
        $ldapFilter = 'mail='.$email;

        // LDAP Bind RDN filter
        $ldapBindRdn = 'uid=$username,'.$ldapBaseDn;
        $ldapBindRdn = str_replace('$username', $username, $ldapBindRdn);


        $ldap = ldap_connect($ldapUri, $ldapPort);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        if (!$ldap) {
            throw new \Tk\Auth\Exception('Failed to connect to LDAP service: ' . $ldapUri);
        }

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        if (!ldap_start_tls($ldap)) {
            $e = new \Tk\Auth\Exception('Failed to secure LDAP service ' . $ldapUri);
            tklog('LDAP: '.ldap_error($ldap));
            throw $e;
        }
        if ($password && $username) {
            if (!ldap_bind($ldap, $ldapBindRdn, $password)) {
                $e = new \Tk\Auth\Exception('Failed to authenticate to LDAP service ' . $ldapUri);
                tklog('LDAP: '.ldap_error($ldap));
                throw $e;
            }
        }
        $results = ldap_search($ldap, $ldapBaseDn, $ldapFilter);
        $entries = ldap_get_entries($ldap, $results);
        $entries = $this->ldapProcessEntries($entries);

        if (isset($entries[0]))
            return $entries[0];
    }


    /**
     * Flatten the ldap returned entries array
     *
     * @param $entries
     * @return array
     */
    private function ldapProcessEntries($entries)
    {
        $arr = array();
        foreach ($entries as $i => $d) { // Foreach returned person
            $person = array();
            foreach ($d as $k => $v) {  // Get each key value pair for the person
                if (preg_match('/^[0-9]+$/', $k) || $k == 'count' || $k == 'objectclass') {
                    continue;
                }
                if (isset($v[1])) {
                    array_shift($v);
                    $person[$k] = $v;
                } else {
                    $person[$k] = $v[0];
                }
            }
            if (count($person)) {
                ksort($person);
                $arr[] = $person;
            }
        }
        return $arr;
    }




}
