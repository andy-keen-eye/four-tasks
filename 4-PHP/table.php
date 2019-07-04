
<?php

const SPACING_X   = 1;
const JOINT_CHAR  = '+';
const LINE_X_CHAR = '-';
const LINE_Y_CHAR = '|';

$table = array(
    array(
        'Name'    => 'Trixie',
        'Color'   => 'Green',
        'Element' => 'Earth',
        'Likes'   => 'Flowers'
    ),
    array(
        'Name'    => 'Tinkerbell',
        'Element' => 'Air',
        'Likes'   => 'Singing',
        'Color'   => 'Blue'
    ),
    array(
        'Name'    => 'Blum',
        'Element' => 'Water',
        'Likes'   => 'Dancing',
        'Name'    => 'Blum',
        'Color'   => 'Pink'
    ),
);

$colors = array(
    'Green' => "\033[42mGreen",
    'Blue' => "\033[44mBlue",
    'Pink' => "\033[45mPink"
);

function draw_table($table, $colors)
{

    $nl              = "\n";
    $columns_headers = columns_headers($table);
    $columns_lengths = columns_lengths($table, $columns_headers);
    $row_separator   = row_seperator($columns_lengths);
    $row_headers     = row_headers($columns_headers, $columns_lengths);


    echo $row_separator . $nl;
    echo $row_headers . $nl;
    echo $row_separator . $nl;
    foreach ($table as $row_cells) {
        $row_cells = row_cells($row_cells, $columns_headers, $columns_lengths, $colors);
        echo $row_cells . $nl;
    }
    echo $row_separator . $nl;

}

function columns_headers($table)
{
    return array_keys(reset($table));
}

function columns_lengths($table, $columns_headers)
{
    $lengths = [];
    foreach ($columns_headers as $header) {
        $header_length = strlen($header);
        $max = $header_length;
        foreach ($table as $row) {
            $length = strlen($row[$header]);
            if ($length > $max) {
                $max = $length;
            }
        }

        if (($max % 2) != ($header_length % 2)) {
            $max += 1;
        }
        $lengths[$header] = $max;
    }
    return $lengths;
}

function row_seperator($columns_lengths)
{
    $row = '';
    foreach ($columns_lengths as $column_length) {
        $row .= JOINT_CHAR . str_repeat(LINE_X_CHAR, (SPACING_X * 2) + $column_length);
    }
    $row .= JOINT_CHAR;

    return $row;
}

function row_headers($columns_headers, $columns_lengths)
{
    $row = '';
    foreach ($columns_headers as $header) {
        $row .= LINE_Y_CHAR . str_pad($header, (SPACING_X * 2) + $columns_lengths[$header], ' ', STR_PAD_BOTH);
    }
    $row .= LINE_Y_CHAR;

    return $row;
}

function row_cells($row_cells, $columns_headers, $columns_lengths, $colors)
{
    $row = '';
    foreach ($columns_headers as $header) {
        $row .= LINE_Y_CHAR . str_repeat(' ', SPACING_X);
        if ($header == 'Color') {
            $cell = str_pad($row_cells[$header], SPACING_X + $columns_lengths[$header], ' ', STR_PAD_RIGHT);
            $cell = str_replace($row_cells[$header], $colors[$row_cells[$header]], $cell);
            $row .= $cell . "\033[0m";
        } else {
            $row .= str_pad($row_cells[$header], SPACING_X + $columns_lengths[$header], ' ', STR_PAD_RIGHT);
        }
    }
    $row .= LINE_Y_CHAR;

    return $row;
}

draw_table($table, $colors);