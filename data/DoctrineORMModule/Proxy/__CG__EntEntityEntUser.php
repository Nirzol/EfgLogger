<?php

namespace DoctrineORMModule\Proxy\__CG__\Ent\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class EntUser extends \Ent\Entity\EntUser implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userId', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userLogin', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userLastConnection', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userLastUpdate', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userStatus', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'fkUcContact', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'fkUpProfile', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'fkUrRole');
        }

        return array('__isInitialized__', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userId', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userLogin', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userLastConnection', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userLastUpdate', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'userStatus', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'fkUcContact', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'fkUpProfile', '' . "\0" . 'Ent\\Entity\\EntUser' . "\0" . 'fkUrRole');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (EntUser $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getUserId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserId', array());

        return parent::getUserId();
    }

    /**
     * {@inheritDoc}
     */
    public function setUserLogin($userLogin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserLogin', array($userLogin));

        return parent::setUserLogin($userLogin);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLogin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserLogin', array());

        return parent::getUserLogin();
    }

    /**
     * {@inheritDoc}
     */
    public function setUserLastConnection($userLastConnection)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserLastConnection', array($userLastConnection));

        return parent::setUserLastConnection($userLastConnection);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLastConnection()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserLastConnection', array());

        return parent::getUserLastConnection();
    }

    /**
     * {@inheritDoc}
     */
    public function setUserLastUpdate($userLastUpdate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserLastUpdate', array($userLastUpdate));

        return parent::setUserLastUpdate($userLastUpdate);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLastUpdate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserLastUpdate', array());

        return parent::getUserLastUpdate();
    }

    /**
     * {@inheritDoc}
     */
    public function setUserStatus($userStatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserStatus', array($userStatus));

        return parent::setUserStatus($userStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserStatus', array());

        return parent::getUserStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function addFkUcContact(\Doctrine\Common\Collections\Collection $fkUcContact)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addFkUcContact', array($fkUcContact));

        return parent::addFkUcContact($fkUcContact);
    }

    /**
     * {@inheritDoc}
     */
    public function removeFkUcContact(\Doctrine\Common\Collections\Collection $fkUcContact)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeFkUcContact', array($fkUcContact));

        return parent::removeFkUcContact($fkUcContact);
    }

    /**
     * {@inheritDoc}
     */
    public function getFkUcContact()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFkUcContact', array());

        return parent::getFkUcContact();
    }

    /**
     * {@inheritDoc}
     */
    public function addFkUpProfile(\Ent\Entity\EntProfile $fkUpProfile)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addFkUpProfile', array($fkUpProfile));

        return parent::addFkUpProfile($fkUpProfile);
    }

    /**
     * {@inheritDoc}
     */
    public function removeFkUpProfile(\Ent\Entity\EntProfile $fkUpProfile)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeFkUpProfile', array($fkUpProfile));

        return parent::removeFkUpProfile($fkUpProfile);
    }

    /**
     * {@inheritDoc}
     */
    public function getFkUpProfile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFkUpProfile', array());

        return parent::getFkUpProfile();
    }

    /**
     * {@inheritDoc}
     */
    public function addFkUrRole(\Doctrine\Common\Collections\Collection $fkUrRole)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addFkUrRole', array($fkUrRole));

        return parent::addFkUrRole($fkUrRole);
    }

    /**
     * {@inheritDoc}
     */
    public function removeFkUrRole(\Doctrine\Common\Collections\Collection $fkUrRole)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeFkUrRole', array($fkUrRole));

        return parent::removeFkUrRole($fkUrRole);
    }

    /**
     * {@inheritDoc}
     */
    public function getFkUrRole()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFkUrRole', array());

        return parent::getFkUrRole();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray($hydrator)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', array($hydrator));

        return parent::toArray($hydrator);
    }

}
