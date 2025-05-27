<?php
/**
 * HTMLPurifier
 */

class HTMLPurifier
{
    static public $config = array();

    static public $allowedAttributes = [
        "id", "class", "style",
        "href", "download", "target",
        "src", "alt", "poster", "title",
        "width", "height", "align", "for",
        "type", "name", "value",
        "rowspan", "colspan", "tabindex",
        "data-aos", "data-[*]", "aria-[*]",
    ]; // todo regex for "data-[*]"


    static public function getAllowedAttributes()
    {
        return self::$allowedAttributes;
    }

    static public function clearAttributes($html)
    {
        if (!$html) return '';

        preg_match_all('#(\s*?([a-z0-9\-_]{1,})\s*?=\s*?".*?")#is', $html, $array);

        if ($array[1]) {
            $arr1 = [];
            $arr2 = [];

            foreach ($array[2] as $key => $value) {
                if (!in_array($value, self::getAllowedAttributes())) { // trim()
                    $arr1[] = $array[1][$key];
                    $arr2[] = '';
                }
            }

            return str_replace($arr1, $arr2, $html);
        }

        return $html;
    }

    static public function purify($html) {
        if (!$html) return '';

        // secure clear tags(script, etc.)
        // todo: send white list of tags(ex 'p,b,a[href],i')
        $html = preg_replace('#<\/?script(.*?)>#is', '', $html);

        // left only secure whitelisted attributes and remove other(onclick, onchange, etc.)
        // todo: send white list of attributes(data-aos)(with mask also, ex: data-[*] or 'p,b,a[href],i')
        $html = self::clearAttributes($html);

        // clear empty tags (p) todo: div,span,etc.
        $html = self::clearTags($html);

        return $html;
    }

    static public function postClean($html)
    {
        if (!$html) return '';

        // &lt;p&gt;&lt;br /&gt;&lt;br /&gt;&nbsp;&lt;/p&gt;
        $html = preg_replace('#(&lt;p[^&gt;]*?&gt;(\r|\n|\s|&nbsp;|&lt\/?\s?br\s?\/?&gt;)*&lt;\/p&gt;)#ims', '', $html);

        return $html;
    }

    static public function clearTags($html, $fixBullets = false)
    {
        if (!$html) return '';
        $html = preg_replace('#(<p[^>]*?>(\r|\n|\s|&nbsp;|<\/?\s?br\s?\/?(&nbsp;)?\s?>)*<\/p>)#ims', '', $html);

        if ($fixBullets)
            $html = self::fixBullets($html);

        //$html = str_replace(
        //    ['<br /><br /><br />', '<br><br><br>', '<br> <br> <br>','<br /><br />', '<br><br>', '<br> <br>', '<p>&nbsp;</p>'],
        //    ['<br>', '<br>', '<br>','<br>', '<br>', '<br>', ''],
        //    $html
        //);
        /*$html = preg_replace('#<p[^>]*?>(\s|&nbsp;|</?\s?br\s?/?>)*<\/p>#ims', '', $html);*/
        /*$html = preg_replace('#<p[^>]*?>\s*?(&nbsp;)*?\s*?(<br\s?\/?>)*?\s*?(&nbsp;)*?\s*?<\/p>#ims', '', $html);*/

        return $html;
    }

    static public function fixBullets($html, $char = '•')
    {
        if (!$html) return '';

        $html = preg_replace('#(' . $char . '\s*(.*)(\r|\n|\s|&nbsp;|<\/?\s?br\s?\/?>)*)#im', '<li>$2</li>', $html);

        if (mb_strpos($html, '<li>') !== false && mb_strpos($html, '<ul>') === false) { // todo ul-checker
            $html = preg_replace('#((?!\<ul\s*\>)<li>.*<\/li>(?!\<\/ul\>))#im', '<ul>$1</ul>', $html); // add ul
        }

        $html = preg_replace("#</li> ?<br ?/?> ?<li>#", '</li><li>', $html); // remove br after li elements

        return $html;
    }
}

//$a = 5;
//$html = <<<"VAR"
//<p id = "tt" onclick = "alert(55)" onchange = "load()">Vision for</p>
//<p id="tt" onclick="alert(55)" onchange="load()">Vision for</p>
//<a href="https://www.google.com?a=1.5%%" title = "load()" alt="123">Vision link</a>
//
//<p class="eee" data-aos="test" data-id="12">Education was&nbsp;honoured to sponsor the&nbsp;first ever Consilium Awards, which&nbsp;was recently held to&nbsp;celebrate&nbsp;the achievements of&nbsp;both&nbsp;students and staff from the <a href="https://www.consilium-at.com/">Consilium Multi-Academy Trust&rsquo;s</a>eight schools.</p>
//
//
//
//<p>   </p>
//<p><br />  </p>
//<p> <br/> </p>
//<p> </p>
//<p><br/>   &nbsp;   <br/></p>
//<p id = "dsg">Hello</p>
//<p>&nbsp;</p>
//<p><br /></p>
//<p>
//&nbsp;</p>
//
//<p>
//<br /><br />
//&nbsp;</p>
//<p>&nbsp;</p>
//<p>&nbsp;</p>
//<p><!--<script>--><script>console.log(5678)</script><!--</script>--></p>
//<p>&nbsp;</p>
//<p>Vision for</p>
//
//<p>Education was&nbsp;honoured to sponsor the&nbsp;first ever Consilium Awards, which&nbsp;was recently held to&nbsp;celebrate&nbsp;the achievements of&nbsp;both&nbsp;students and staff from the <a href="https://www.consilium-at.com/">Consilium Multi-Academy Trust&rsquo;s</a>eight schools.</p>
//
//VAR;
//
//$res = HTMLPurifier::purify($html);
//print_data(filter($html, 'string'));
//print_data(filter($res, 'string'));
//exit;
/* End of file */