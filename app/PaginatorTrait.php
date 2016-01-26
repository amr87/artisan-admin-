<?php

namespace App;

trait PaginatorTrait {

    public static function getPaginator($data) {


        $output = " <ul class='pagination pagination-sm no-margin pull-right'>";

        if ($data->last_page != 1) {

            if ($data->current_page == 1) {
                for ($i = 0; $i <= 7; $i++) {
                    if ($i == 1) {
                        $output .= "<li><a class='active'>" . $data->current_page . "</a></li>";
                    } elseif ($i > 0 && $i <= $data->last_page) {
                        $output .= "<li><a  class='' href='" . url('/admin/users') . "?page=" . $i . "'>" . $i . "</a></li>";
                    }
                }
            }

            if ($data->current_page == $data->last_page) {
                $previous = $data->last_page - 1;
                // output previous 
                $output .= "<li><a  class=' first' title= 'go to first page' href='" . url('/admin/users') . "?page=1'>";
                $output .= "First</a></li>";
                $output .= "<li><a  class=' prev' title= 'go to previous page' href='" . url('/admin/users') . "?page=" . $previous . "'>";
                $output .= "&laquo;</a></li>";
                for ($i = $data->last_page - 7 + 1; $i <= $data->last_page; $i++) {
                    if ($i == $data->last_page) {
                        $output .= "<li><a  class=' active'>" . $data->current_page . "</a></li>";
                    } elseif ($i > 0) {
                        $output .= "<li><a  class='' href='" . url('/admin/users') . "?page=" . $i . "'>" . $i . "</a></li>";
                    }
                }
            }

            //check to see if we are on page 1
            if ($data->current_page > 1 && $data->current_page != $data->last_page) {
                $previous = $data->current_page - 1;
                // output previous 
                $output .= "<li><a  class=' first' title= 'go to first page' href='" . url('/admin/users') . "?page=1'>";
                $output .= "First</a></li>";
                $output .= "<li><a  class=' prev' title= 'go to previous page' href='" . url('/admin/users') . "?page=" . $previous . "'>";
                $output .= "&laquo;</a></li>";
                // output left side s
                for ($i = $data->current_page - 3; $i < $data->current_page; $i++) {
                    if ($i > 0) {
                        $output .= "<li><a  class='' href='" . url('/admin/users') . "?page=" . $i . "'>" . $i . "</a></li>";
                    }
                }
            }
            if ($data->current_page != 1 && $data->current_page != $data->last_page) {
                // output the current page as inactive 
                $output .= "<li><a  class=' active'>" . $data->current_page . "</a></li>";

                // output left right s
                for ($i = $data->current_page + 1; $i <= $data->last_page; $i++) {
                    $output .= "<li><a  class='' href='" . url('/admin/users') . "?page=" . $i . "'>" . $i . "</a></li>";
                    if ($i >= $data->current_page + 3) {
                        break;
                    }
                }
            }

            // output next 
            if ($data->current_page != $data->last_page) {
                $next = $data->current_page + 1;
                $output .= "<li><a  class=' next' title= 'go to next page' href='" . url('/admin/users') . "?page=" . $next . "'>";
                $output .= "&raquo;</a></li>";
                $output .= "<li><a  class=' last' title= 'go to last page' href='" . url('/admin/users') . "?page=" . $data->last_page . "'>";
                $output .= "Last</a></li>";
            }

            $output .= "<li><a  class=' status'>Page " . $data->current_page . " of " . $data->last_page . "</a></li>";
        }
        $output.="</ul>";
        return $output;
    }

}
