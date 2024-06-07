<?php
namespace Wappsnet\Core;

class HasPi {
    protected static $pi = '100101102103104105106107108109110111112113114115116117118119120121122123124125126127128129130131132133134135136137138139140141142143144145146147148149150151152153154155156157158159160161162163164165166167168169170171172173174175176177178179180181182183184185186187188189190191192193194195196197198199200201202203204205206207208209210211212213214215216217218219220221222223224225226227228229230231232233234235236237238239240241242243244245246247248249250251252253254255256257258259260261262263264265266267268269270271272273274275276277278279280281282283284285286287288289290291292293294295296297298299300301302303304305306307308309310311312313314315316317318319320321322323324325326327328329330331332333334335336337338339340341342343344345346347348349350351352353354355356357358359360361362363364365366367368369370371372373374375376377378379380381382383384385386387388389390391392393394395396397398399400401402403404405406407408409410411412413414415416417418419420421422423424425426427428429430431432433434435436437438439440441442443444445446447448449450451452453454455456457458459460461462463464465466467468469470471472473474475476477478479480481482483484485486487488489490491492493494495496497498499500501502503504505506507508509510511512513514515516517518519520521522523524525526527528529530531532533534535536537538539540541542543544545546547548549550551552553554555556557558559560561562563564565566567568569570571572573574575576577578579580581582583584585586587588589590591592593594595596597598599600601602603604605606607608609610611612613614615616617618619620621622623624625626627628629630631632633634635636637638639640641642643644645646647648649650651652653654655656657658659660661662663664665666667668669670671672673674675676677678679680681682683684685686687688689690691692693694695696697698699700701702703704705706707708709710711712713714715716717718719720721722723724725726727728729730731732733734735736737738739740741742743744745746747748749750751752753754755756757758759760761762763764765766767768769770771772773774775776777778779780781782783784785786787788789790791792793794795796797798799800801802803804805806807808809810811812813814815816817818819820821822823824825826827828829830831832833834835836837838839840841842843844845846847848849850851852853854855856857858859860861862863864865866867868869870871872873874875876877878879880881882883884885886887888889890891892893894895896897898899900901902903904905906907908909910911912913914915916917918919920921922923924925926927928929930931932933934935936937938939940941942943944945946947948949950951952953954955956957958959960961962963964965966967968969970971972973974975976977978979980981982983984985986987988989990991992993994995996997998999';
    protected static $str = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

    public static function compressPi($name)
    {
        $nameHex = self::toHex($name);
        $sol = self::getSol($nameHex);
        $nameHexNum = self::hexNoWord($nameHex);
        $key = self::getKey($nameHexNum, self::$pi);
        $key[] = $sol;
        $compressKey = self::toHex(implode('#', $key));
        return $compressKey;
    }

