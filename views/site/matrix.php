<?php

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = 'Матрицы :: Тестовое задание';

?>
<div class="site-index">
    <div class="body-content">
        <?$total = [];?>
        <?foreach($count as $counter):?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Матрица #<?=$counter?></h5>
            </div>
            <table class="table movie_list">
                <tr>
                <?$i = 0; shuffle($matrix); $sum = 0;
                foreach($matrix as $item):
                    $i++;
                    $sum += $item;?>
                    <td><?=$item?></td>
                    <?if($i % 3 == 0){
                        $total[] = $sum;
                        $sum = 0;
                        echo '</tr><tr>';
                    }?>
                <?endforeach;?>
                </tr>
            </table>
        </div>
        <?endforeach;?>
    </div>
    <h5>Список уникальных сумм строк:</h5>
    <pre><?print_r(array_unique($total))?></pre>
</div>