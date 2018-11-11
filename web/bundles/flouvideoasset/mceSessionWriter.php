<?php 
echo "hallo";

require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/SessionBagInterface.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Flash/FlashBagInterface.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Flash/FlashBag.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/SessionBagInterface.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Attribute/AttributeBagInterface.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Attribute/AttributeBag.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Storage/Proxy/AbstractProxy.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Storage/Proxy/NativeProxy.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/SessionBagInterface.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Storage/MetadataBag.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Storage/SessionStorageInterface.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Storage/NativeSessionStorage.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/SessionInterface.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Session.php');

require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Storage/MockArraySessionStorage.php');
require_once('../../../vendor/symfony/symfony/src/Symfony/Component/HttpFoundation/Session/Storage/MockFileSessionStorage.php');

// This shit copies symfony session data to php native session
session_start();

$mocksession = new Symfony\Component\HttpFoundation\Session\Session(new Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage());
$mocksession->setId(session_id());

$_SESSION['mc_path'] = $mocksession->get('mc_path');
$_SESSION['mc_rootpath'] = $mocksession->get('mc_rootpath');
$_SESSION['mc_LoggedIn'] = $mocksession->get('mc_LoggedIn');
echo "hallo";
?>