<?php
// ���̃N���X�ł̂ݗ��p����O���[�o���ϐ�

// @see getQueryKey()
$GLOBALS['_UA__query_key'] = 'b';

// @see setPCQuery() // b=pc
$GLOBALS['_UA__PC_query'] = 'pc';

// @see setMobileQuery() // b=k
$GLOBALS['_UA__mobile_query'] = 'k';

/**
 * �X�^�e�B�b�N���\�b�h�ŗ��p����
 *
 * @author  aki
 * @created 2007/03/13
 */
class UA
{
    /**
     * UA���g�ѕ\���Ώۃ��o�C���ł����true��Ԃ�
     * [todo] �g�т��܂ނ悤�ɂ���\��
     *
     * @static
     * @access  public
     * @return  boolean
     */
    function isMobile()
    {
        if (UA::isPSP()) {
            return true;
        }
        /*
        if (UA::isNintendoDS()) {
            return true;
        }
        */
        return false;
    }
    
    /**
     * �N�G���[��PC���w�肵�Ă���Ȃ�true��Ԃ�
     *
     * @static
     * @access  private
     * @return  boolean
     */
    function isPCByQuery()
    {
        $key = UA::getQueryKey();
        if (!$key) {
            return false;
        }
        $pc = UA::getPCQuery();
        
        if (isset($_REQUEST[$key]) && $_REQUEST[$key] == $pc) {
            return true;
        }
        
        return false;
    }
    
    /**
     * �N�G���[���g�т��w�肵�Ă���Ȃ�true��Ԃ�
     *
     * @static
     * @access  private
     * @return  boolean
     */
    function isMobileByQuery()
    {
        $key = UA::getQueryKey();
        if (!$key) {
            return false;
        }
        $k = UA::getMobileQuery();
        
        if (isset($_REQUEST[$key]) && $_REQUEST[$key] == $k) {
            return true;
        }
        
        return false;
    }
    
    /**
     * �\�����[�h�w��p�̃N�G���[�l���擾����
     *
     * @static
     * @access  public
     * @return  string
     */
    function getQueryValue($key = null)
    {
        is_null($key) and $key = UA::getQueryKey();
        
        $r = null;
        if (isset($_REQUEST[$key])) {
            $r = $_REQUEST[$key];
        }
        return $r;
    }
    
    /**
     * @static
     * @access  public
     * @return  string
     */
    function getQueryKey()
    {
        return $GLOBALS['_UA__query_key'];
    }
    
    /**
     * @static
     * @access  public
     * @param   string   $pc
     * @return  void
     */
    function setPCQuery($pc)
    {
        $GLOBALS['_UA__PC_query'] = $pc;
    }
    
    /**
     * @static
     * @access  public
     * @return  string
     */
    function getPCQuery()
    {
        return $GLOBALS['_UA__PC_query'];
    }
    
    /**
     * @static
     * @access  public
     * @param   string  $k
     * @return  void
     */
    function setMobileQuery($k)
    {
        $GLOBALS['_UA__mobile_query'] = $k;
    }
    
    /**
     * @static
     * @access  public
     * @return  string
     */
    function getMobileQuery()
    {
        return $GLOBALS['_UA__mobile_query'];
    }
    
    /**
     * Net_UserAgent_Mobile::singleton() �̌��ʂ��擾����B
     * REAR Error �� false �ɕϊ������B
     *
     * @static
     * @access  public
     * @param   string  $ua
     * @return  Net_UserAgent_Mobile|false
     */
    function getNet_UserAgent_Mobile($ua = null)
    {
        static $cache_;
        
        if (is_null($ua) and isset($cache_)) {
            return $cache_;
        }
        
        require_once 'Net/UserAgent/Mobile.php';
        
        if (!is_null($ua)) {
            $nuam = &Net_UserAgent_Mobile::factory($ua);
        } else {
            $nuam = &Net_UserAgent_Mobile::singleton();
        }
        
        if (PEAR::isError($nuam)) {
            trigger_error($nuam->toString, E_USER_WARNING);
            $return = false;
            
        } elseif (!$nuam) {
            $return = false; // null
        
        } else {
            $return = $nuam;
        }
        
        if (is_null($ua)) {
            $cache_ = $return;
        }
        
        return $return;
    }
    
    /**
     * UA��NetFront�i�g�сAPDA�APSP�j�Ȃ�true��Ԃ�
     *
     * @static
     * @access  public
     * @param   string   $ua  UA���w�肷��Ȃ�
     * @return  boolean
     */
    function isNetFront($ua = null)
    {
        is_null($ua) and $ua = $_SERVER['HTTP_USER_AGENT'];
        
        if (preg_match('/(NetFront|AVEFront\/|AVE-Front\/)/', $ua)) {
            return true;
        }
        if (UA::isPSP()) {
            return true;
        }
        return false;
    }
    
    /**
     * UA��PSP�Ȃ�true��Ԃ��BNetFront�n�炵���B
     *
     * @static
     * @access  public
     * @param   string   $ua  UA���w�肷��Ȃ�
     * @return  boolean
     */
    function isPSP($ua = null)
    {
        is_null($ua) and $ua = $_SERVER['HTTP_USER_AGENT'];
        
        // Mozilla/4.0 (PSP (PlayStation Portable); 2.00) 
        if (preg_match('/PlayStation Portable/', $ua)) {
            return true;
        }
        return false;
    }
    
    /**
     * UA��Nintendo DS�Ȃ�true��Ԃ��B
     *
     * @static
     * @access  public
     * @param   string   $ua  UA���w�肷��Ȃ�
     * @return  boolean
     */
    function isNintendoDS($ua = null)
    {
        is_null($ua) and $ua = $_SERVER['HTTP_USER_AGENT'];
        
        // Mozilla/4.0 (compatible; MSIE 6.0; Nitro) Opera 8.5 [ja]
        if (preg_match('/ Nitro/', $ua)) {
            return true;
        }
        return false;
    }

    /**
     * UA��Safari�n�Ȃ�true��Ԃ�
     *
     * @static
     * @access  public
     * @param   string   $ua  UA���w�肷��Ȃ�
     * @return  boolean
     */
    function isSafariGroup($ua = null)
    {
        is_null($ua) and $ua = $_SERVER['HTTP_USER_AGENT'];
        
        return (boolean)preg_match('/Safari|AppleWebKit|Konqueror/', $ua);
    }
}