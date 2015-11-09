<?php
namespace Owa;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\I18n\Translator;
use Zend\Validator\AbstractValidator;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
    
    public function onBootstrap(EventInterface $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $translator = $sm->get('MvcTranslator');
        AbstractValidator::setDefaultTranslator(new Translator($translator));

//        $translator->addTranslationFile(
//            'phpArray',
//            'resources/languages/en/Zend_Validate.php', //or Zend_Captcha
//            'default',
//            'fr_FR'
//        );
        // Set default lang en fonction du navigateur
//        $translator = $e->getApplication()->getServiceManager()->get('translator');
//        $translator->setLocale(\Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']))
//                   ->setFallbackLocale('fr_FR');
//        $translator = $e->getApplication()->getServiceManager()->get('translator');
//        $translator->setLocale( ( isset( $_COOKIE['locale'] ) ? $_COOKIE['locale'] : 'en_US' ) )
//            ->setFallbackLocale( 'en_US' );

        $t = $e->getTarget();

        //This strategy is used to redirect the user to another route when a user is unauthorized.
        $t->getEventManager()->attach(
                $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy')
        );

        //This strategy is used to render a template whenever a user is unauthorized.
//        $t->getEventManager()->attach(
//                $t->getServiceManager()->get('ZfcRbac\View\Strategy\UnauthorizedStrategy')
//        );
    }
}
