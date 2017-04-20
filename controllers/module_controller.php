<?php
defined('_MYINC') or die();

class ModuleController
{
    public function dashboard() {
        ViewHelper::setTitle('Minyy | Dashboard');
        ViewHelper::getView('page','dashboard');
    }
}