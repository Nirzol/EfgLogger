<?php

namespace DoctrineORMModule\Proxy\__CG__\Ent\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class EntStatus extends \Ent\Entity\EntStatus implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusId', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusName', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusLibelle', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusDescription', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusLastUpdate');
        }

        return array('__isInitialized__', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusId', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusName', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusLibelle', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusDescription', '' . "\0" . 'Ent\\Entity\\EntStatus' . "\0" . 'statusLastUpdate');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (EntStatus $proxy) {
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
    public function getStatusId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getStatusId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatusId', array());

        return parent::getStatusId();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatusName($statusName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatusName', array($statusName));

        return parent::setStatusName($statusName);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatusName', array());

        return parent::getStatusName();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatusLibelle($statusLibelle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatusLibelle', array($statusLibelle));

        return parent::setStatusLibelle($statusLibelle);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusLibelle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatusLibelle', array());

        return parent::getStatusLibelle();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatusDescription($statusDescription)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatusDescription', array($statusDescription));

        return parent::setStatusDescription($statusDescription);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatusDescription', array());

        return parent::getStatusDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatusLastUpdate($statusLastUpdate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatusLastUpdate', array($statusLastUpdate));

        return parent::setStatusLastUpdate($statusLastUpdate);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusLastUpdate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatusLastUpdate', array());

        return parent::getStatusLastUpdate();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray($hydrator, $owner = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', array($hydrator, $owner));

        return parent::toArray($hydrator, $owner);
    }

}
