<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vocab
 *
 * @author rellek
 */


class Vocab extends Eloquent {
	public static $rules = array();	
    protected $fillable = array('word', 'type', 'translations');
}
