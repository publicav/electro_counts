<?php
function include_h( $file ) {
    $file_name = $file;
    $fh = fopen( $file_name, "r" );
    $res = fread( $fh, filesize( $file_name ) );
    fclose( $fh );
    return $res;
}

function create_sql( $action, $table, $data ) {
    if ( $action == 'add' ) {
        $insert = "INSERT INTO $table (";
        $values = "VALUES (";
        $fields = '';
        $vars = '';
        foreach ( $data as $key => $value ) {
            if ( $key != 'id' ) {
                $fields .= $key . ',';
                $vars .= "'$value',";
            }
        }
        $fields = substr( $fields, 0, strlen( $fields ) - 1 );
        $vars = substr( $vars, 0, strlen( $vars ) - 1 );
        $res = $insert . $fields . ") " . $values . $vars . ")";
    };

    if ( $action == 'edit' ) {
        $update = "UPDATE $table ";
        $set = "SET ";
        $vars = '';
        foreach ( $data as $key => $value ) {
            if ( $key != 'id' ) {
                $vars .= $key . " = '" . $value . "'" . ",";
            } else {
                $where = " WHERE (id = " . $value . ")";
            }
        }
        $vars = substr( $vars, 0, strlen( $vars ) - 1 ) . ' ';
        $res = $update . $set . $vars . $where;
    };
    return $res;
}


function range_time( $dayofmt, $y_m ) {
    $begin_dt = $y_m . "-01";
    $end_dt = $y_m . "-" . $dayofmt;
    $begin_dt = $begin_dt . " 00:00:00";
    $end_dt = $end_dt . " 23:59:59";
    $r_time = " (date>='$begin_dt')AND(date<='$end_dt')";
    return $r_time;

}

function range_time_day( $date_b, $date_e ) {
    if ( $date_e == '' ) $date_e = $date_b;
    if ( $date_b == '' ) $date_b = $date_e;

    if ( ( \DateTime::createFromFormat( 'Y-m-d', $date_b ) ) and ( \DateTime::createFromFormat( 'Y-m-d', $date_e ) ) ) {
        $date_b = $date_b . " 00:00:00";
        $date_e = $date_e . ' 23:59:59';
        return "date_create BETWEEN '$date_b' AND '$date_e'";
    } else return '';
}


function navigator( $file, $position, $total, $columPage, $cmd_arr ) {
    if ( !is_array( $cmd_arr ) ) $cmd_arr = [];
    unset( $cmd_arr['st'] );
    $paramUrl = http_build_query( $cmd_arr );
    if ( !empty( $paramUrl ) ) $paramUrl = '&' . $paramUrl;

    if ( $position < 0 ) $position = 0;
    if ( $position > $total ) $position = ( floor( $total / $columPage ) * $columPage );

    $end = ( floor( $total / $columPage ) * $columPage );
    if ( $end == $total ) $end = $end - $columPage;
    $stl1 = $position - $columPage;
    $str1 = $position + $columPage;

    $pgCurrent = floor( $position / $columPage ) + 1;
    $navigatorPage = 4;
    $page = '';
    $classSpan = 'pagelink';

    if ( $stl1 >= 0 ) {
        $pervpage = "<span class=$classSpan><a href=./$file?st=0$paramUrl title=\"На первую страницу\">«</a></span>
                     <span class=$classSpan><a href=./$file?st=$stl1$paramUrl title=\"Предыдущая страница\">&lt;</a></span>";
    } else  $pervpage = '';
    for ( $i = $pgCurrent - $navigatorPage, $count = -$navigatorPage; $i <= $pgCurrent + $navigatorPage; $i++, $count++ ) {
        $stFirst = $position + $columPage * $count;
        if ( ( $stFirst >= 0 ) and ( $stFirst < $total ) ) {
            if ( $i == $pgCurrent ) {
                if ( $total > $columPage ) $page .= "<span class=\"pagecurrent\">$pgCurrent</span>";
            } else {
                $page .= "<span class=$classSpan><a href=./$file?st=$stFirst$paramUrl title=\"$i\">$i</a></span>";
            }
        }
    }
    if ( $str1 < $total ) {
        $nextpage = "<span class=$classSpan><a href= ./$file?st=$str1$paramUrl title='Следующая страница'>&gt</a></span>
                     <span class=$classSpan><a href= ./$file?st=$end$paramUrl  title='На последнюю  страницу'>»</a></span>";
    } else $nextpage = '';

    $rt = '<div class="navigator">
                 <p>' . $pervpage . $page . $nextpage . '</p>
           </div>';

    return $rt;
}

