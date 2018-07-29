<?php

class PagesController
{
    /**
     * Notification alert in every page
     */
    public function error()
    {
        require_once 'views/pages/error.php';
    }
}
