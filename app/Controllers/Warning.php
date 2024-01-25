<?php namespace App\Controllers;

class Warning extends BaseController
{
	public function index() {
		return view("warning-".warning_page);
    }
}