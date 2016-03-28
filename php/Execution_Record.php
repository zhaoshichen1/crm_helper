<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 3/29/16
 * Time: 1:15 AM
 */

const functionality_id = [
    "loyalty_subscription_check" => 500001,
    "generation_ko" => 500002,
    "which_card_used" => 500003,
    "transfer_record" => 500004
];

/**
 * record one execution in the DB to help the statistic
 * @param $function_name
 */
function record_this_execution( $function_name ){

    /**
     * get the func_id
     */
    $func_id = functionality_id[$function_name];

    /**
     * get the current date - CN TimeZone
     */

    /**
     * insert into the table
     */

}