<?php
function jsonDecode ($json)
  {
      $json = str_replace(array("\\\\", "\\\""), array("&#92;", "&#34;"), $json);
      $parts = preg_split("@(\"[^\"]*\")|([\[\]\{\},:])|\s@is", $json, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
      foreach ($parts as $index => $part)
      {
          if (strlen($part) == 1)
          {
              switch ($part)
              {
                  case "[":
                  case "{":
                      $parts[$index] = "array(";
                      break;
                  case "]":
                  case "}":
                      $parts[$index] = ")";
                      break;
                  case ":":
                    $parts[$index] = "=>";
                    break;   
                  case ",":
                    break;
                  default:
                      return null;
              }
          }
          else
          {
              if ((substr($part, 0, 1) != "\"") || (substr($part, -1, 1) != "\""))
              {
                  return null;
              }
          }
      }
      $json = str_replace(array("&#92;", "&#34;", "$"), array("\\\\", "\\\"", "\\$"), implode("", $parts));
      return eval("return $json;");
  }

function clear($v)
{
    $v = strip_tags($v);
    $v = str_replace('"','',$v);
    $v = str_replace("'",'',$v);
    $v=stripslashes($v);
    $v=mysql_real_escape_string($v);
    return $v;
}

?>