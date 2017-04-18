<?php
/**
 * Created by PhpStorm.
 * User: Ameya Joshi
 * Date: 17/4/17
 * Time: 4:00 PM
 */

namespace App\Classes;

class AesForJava {

    const M_CBC = 'cbc';
    const M_CFB = 'cfb';
    const M_ECB = 'ecb';
    const M_NOFB = 'nofb';
    const M_OFB = 'ofb';
    const M_STREAM = 'stream';

    protected $key;
    protected $cipher;
    protected $data;
    protected $mode;
    protected $IV;

    /**
     *
     * @param type $data
     * @param type $key
     * @param type $blockSize
     * @param type $mode
     */
    function __construct($data = null, $key = null, $blockSize = null, $mode = null) {
        $this->setData($data);
        $this->setKey($key);
        $this->setBlockSize($blockSize);
        $this->setMode($mode);
        $this->setIV("");
    }

    /**
     *
     * @param type $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     *
     * @param type $key
     */
    public function setKey($key) {
        $this->key = $key;
    }

    /**
     *
     * @param type $blockSize
     */
    public function setBlockSize($blockSize) {
        switch ($blockSize) {
            case 128:
                $this->cipher = MCRYPT_RIJNDAEL_128;
                break;

            case 192:
                $this->cipher = MCRYPT_RIJNDAEL_192;
                break;

            case 256:
                $this->cipher = MCRYPT_RIJNDAEL_256;
                break;
        }
    }

    /**
     *
     * @param type $mode
     */
    public function setMode($mode) {
        switch ($mode) {
            case AesForJava::M_CBC:
                $this->mode = MCRYPT_MODE_CBC;
                break;
            case AesForJava::M_CFB:
                $this->mode = MCRYPT_MODE_CFB;
                break;
            case AesForJava::M_ECB:
                $this->mode = MCRYPT_MODE_ECB;
                break;
            case AesForJava::M_NOFB:
                $this->mode = MCRYPT_MODE_NOFB;
                break;
            case AesForJava::M_OFB:
                $this->mode = MCRYPT_MODE_OFB;
                break;
            case AesForJava::M_STREAM:
                $this->mode = MCRYPT_MODE_STREAM;
                break;
            default:
                $this->mode = MCRYPT_MODE_ECB;
                break;
        }
    }

    /**
     *
     * @return boolean
     */
    public function validateParams() {
        if ($this->data != null &&
            $this->key != null &&
            $this->cipher != null) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function setIV($IV) {
        $this->IV = $IV;
    }

    protected function getIV() {
        if ($this->IV == "") {
            $this->IV = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), MCRYPT_RAND);
        }
        return $this->IV;
    }

    /**
     * @return type
     * @throws Exception
     */
    public function encrypt($data = null, $key = null, $blockSize = null, $mode = null) {
        $this->setData($data);
        $this->setKey($key);
        $this->setBlockSize($blockSize);
        $this->setMode($mode);
        $this->setIV("");

//        $padded_data = $this->pkcs5_pad($this->data);
        if ($this->validateParams()) {
            return trim(base64_encode(
                mcrypt_encrypt(
                    $this->cipher, $this->key, $this->pkcs5_pad($this->data), $this->mode, $this->getIV())));
        } else {
            throw new Exception('Invlid params!');
        }
    }

    /**
     *
     * @return type
     * @throws Exception
     */
    public function decrypt($data = null, $key = null, $blockSize = null, $mode = null) {
//        echo $data;
        $this->setData(trim($data));
//        echo "<br/>".$this->data; exit;
//        $this->setData($data);
        $this->setKey($key);
        $this->setBlockSize($blockSize);
        $this->setMode($mode);
        $this->setIV("");



        if ($this->validateParams()) {
            //echo base64_decode($this->data); exit;
            $depcryptedStr = trim(mcrypt_decrypt($this->cipher, $this->key, base64_decode($this->data), $this->mode, $this->getIV()));

            $unpaddedStr =  $this->pkcs5_unpad(utf8_encode($depcryptedStr));
            //$unpaddedStr =  $this->pkcs5_unpad(utf8_encode(trim(mcrypt_decrypt(
            //          $this->cipher, $this->key, base64_decode($this->data), $this->mode, $this->getIV()))));
            if ($unpaddedStr) {
                return $unpaddedStr;
            }
            else {
                return $depcryptedStr;
            }
        } else {
            throw new Exception('Invlid params!');
        }
    }

    function pkcs5_pad ($text, $blocksize=16){
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function pkcs5_unpad ($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }

        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);

    }

}