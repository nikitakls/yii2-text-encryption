<?php

namespace nikitakls\txtencryption;


use yii\base\Widget;

/**
 * @author nikitakls
 */
class JsEncryption extends Widget
{
    public $text = '';
    public $isLink = false;

    protected $range = 11;
    protected $offset = 57;

    /**
     * @param string $text
     * @return string
     * @throws \Exception
     */
    public static function encrypt(string $text){
       return self::widget([
           'text' => $text,
       ]);
    }

    public static function lencrypt(string $string)
    {
        return self::widget([
            'text' => $string,
            'isLink' => 1,
        ]);
    }

    /**
     * @return string|void
     */
    public function run()
    {
        $this->registerJs();
        if($this->isLink){
            print $this->encode($this->text);
        } else {
            print '<span class="encrypt-data">'.$this->encode($this->text).'</span>';
        }
    }

    /**
     * Register function encoder
     */
    protected function registerJs(): void
    {
        $this->getView()->registerJs("
            let OBF = {
                offset: 57, range: 11, 
                process: function( s, d){
                    var out = '',i;
                    for(i=0;i<s.length;i++){
                        out += String.fromCharCode(
                            s.charCodeAt(i)
                            + d*this.offset
                            + d*(i%this.range)
                        );
                    };
                    return out;
                },
                encode: function(s){ return this.process(s,  1) },
                decode: function(s){ return this.process(s, -1) }
            };
            $( \".encrypt-data\" ).each(function(index, el) {
                $(el).text(OBF.decode($(el).text()));
            });
            $( \".encrypt-link\" ).each(function(index, el) {
                $(el).attr('href', OBF.decode($(el).attr('alt')));
            });
        ");

    }

    /**
     * @param $s
     * @param int $dir
     * @return string
     */
    protected function encode($s, $dir = 1){
        $out = '';
        $strLen = mb_strlen($s);
        for($i=0; $i < $strLen; $i++){
            $out .= mb_chr(
                mb_ord($s[$i])
                + $dir * $this->offset
                + $dir * ($i % $this->range)
            );
        }
        return $out;
    }

}