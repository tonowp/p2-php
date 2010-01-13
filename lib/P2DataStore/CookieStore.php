<?php
/**
 * rep2expack - Cookie�Ǘ��N���X
 */

require_once P2_LIB_DIR . '/P2DataStore/AbstractDataStore.php';

// {{{ CookieStore

class CookieStore extends AbstractDataStore
{
    // {{{ getKVS()

    /**
     * Cookie��ۑ�����P2KeyValueStore�I�u�W�F�N�g���擾����
     *
     * @param void
     * @return P2KeyValueStore
     */
    static public function getKVS()
    {
        return self::_getKVS($GLOBALS['_conf']['cookie_db_path']);
    }

    // }}}
    // {{{ AbstractDataStore.php ����̃R�s�y / PHP 5.3 �̒x���ÓI�������g���č폜������
    // {{{ get()

    /**
     * �f�[�^���擾����
     *
     * @param string $key
     * @return mixed
     * @see P2KeyValueStore::get()
     */
    static public function get($key)
    {
        return self::getKVS()->get($key);
    }

    // }}}
    // {{{ set()

    /**
     * �f�[�^��ۑ�����
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     * @see P2KeyValueStore::exists(),
     *      P2KeyValueStore::set(),
     *      P2KeyValueStore::update()
     */
    static public function set($key, $value)
    {
        $kvs = self::getKVS();
        if ($kvs->exists($key)) {
            return $kvs->update($key, $value);
        } else {
            return $kvs->set($key, $value);
        }
    }

    // }}}
    // {{{ delete()

    /**
     * �f�[�^���폜����
     *
     * @param string $key
     * @return bool
     * @see P2KeyValueStore::delete()
     */
    static public function delete($key)
    {
        return self::getKVS()->delete($key);
    }

    // }}}
    // {{{ clear()

    /**
     * ���ׂẴf�[�^�܂��̓L�[���w�肳�ꂽ�ړ����Ŏn�܂�f�[�^���폜����
     *
     * @param string $prefix
     * @return int
     * @see P2KeyValueStore::clear()
     */
    static public function clear($prefix = null)
    {
        $kvs = self::getKVS();

        if ($prefix === null) {
            return $kvs->clear();
        }

        $pattern = str_replace(array(  '%',   '_',   '\\'),
                               array('\\%', '\\_', '\\\\'),
                               $kvs->encodeKey($prefix));
        $query = 'DELETE FROM $__table WHERE $__key LIKE :pattern ESCAPE :escape';
        $stmt = $kvs->prepare($query);
        $stmt->bindValue(':pattern', $pattern);
        $stmt->bindValue(':escape', '\\');

        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

    // }}}
    // }}} �R�s�y�����܂�
}

// }}}

/*
 * Local Variables:
 * mode: php
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=cp932 ai et ts=4 sw=4 sts=4 fdm=marker: