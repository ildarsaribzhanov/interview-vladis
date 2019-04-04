<?php

use App\Domain\ServerGroup;
use App\Services\CrudService;

if (isset($_POST['new-ip']) && isset($_POST['group-id'])) {

    $crudService = new CrudService($serverStor, $groupStor);

    $ip      = $_POST['new-ip'];
    $group   = (int)$_POST['group-id'];
    $comment = $_POST['comment'] ?? '';

    try {
        $crudService->createServer($ip, $group, $comment);
        echo 'Сервер добавлен';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$allGroups = $groupStor->getAll();
?>
<br/>
<form method="post" style="width: 300px; padding: 20px; background-color: #afafaf;">
    <h3>Добавить новый сервер</h3>
    <input type="text" name="new-ip" style="width: 100px;" required="required"/>
    <select name="group-id" style="width: 180px;">
        <?php
        /** @var ServerGroup $groupItm */
        foreach ($allGroups as $groupItm) {
            echo '<option value="' . $groupItm->getId() . '">' . $groupItm->getTitle() . '</option>';
        }
        ?>

    </select><br/>

    <textarea name="comment" id="" cols="30" rows="3"
              style="width: 285px; box-sizing: border-box; resize: none;"></textarea>
    <br/>
    <button style="width: 285px">Добавить</button>
</form><br/>
<hr/><br/>