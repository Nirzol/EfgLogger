<?php

namespace EfgLogger;

//use EfgLogger\Doctrine\ORM\EntityManagerHelper;
//use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\Request;
//use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
//use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
//use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

//implements ConsoleUsageProviderInterface, DependencyIndicatorInterface
class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
//        $eventManager = $e->getApplication()->getEventManager();
//        $moduleRouteListener = new ModuleRouteListener();
//        $moduleRouteListener->attach($eventManager);
        $this->addDefaultLogExtraIfValid($e);
    }

    private function addDefaultLogExtraIfValid(MvcEvent $e)
    {
        $request = $e->getParam('request');
        if (!$request instanceof Request) {
            $sm = $e->getApplication()->getServiceManager();
            $entityName = $this->getDefaultLogEntityName($sm);
//            $em = $sm->get("Doctrine\ORM\EntityManager");
//            if ($entityName && EntityManagerHelper::isEntity($em, $entityName)) {
            if ($entityName) {
                $container = new \Zend\Session\Container('entLogger');
                $e->getApplication()
                    ->getServiceManager()
                    ->get('Logger')
                    ->addExtra(array(
                        'log_ip' => $request->getServer()->get('REMOTE_ADDR'),
                        'log_useragent' => $request->getServer()->get('HTTP_USER_AGENT'),
                        'log_url' => $request->getRequestUri(),
                        'log_session' => $container->getDefaultManager()->getId(),
                    ));
            }
        }
    }

    private function getDefaultLogEntityName($sm)
    {
        $config = $sm->get('config');
        $defaultLogConfig = $config['efglogger']['Logger'];
        if (isset($defaultLogConfig)) {
            $entityName = $defaultLogConfig['entityClassName'];
        }
        return $entityName;
    }

//    public function getModuleDependencies()
//    {
//        return array(
//            'DoctrineModule',
//            'DoctrineORMModule',
//        );
//    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Logger' => 'EfgLogger\Factory\Service\LoggerFactory',
            ),
//            'shared' => array(
//                'doctrine.entitymanager.orm_default' => false
//            ),
        );
    }

//    public function getAutoloaderConfig()
//    {
//        return array(
//            'Zend\Loader\StandardAutoloader' => array(
//                'namespaces' => array(
//                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
//                ),
//            ),
//        );
//    }
}
