<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 21/06/2018
 * Time: 17:27
 */

namespace Drupal\xtcfile\API;


class Csv {
  /**
   * w3wfr: Method stolen from https://github.com/parsecsv/parsecsv-for-php
   *
   * Parse CSV strings to arrays. If you need BOM detection or character
   * encoding conversion, please call load_data() first, followed by a call to
   * parse_string() with no parameters.
   *
   * To detect field separators, please use auto() instead.
   *
   * @param string $data CSV data
   *
   * @return array|false - 2D array with CSV data, or false on failure
   */
  public function getCsvContent($data = null, $delimiter = ',', $enclosure = '"', $heading = TRUE, $limit = null) {
    $white_spaces = str_replace($delimiter, '', " \t\x0B\0");
    $error = 0;

    $rows = array();
    $row = array();
    $row_count = 0;
    $current = '';
    $head = !empty($this->fields) ? $this->fields : array();
    $col = 0;
    $enclosed = false;
    $was_enclosed = false;
    $strlen = strlen($data);

    // force the parser to process end of data as a character (false) when
    // data does not end with a line feed or carriage return character.
    $lch = $data{$strlen - 1};
    if ($lch != "\n" && $lch != "\r") {
      $data .= "\n";
      $strlen++;
    }

    // walk through each character
    for ($i = 0; $i < $strlen; $i++) {
      $ch = isset($data{$i}) ? $data{$i} : false;
      $nch = isset($data{$i + 1}) ? $data{$i + 1} : false;

      // open/close quotes, and inline quotes
      if ($ch == $enclosure) {
        if (!$enclosed) {
          if (ltrim($current, $white_spaces) == '') {
            $enclosed = true;
            $was_enclosed = true;
          } else {
            $error = 2;
            $error_row = count($rows) + 1;
            $error_col = $col + 1;
            $index = $error_row . '-' . $error_col;
            if (!isset($error_info[$index])) {
              $error_info[$index] = array(
                'type' => 2,
                'info' => 'Syntax error found on row ' . $error_row . '. Non-enclosed fields can not contain double-quotes.',
                'row' => $error_row,
                'field' => $error_col,
                'field_name' => !empty($head[$col]) ? $head[$col] : null,
              );
            }

            $current .= $ch;
          }
        } elseif ($nch == $enclosure) {
          $current .= $ch;
          $i++;
        } elseif ($nch != $delimiter && $nch != "\r" && $nch != "\n") {
          $x = $i + 1;
          while (isset($data{$x}) && ltrim($data{$x}, $white_spaces) == '') {
            $x++;
          }
          if ($data{$x} == $delimiter) {
            $enclosed = false;
            $i = $x;
          } else {
            if ($error < 1) {
              $error = 1;
            }

            $error_row = count($rows) + 1;
            $error_col = $col + 1;
            $index = $error_row . '-' . $error_col;
            if (!isset($error_info[$index])) {
              $error_info[$index] = array(
                'type' => 1,
                'info' =>
                  'Syntax error found on row ' . (count($rows) + 1) . '. ' .
                  'A single double-quote was found within an enclosed string. ' .
                  'Enclosed double-quotes must be escaped with a second double-quote.',
                'row' => count($rows) + 1,
                'field' => $col + 1,
                'field_name' => !empty($head[$col]) ? $head[$col] : null,
              );
            }

            $current .= $ch;
            $enclosed = false;
          }
        } else {
          $enclosed = false;
        }

        // end of field/row/csv
      } elseif (($ch === $delimiter || $ch == "\n" || $ch == "\r" || $ch === false) && !$enclosed) {
        $key = !empty($head[$col]) ? $head[$col] : $col;
        $row[$key] = $was_enclosed ? $current : trim($current);
        $current = '';
        $was_enclosed = false;
        $col++;

        // end of row
        if ($ch == "\n" || $ch == "\r" || $ch === false) {
          if ($heading && empty($head)) {
            $head = $row;
          } elseif (empty($this->fields) || (!empty($this->fields) && (($heading && $row_count > 0) || !$heading))) {
            if (!empty($this->sort_by) && !empty($row[$this->sort_by])) {
              $sort_field = $row[$this->sort_by];
              if (isset($rows[$sort_field])) {
                $rows[$sort_field . '_0'] = &$rows[$sort_field];
                unset($rows[$sort_field]);
                $sn = 1;
                while (isset($rows[$sort_field . '_' . $sn])) {
                  $sn++;
                }
                $rows[$sort_field . '_' . $sn] = $row;
              } else {
                $rows[$sort_field] = $row;
              }

            } else {
              $rows[] = $row;
            }
          }

          $row = array();
          $col = 0;
          $row_count++;

          if (empty($this->sort_by) && $limit !== null && count($rows) == $limit) {
            $i = $strlen;
          }

          if ($ch == "\r" && $nch == "\n") {
            $i++;
          }
        }

        // append character to current field
      } else {
        $current .= $ch;
      }
    }

    $content['titles'] = $head;
    $content['rows'] = $rows;

    return $content;
  }
}