<?php
use App\Utils\SessionManager;
$successMessage = SessionManager::getFlashMessage('success');
if($successMessage) {
	echo "<div>$successMessage</div>";
}
echo SessionManager::getSessionValue('user_id');

echo " THIS IS HOME PAGE ";

