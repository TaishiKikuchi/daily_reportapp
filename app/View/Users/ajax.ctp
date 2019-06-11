<?php
/**
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
echo "test";
header("HTTP/1.1 200");
if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_SERVER['HTTP_X_TRELLO_WEBHOOK'])) {
    $body = file_get_contents("php://input");
    if (!empty($body)) {
        $json = json_decode($body);
        // ... あとはご自由に ...

        var_dump($json);
    }
}
