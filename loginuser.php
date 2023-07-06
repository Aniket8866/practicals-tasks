<?php 

/**
 * This is wrapper class in which all the functions are called from angular.
 * We have implemented caching over here so it will speed up tool user experience.
 *
 *  PHP version 5
 *
 * LICENSE: This source file is subject to version 1.0 with our BYI tool implementation
 *
 * @ByiDesigner   Main class
 * @$_baseUrl    we will need to change base URL when we are installing extension on any client website.
 * @author     Original Author <admin@biztechcs.com>
 * @author     Another Author <admin@biztechcs.com>
 * @version    1.0
 * @Date : 01/06/2017
 *
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/**
 * @ByiDesigner : Build class for Mage
 * Date : 12/07/2017
 * By : U V
 *
 */
use Magento\Framework\App\Bootstrap;

/**
 * If your external file is in root folder
 */
require __DIR__ . '/app/bootstrap.php';

ini_set('display_errors', 1);

$params = $_SERVER;
$bootstrap = Bootstrap::create(BP, $params);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$request = $objectManager->get('\Magento\Framework\App\Request\Http');
$state->setAreaCode('frontend');
$urlInterface = $objectManager->get(\Magento\Framework\UrlInterface::class);
$params = array();
$currentUrl = $urlInterface->getCurrentUrl();
$url_components = parse_url($currentUrl);
parse_str( $url_components['query'], $params);

//Get Current Website Id
$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
$websiteId =  $storeManager->getStore()->getWebsiteId();

// Get Customer By Email
$CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');
$CustomerModel->setWebsiteId($websiteId);
$CustomerModel->loadByEmail($params['user']);

// Set Customer in session
$session = $objectManager->get('Magento\Customer\Model\Session');
$session->setCustomerAsLoggedIn($CustomerModel);   

$redirectUrl = base64_decode($params['page']);
$response = $objectManager->get('\Magento\Framework\App\ResponseInterface');
$base_url = substr($currentUrl, 0, strpos($currentUrl, $url_components['path']));
$response->setRedirect($base_url.'/'.$redirectUrl)->sendResponse();
 

