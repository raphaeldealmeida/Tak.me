<?php include __DIR__ . '/topo.php'; ?>
    <h2><a href="/<?=$shorten?>"><?=$shorten?></a></h2>
    <!-- recurso qrcode do google
    <img src="http://chart.apis.google.com/chart?chs=100x100&cht=qr&chld=L|0&chl=http://tak.me/<?=$shorten?>" /> -->
        <img src="/<?=$shorten?>.qrcode" />
    <?php if(isset($acessos) && count($acessos)>0):?>
    <table border="1">
        <tr>
            <th>Acessos</th>
        </tr>
        <?php foreach($acessos as $acesso):?>
        <tr>
            <td><!-- Utilização do novo operador ternario ?:-->
                Acessado por <a href="<?=$acesso['origem'] ?: 'Indeterminado' ?>"><?=$acesso['origem'] ?: 'Indeterminado' ?></a> <?=Mini\Helper::dateIntervalHumanFriendly(new DateTime($acesso['acessado_em']))?>
            </td>
         </tr>
        <?php endforeach; ?>
    </table>
    <? endif;?>
<?php include __DIR__ . '/rodape.php'; ?>