    public static function randomPassword() {
        $password = array();
        $passLen = strlen(self::$str) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $passLen);
            $password[] = self::$str[$n];
        }
        $password = implode($password);
        $password = strtolower($password);
        return $password;
    }

    protected static function toHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }

    protected static function getSol($str)
    {
        $arr = str_split($str);
        $aPos = implode('.', array_keys($arr, 'a'));
        $bPos = implode('.', array_keys($arr, 'b'));
        $cPos = implode('.', array_keys($arr, 'c'));
        $dPos = implode('.', array_keys($arr, 'd'));
        $ePos = implode('.', array_keys($arr, 'e'));
        $fPos = implode('.', array_keys($arr, 'f'));
        $sol = $aPos . ',' . $bPos . ',' . $cPos . ',' . $dPos . ',' . $ePos . ',' . $fPos;
        return $sol;
    }

    protected static function hexNoWord($str)
    {
        $str = str_replace(' ', '-', mb_strtolower(trim($str), 'UTF-8'));
        $string = rtrim(preg_replace('/[^a-zA-Zа-яёА-ЯЁ0-9\-]/iu', '-', $str), '-');
        while (mb_strstr($string, '--')) {
            $string = str_replace('--', '-', $string);
        }
        $ru_en = array('a' => '1', 'b' => '2', 'c' => '3', 'd' => '4', 'e' => '5', 'f' => '6');
        foreach ($ru_en as $ru => $en) {
            $string = preg_replace('/([' . $ru . ']+?)/iu', $en, $string);
        }
        return $string;
    }

    protected static function getKey($nameHexNum, $pi)
    {
        $key = array();
        $count = strlen($nameHexNum);
        if ($count > 3) {
            $ip = ceil($count / 3);
            for ($i = 0; $i < $ip; $i++) {
                $j = $i * 3;
                $th = substr($nameHexNum, $j, 3);
                if ($i == $ip - 1) {
                    $key[] = strpos($pi, $th) . strlen($th);
                } else {
                    $key[] = strpos($pi, $th);
                }
            }
        }
        return $key;
    }

    public static function unCompressPi($compressed)
    {
        $keyArr = self::unKey($compressed);
        $sol = self::unSol($keyArr);
        $onlyKey = self::onlyKey($keyArr);
        $unWordStr = self::toUnWordStr($onlyKey, self::$pi);
        $unWordToHex = self::unWordStrToHex($sol, $unWordStr);
        $uncompressed = self::toStr($unWordToHex);
        return $uncompressed;
    }

    protected function unKey($compressed)
    {
        $unKey = explode('#', self::tostr($compressed));
        return $unKey;
    }

    protected static function toStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }

    protected function unSol($keyArr)
    {
        $cnt = count($keyArr) - 1;
        $sol = $keyArr[$cnt];
        return $sol;
    }

    protected function onlyKey($keyArr)
    {
        $cnt = count($keyArr) - 1;
        unset($keyArr[$cnt]);
        return $keyArr;
    }

    protected function toUnWordStr($onlyKey, $pi)
    {
        $cnt = count($onlyKey) - 1;
        $sh = $cnt - 1;

        $str = '';
        for ($i = 0; $i <= $sh; $i++) {
            $str .= substr($pi, $onlyKey[$i], 3);
        }

        $endElem = $onlyKey[$cnt];
        $numC = substr($endElem, -1);
        $pos = substr($endElem, 0, strlen($endElem) - 1);
        $str .= substr($pi, $pos, $numC);
        return $str;
    }

    protected function unWordStrToHex($sol, $unWordStr)
    {
        $solArr = explode(',', $sol);
        $posesA = explode('.', $solArr[0]);
        $cntA = count($posesA) - 1;
        $posesB = explode('.', $solArr[1]);
        $cntB = count($posesB) - 1;
        $posesC = explode('.', $solArr[2]);
        $cntC = count($posesC) - 1;
        $posesD = explode('.', $solArr[3]);
        $cntD = count($posesD) - 1;
        $posesE = explode('.', $solArr[4]);
        $cntE = count($posesE) - 1;
        $posesF = explode('.', $solArr[5]);
        $cntF = count($posesF) - 1;
        $unWordStrArr = str_split($unWordStr);
        for ($i = 0; $i <= $cntA; $i++) {
            $p = $posesA[$i];
            $unWordStrArr[$p] = 'a';

        }
        for ($i = 0; $i <= $cntB; $i++) {
            $p = $posesB[$i];
            $unWordStrArr[$p] = 'b';

        }
        for ($i = 0; $i <= $cntC; $i++) {
            $p = $posesC[$i];
            $unWordStrArr[$p] = 'c';

        }
        for ($i = 0; $i <= $cntD; $i++) {
            $p = $posesD[$i];
            $unWordStrArr[$p] = 'd';

        }
        for ($i = 0; $i <= $cntE; $i++) {
            $p = $posesE[$i];
            $unWordStrArr[$p] = 'e';

        }
        for ($i = 0; $i <= $cntF; $i++) {
            $p = $posesF[$i];
            $unWordStrArr[$p] = 'f';

        }
        $strHx = implode($unWordStrArr);
        return $strHx;
    }
}