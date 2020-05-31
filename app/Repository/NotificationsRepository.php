<?php

namespace App\Repository;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

/**
 * NotificationsRepository class
 */
class NotificationsRepository
{
    public static function pushNotification($token,$title,$content = null,$myData = [])
    {
    	$optionBuilder = new OptionsBuilder();
		$optionBuilder->setTimeToLive(60*20);

		$notificationBuilder = new PayloadNotificationBuilder($title);
		$notificationBuilder->setBody($content)
						    ->setSound(1);

		$dataBuilder = new PayloadDataBuilder();
		$dataBuilder->addData($myData);

		$option = $optionBuilder->build();
		$notification = $notificationBuilder->build();
		$data = $dataBuilder->build();

		// $token = "a_registration_from_your_database";

		$downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

		$downstreamResponse->numberSuccess();
		$downstreamResponse->numberFailure();
		$downstreamResponse->numberModification();

		return $downstreamResponse;

		//return Array - you must remove all this tokens in your database
		$downstreamResponse->tokensToDelete();

		//return Array (key : oldToken, value : new token - you must change the token in your database )
		$downstreamResponse->tokensToModify();

		//return Array - you should try to resend the message to the tokens in the array
		$downstreamResponse->tokensToRetry();
    }
}
