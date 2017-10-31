<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d",
    $W, // width of the building.
    $H // height of the building.
);
fscanf(STDIN, "%d",
    $N // maximum number of turns before game over.
);
fscanf(STDIN, "%d %d",
    $X0,
    $Y0
);
$last_dir = '';
$dir_history = [];
$pos_history = [[$X0, $Y0]];

$minY = 0;
$maxY = $H;
$minX = 0;
$maxX = $W;

$counter = 0;

// game loop
while (TRUE)
{
    fscanf(STDIN, "%s",
        $bombDir // the direction of the bombs from batman's current location (U, UR, R, DR, D, DL, L or UL)
    );
    $factor = 2;
    array_push($dir_history, $bombDir);
    switch($bombDir){
        case "R":
            if($counter > 1 && is_definitive($dir_history, $bombDir, $counter)){
              $minX = $pos_history[$counter-1][0];
            }
            $X0 = dico_line($minX, $maxX);
            break;

        case "UR":          
            $X0 = floor(($maxX + $X0)/$factor);
            $Y0 = floor($Y0 / $factor);

            if($counter > 1 && is_definitive($dir_history, $bombDir, $counter)){
              $minX = $pos_history[$counter-1][0];
              $maxY = $pos_history[$counter-1][1];
            }
            error_log(var_export("minX: $minX || maxX: $maxX", true));
            error_log(var_export("minY: $minY || maxY: $maxY", true));
            break;

        case "DR":
            $X0 = floor(($maxX + $X0)/$factor);
            $Y0 = floor(($maxY + $Y0) / $factor);

            if($counter > 1 && is_definitive($dir_history, $bombDir, $counter)){
              $minX = $pos_history[$counter-1][0];
              $minY = $pos_history[$counter-1][1];
            }
            error_log(var_export("minX: $minX || maxX: $maxX", true));
            error_log(var_export("minY: $minY || maxY: $maxY", true));
            break;

        case "L":
            if($counter > 1 && is_definitive($dir_history, $bombDir, $counter)){
              $maxX = $pos_history[$counter-1][0];
            }
            $X0 = dico_line($minX, $maxX);
            break;

        case "UL":
            $Y0 = floor($Y0 / $factor);
            $X0 = floor($X0 / $factor);
            break;

        case "DL":
            $Y0 = floor(($max + $Y0) / $factor);
            $X0 = floor($X0 / $factor);
            if($counter > 1 && is_definitive($dir_history, $bombDir, $counter)){
              $maxY = $pos_history[$counter-1][1];
            }
            break;
        case "D":
            if($counter > 1 && is_definitive($dir_history, $bombDir, $counter)){
              $minY = $pos_history[$counter-1][1];
              error_log(var_export("going DOWN counter over 1", true));
              error_log(var_export("minX: $minX || maxX: $maxX", true));
              error_log(var_export("minY: $minY || maxY: $maxY", true));
            }
            $Y0 = dico_line($minY,$maxY);
            
            break;
        case "U":
            if($counter > 1 && is_definitive($dir_history, $bombDir, $counter)){
              $maxY = $pos_history[$counter-1][1];
              error_log(var_export("going UP counter over 1", true));
              error_log(var_export("minX: $minX || maxX: $maxX", true));
              error_log(var_export("minY: $minY || maxY: $maxY", true));
            }
            $Y0 = dico_line($minY,$maxY);
            
            break;
        default:
            break;

    }

    $last_dir = $bombDir;
    array_push($pos_history, [$X0, $Y0]);
    $counter++;
    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug (equivalent to var_dump): error_log(var_export($var, true));
    
    // the location of the next window Batman should jump to.
    echo("$X0 $Y0\n");
    //$N--;
}


function dico_line($min, $max){
  return floor(($min + $max) / 2);
}

function is_definitive($arr, $dir, $curr_index){
  return $arr[$curr_index -1] == $dir &&  $arr[$curr_index -2] == $dir;
}
?>