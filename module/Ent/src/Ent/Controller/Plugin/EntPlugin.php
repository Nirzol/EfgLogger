<?php

namespace Ent\Controller\Plugin;

use Ent\Entity\EntAttribute;
use Ent\Entity\EntUser;
use Ent\Service\AttributeDoctrineService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Zend\Json\Json;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;

/**
 * Description of EntPlugin
 *
 * @author egrondin
 */
class EntPlugin extends AbstractPlugin
{

    public function doSomething()
    {
        // ...
    }

    public function prepareLogData(EntUser $user, $logIn, $actionId, $moduleId = null)
    {
//        $container->getManager()->getId(); # For current session manager of your container
//        $container->getDefaultManager()->getId(); # For default session manager of your entire app

        $logOnline = date("Y-m-d H:i:s");
        $logOffline = '';
        if ($logIn) {
            $logOnline = date("Y-m-d H:i:s");
            $logOffline = '';
        }
        $userIp = $_SERVER["REMOTE_ADDR"]; //$remote = new \Zend\Http\PhpEnvironment\RemoteAddress(); $remote->getIpAddress()
        $userAgent = $_SERVER["HTTP_USER_AGENT"];

        $container = new Container('entLogger');

        $logData = array(
            'logLogin' => $user->getUserLogin(),
            'logOnline' => $logOnline,
            'logOffline' => $logOffline,
            'logSession' => $container->getDefaultManager()->getId(),
            'logIp' => $userIp,
            'logUseragent' => $userAgent,
            'fkLogUser' => $user->getUserId(),
            'fkLogAction' => $actionId,
            'fkLogModule' => $moduleId,
        );

        return $logData;
    }

    /**
     * Prepare 'prefAttribute' to be insert into EntPreference
     * 
     * @param array $attributeFilterPost
     * @param array $attributeKeyFilterPost
     * @return array
     */
    public function preparePrefAttribute(array $attributeFilterPost, array $attributeKeyFilterPost, AttributeDoctrineService $attributeService, Serializer $serializer)
    {
        // Création du JSON
        // Trie croissant du tableau et trie croissant de la requete findby sur attributeID, 
        // pour être sur que les champs correspondent lors du merge
        ksort($attributeFilterPost);
        var_dump($attributeFilterPost);
        // On ne garde que les valeurs du array pour pouvoir merge avec le array de la requete
        $attributeValueFilterPost = array_values($attributeFilterPost);

        // Prepare les criteres de la requete pour recuperer les infos des attributs passé en POST
        // Requete ordonnée croissant par attributeID pour matcher lors du merge avec $attributeValueFilterPost
        $criteria = array('attributeId' => $attributeKeyFilterPost);
        $attributesData = $attributeService->findBy($criteria, array('attributeId' => 'ASC'));
        $i = 0;
        // ajout de la valeur dans le array global
        $attributesDataArray = Json::decode($serializer->serialize($attributesData, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_ARRAY);

        foreach ($attributesDataArray as $key => $attributeData) {
            /* @var $attributeData EntAttribute */
//            $prefAttributeData[$i] = $attributeData->toArray($this->hydrator);
//            $prefAttributeData[$i] = Json::decode($serializer->serialize($attributeData, 'json', SerializationContext::create()->setGroups(array('Default'))->enableMaxDepthChecks()), Json::TYPE_ARRAY);
//            $prefAttributeData[$i]['attribute_value'] = $attributeValueFilterPost[$i];
//            $attributeData['attribute_value'] = $attributeValueFilterPost[$i];
            $attributesDataArray[$key]['attribute_value'] = $attributeValueFilterPost[$i];
            $i++;
        }

        return $attributesDataArray;
    }

}
