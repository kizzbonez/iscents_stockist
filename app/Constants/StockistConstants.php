<?php
namespace App\Constants;

class StockistConstants
{
    //Menu Roles
    const MENU_ROLES_USER = 'user';
    const MENU_ROLES_ADMIN = 'admin';
    const MENU_ROLES_GUEST = 'guest';
    //End Menu Roles

    //User Type
    const USER_TYPE_ADMIN_STOCKIST_LABEL = 'Admin Stockist';
    const USER_TYPE_PROVINCIAL_STOCKIST_LABEL = 'Depo Stockist';
    const USER_TYPE_REGIONAL_STOCKIST_LABEL = 'City Stockist';
    const USER_TYPE_MOBILE_STOCKIST_LABEL = 'Pickup Point';
    const USER_TYPE_ADMIN_STOCKIST_1= 0;
    const USER_TYPE_ADMIN_STOCKIST= 1;
    const USER_TYPE_PROVINCIAL_STOCKIST = 2;
    const USER_TYPE_REGIONAL_STOCKIST = 3;
    const USER_TYPE_MOBILE_STOCKIST = 4;

    const USER_TYPES = array(
        self::USER_TYPE_ADMIN_STOCKIST_1=>self::USER_TYPE_ADMIN_STOCKIST_LABEL,
        self::USER_TYPE_ADMIN_STOCKIST=>self::USER_TYPE_ADMIN_STOCKIST_LABEL,
        self::USER_TYPE_PROVINCIAL_STOCKIST=>self::USER_TYPE_PROVINCIAL_STOCKIST_LABEL,
        self::USER_TYPE_REGIONAL_STOCKIST=>self::USER_TYPE_REGIONAL_STOCKIST_LABEL,
        self::USER_TYPE_MOBILE_STOCKIST=>self::USER_TYPE_MOBILE_STOCKIST_LABEL,
    );


    //End User Type

    const GMT_DATE_FORMAT = 'M d Y g:i A';

    const TRANS_TYPE_IN = 0;
    const TRANS_TYPE_OUT = 1;
    const TRANS_TYPE = array( self::TRANS_TYPE_IN=>'IN',self::TRANS_TYPE_OUT=>'OUT');
}
