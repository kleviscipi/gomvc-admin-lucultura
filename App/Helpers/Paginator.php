<?php


class Paginator
{


    private $perPage;


    private $instance;


    private $page;


    private $limit;


    private $totalRows = 0;


    public function __construct($perPage, $instance)
    {
        $this->instance = $instance;
        $this->perPage = $perPage;
        $this->setInstance();
    }


    public function getStart()
    {
        return ( $this->page * $this->perPage ) - $this->perPage;
    }


    public function getInstance()
    {
        return $this->page;
    }


    private function setInstance()
    {
        $this->page = ( int ) ( !isset( $_GET[$this->instance] ) ? 1 : $_GET[$this->instance] );
        $this->page = ( $this->page == 0 ? 1 : $this->page );
    }

    public function setTotal( $totalRows )
    {
        $this->totalRows = $totalRows;
    }


    public function getLimit()
    {
        return "LIMIT " . $this->getStart() . ", $this->perPage";
    }

    public function getLimit2()
    {
        return $this->getStart();
    }


    public function getPerPage()
    {
        return $this->perPage;
    }


    public function pageLinks( $path = '?', $ext = null )
    {
        $adjacents = "2";
        $prev = $this->page - 1;
        $next = $this->page + 1;
        $lastpage = ceil( $this->totalRows / $this->perPage );
        $lpm1 = $lastpage - 1;

        $pagination = "";
        if ( $lastpage > 1 ):
            $pagination .= "<nav>";
            $pagination .= "<ul class='pagination'>";
            if ( $this->page > 1 ):
                $pagination.= "<li><a href='" . $path . "$this->instance=$prev" . "$ext' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
            else:
                $pagination.= "<li class='disabled'><a href='#' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
            endif;

            if ( $lastpage < 7 + ( $adjacents * 2 ) ):
                for ( $counter = 1; $counter <= $lastpage; $counter++ ):
                    if ( $counter == $this->page ):
                        $pagination.= "<li class='active'><span>$counter <span class='sr-only'>(current)</span></span></li>";
                    else:
                        $pagination.= "<li><a href='" . $path . "$this->instance=$counter" . "$ext'>$counter</a></li>";
                    endif;
                endfor;
            else if ( $lastpage > 5 + ( $adjacents * 2 )):
                if ( $this->page < 1 + ( $adjacents * 2 )):
                    for ( $counter = 1; $counter < 4 + ( $adjacents * 2 ); $counter++ ):
                        if ( $counter == $this->page ):
                            $pagination.= "<li class='active'><span>$counter <span class='sr-only'>(current)</span></span></li>";
                        else:
                            $pagination.= "<li><a href='" . $path . "$this->instance=$counter" . "$ext'>$counter</a></li>";
                        endif;
                    endfor;

                    $pagination.= "<li><span style='border: none; background: none; padding: 8px;'>...</span></li>";
                    $pagination.= "<li><a href='" . $path . "$this->instance=$lpm1" . "$ext'>$lpm1</a></li>";
                    $pagination.= "<li><a href='" . $path . "$this->instance=$lastpage" . "$ext'>$lastpage</a></li>";
                else if ( $lastpage - ( $adjacents * 2 ) > $this->page && $this->page > ($adjacents * 2)):
                    $pagination.= "<li><a href='" . $path . "$this->instance=1" . "$ext'>1</a></li>";
                    $pagination.= "<li><a href='" . $path . "$this->instance=2" . "$ext'>2</a></li>";
                    $pagination.= "<li><span style='border: none; background: none; padding: 8px;'>...</span></li>";

                    for ( $counter = $this->page - $adjacents; $counter <= $this->page + $adjacents; $counter++ ):
                        if ( $counter == $this->page ):
                            $pagination.= "<li class='active'><span>$counter <span class='sr-only'>(current)</span></span></li>";
                        else:
                            $pagination.= "<li><a href='" . $path . "$this->instance=$counter" . "$ext'>$counter</a></li>";
                        endif;
                    endfor;
                    $pagination.= "<li><span style='border: none; background: none; padding: 8px;'>..</span></li>";
                    $pagination.= "<li><a href='" . $path . "$this->instance=$lpm1" . "$ext'>$lpm1</a></li>";
                    $pagination.= "<li><a href='" . $path . "$this->instance=$lastpage" . "$ext'>$lastpage</a></li>";
                else:
                    $pagination.= "<li><a href='" . $path . "$this->instance=1" . "$ext'>1</a></li>";
                    $pagination.= "<li><a href='" . $path . "$this->instance=2" . "$ext'>2</a></li>";
                    $pagination.= "<li><span style='border: none; background: none; padding: 8px;'>..</span></li>";

                    for ( $counter = $lastpage - ( 2 + ( $adjacents * 2 ) ); $counter <= $lastpage; $counter++ ):
                        if ( $counter == $this->page ):
                            $pagination.= "<li class='active'><span>$counter <span class='sr-only'>(current)</span></span></li>";
                        else:
                            $pagination.= "<li><a href='" . $path . "$this->instance=$counter" . "$ext'>$counter</a></li>";
                        endif;
                    endfor;
                endif;
            endif;

            if ( $this->page < $counter - 1 ):
                $pagination.= "<li><a href='" . $path . "$this->instance=$next" . "$ext' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
            else:
                $pagination.= "<li class='disabled'><a href='#' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
            endif;

            $pagination.= "</ul>";
            $pagination.= "</nav>\n";
        endif;

        return $pagination;
    }
}
