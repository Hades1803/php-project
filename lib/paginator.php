<?php
class Paginator {
    var $base_url = '';     // The page we are linking to
    var $total_rows = 0;    // Total number of items (database results)
    var $per_page = 10;     // Max number of items you want shown per page
    var $cur_page = 1;      // Current page number

    public function __construct($params = array()) {
        if (count($params) > 0) {
            $this->init($params);
        }
    }

    public function init($params = array()) {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->$key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    public function createLinks() {
        $total_pages = ceil($this->total_rows / $this->per_page);
        if ($total_pages <= 1) return ''; // Không cần phân trang nếu chỉ có 1 trang

        $html = "<nav aria-label='Page navigation'>";
        $html .= "<ul class='pagination justify-content-center'>";

        // Previous Button
        $prev_class = ($this->cur_page == 1) ? "disabled" : "";
        $html .= "<li class='page-item $prev_class'><a class='page-link' href='" . $this->base_url . "&currentPage=" . ($this->cur_page - 1) . "'>&laquo;</a></li>";

        // Page Numbers
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($this->cur_page == $i) ? "active" : "";
            $html .= "<li class='page-item $active_class'><a class='page-link' href='" . $this->base_url . "&currentPage=" . $i . "'>$i</a></li>";
        }

        // Next Button
        $next_class = ($this->cur_page == $total_pages) ? "disabled" : "";
        $html .= "<li class='page-item $next_class'><a class='page-link' href='" . $this->base_url . "&currentPage=" . ($this->cur_page + 1) . "'>&raquo;</a></li>";

        $html .= "</ul>";
        $html .= "</nav>";

        return $html;
    }
}
?>
