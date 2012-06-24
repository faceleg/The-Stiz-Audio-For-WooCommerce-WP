<?php

class WCJDCSS {

    /**
     * Minify input and return it. @see http://stackoverflow.com/a/1379487/187954.
     * @param  {string} $input CSS to be minified.
     * @return {string} Minified CSS.
     */
    public static function minify($css) {
        $css = trim($css);
        $css = str_replace("\r\n", "\n", $css);
        $search = array("/\/\*[^!][\d\D]*?\*\/|\t+/","/\s+/", "/\}\s+/");
        $replace = array(null," ", "}\n");
        $css = preg_replace($search, $replace, $css);
        $search = array("/;[\s+]/","/[\s+];/","/\s+\{\\s+/", "/\\:\s+\\#/", "/,\s+/i", "/\\:\s+\\\'/i","/\\:\s+([0-9]+|[A-F]+)/i","/\{\\s+/","/;}/");
        $replace = array(";",";","{", ":#", ",", ":\'", ":$1","{","}");
        $css = preg_replace($search, $replace, $css);
        $css = str_replace("\n", null, $css);
        return $css;
    }
}
