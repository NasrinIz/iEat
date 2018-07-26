<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(6, "mi_orders", $Language->MenuPhrase("6", "MenuText"), "orderslist.php", -1, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orders'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_customers", $Language->MenuPhrase("1", "MenuText"), "customerslist.php", -1, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}customers'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_menus", $Language->MenuPhrase("4", "MenuText"), "menuslist.php", -1, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}menus'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_employees", $Language->MenuPhrase("3", "MenuText"), "employeeslist.php", -1, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}employees'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(12, "mci_Setup", $Language->MenuPhrase("12", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(9, "mi_stores", $Language->MenuPhrase("9", "MenuText"), "storeslist.php", 12, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}stores'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(11, "mi_timings", $Language->MenuPhrase("11", "MenuText"), "timingslist.php", 12, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}timings'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(13, "mi_userlevels", $Language->MenuPhrase("13", "MenuText"), "userlevelslist.php", 12, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_provinces", $Language->MenuPhrase("8", "MenuText"), "provinceslist.php", 12, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}provinces'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_paymenttypes", $Language->MenuPhrase("7", "MenuText"), "paymenttypeslist.php", 12, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}paymenttypes'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_deliverytypes", $Language->MenuPhrase("2", "MenuText"), "deliverytypeslist.php", 12, "", AllowListMenu('{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}deliverytypes'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
