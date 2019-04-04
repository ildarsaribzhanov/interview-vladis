<?php

use App\Domain\ServerGroup;
use App\Domain\ServerPing;

echo '<table>';
/** @var ServerGroup $groupItm */
foreach ($allGroups as $groupItm) {
    echo '<tr><td colspan="3"><h3>Группа серверов: ' . $groupItm->getTitle() . '</h3></td></tr>';

    $servers = $groupItm->getServers($serverStor);

    /*
    * todo добавить защиту nonce
    */
    foreach ($servers as $serverItm) {
        echo '<tr>
        <td>ip сервера: ' . $serverItm->getIp() . '<br />' . $serverItm->getComment() . '</td>
        <td><h4>История проверок:</h4>';
        $pings = $serverItm->getPings($pingStor);
        /** @var ServerPing $pingItm */
        foreach ($pings as $pingItm) {
            echo '<b>Дата:</b> <i>' . $pingItm->getDateForView() . '</i>;
            <b>Статус:</b> <i>' . $pingItm->getStatus() . '</i>;
            <b>Время запроса:</b> <i>' . $pingItm->getResponseTime() . 'мс</i><br/>';
        }
        echo '</td>
        <td>
            <form method="post">
                <input type="hidden" name="server-id" value="' . $serverItm->getId() . '" />
                <button>Проверить отклик сервера</button>
            </form>
        </td>
    </tr>';
    }
}
echo '</table>';