function deltree( $folder ) {
    if ( is_dir( $folder ) ) {
        $handle = opendir( $folder );
        while ( $subfile = readdir( $handle ) ) {
            if ( $subfile == '.' or $subfile == '..' ) continue;
            if ( is_file( $subfile ) ) @unlink( "{$folder}/{$subfile}" );
            else deltree( "{$folder}/{$subfile}" );
        }
        @closedir( $handle );
        //        if (@rmdir($folder)) return true;
        //        else return false;
    } else {
        if ( @unlink( $folder ) ) return true;
        else return false;
    }
    return false;
}


function stdToArray( $obj ) {
    $rc = (array)$obj;
    foreach ( $rc as $key => &$field ) {
        if ( is_object( $field ) ) $field = $this->stdToArray( $field );
    }
    return $rc;
}

function exit_error( $success, $id_error, $error ) {
    $type['success'] = $success;
    $type['id_error'] = $id_error;
    $type['error'] = $error;
    return json_encode( $type );
}

function datetime_sql( $dt_b, $time ) {
    $on_day = preg_match( "([0-9]{2})", $dt_b, $day_b );
    $on_mt = preg_match( "(-[0-9]{2})", $dt_b, $mt_b );
    $on_yr = preg_match( "([0-9]{4})", $dt_b, $yr_b );
    $on_time = preg_match( "([0-9]{2}:[0-9]{2})", $time, $time_b );
    if ( $on_day && $on_mt && $on_yr && $on_time ) {
        $date_create = $yr_b[0] . $mt_b[0] . "-" . $day_b[0] . ' ' . $time_b[0];

    } else {
        $date_create = '';

    }
    return $date_create;
}

function validator_input_sql( $name_table, $id ) {
    // global $db_li;
    global $pdo;

    $sq = "SELECT name FROM  $name_table WHERE ( id = :id );";
    $param = [ 'id' => $id ];
    $res = $pdo->prepare( $sq );
    if ( $res->execute( $param ) ) {
        while ( $row = $res->fetch() ) {
            $name_result = $row['name'];
        }
    }
    return $name_result;
}

function validator_user( $user ) {
    global $pdo;
    $sq = "SELECT id FROM users  WHERE ( users = :user );";
    $param = array( 'user' => $user );
    $res = $pdo->prepare( $sq );
    if ( $res->execute( $param ) ) {
        while ( $row = $res->fetch() ) {
            $id = $row['id'];
        }
    }
    return $id;
}


function cmd_page_navigator( $date_b, $date_e ) {
    if ( ( $date_e == '' ) AND ( $date_b == '' ) ) {
        return "";
    }
    if ( $date_b != '' ) $cmd_page = '&date_b=' . $date_b;
    if ( $date_e != '' ) $cmd_page .= '&date_e=' . $date_b;
    return $cmd_page;

}

function json_menu2array( $menu_json ) {
    global $head;
    global $Full_Page_Name;
    $data = (string)( stripslashes( $menu_json ) );
    $data = json_decode( $data );
    for ( $i = 0; $i < SizeOf( $data->menu ); $i++ ) {
        $menu_tek = $data->menu[ $i ];
        $menu_tek = stdToArray( $menu_tek );
        if ( $Full_Page_Name == $menu_tek['id_a'] ) {
            $head = str_replace( ':title:', $menu_tek['title'], $head );
            $head = str_replace( ':meta_d:', $menu_tek['meta_d'], $head );
            $head = str_replace( ':meta_k:', $menu_tek['meta_k'], $head );
            $menu_tek['tek'] = 1;

        } else $menu_tek['tek'] = 0;
        $menu_arr[] = $menu_tek;
    }
    return $menu_arr;
}
