<?php
/* �g���b�v�E���[�J�[ */

include_once './conf/conf.inc.php';

$_login->authorize(); // ���[�U�F��

echo P2Util::mkTrip($_GET['tk']);

/*
 * Local variables:
 * mode: php
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=cp932 ai et ts=4 sw=4 sts=4 fdm=marker: