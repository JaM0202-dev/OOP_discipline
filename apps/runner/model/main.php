<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE->model
 * @package Model\Main
 */
namespace Model;
class Main
{
	use \Library\Shared;

	public function formsubmitAmbassador(array $data):?array {
		// Тут модель повинна бути допрацьована, щоб використовувати бази даних, тощо
		$key = '1698098909:AAHWL6VTZgLk1WL8yYUk2831gHQDIqIkCGQ'; // Ключ API телеграм
		$result = null;
		$chat = 352915071;
		$text = "Нова заявка в *Цифрові Амбасадори*:\n" . $data['firstname'] . ' '. $data['secondname']. ', '. $data['position'] . "\n*Зв'язок*: " . $data['phone']. "\n*Email: *". $data['email'];
		$text = urlencode($text);
		$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chat&text=$text");
		$answer = json_decode($answer, true);
		$result = ['message' => $answer['result']];
		return $result;
	}

	public function __construct() {

	}
}