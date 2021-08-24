<?php

namespace App\Data;

use App\Entity\Mark;
use App\Entity\Type;
use App\Entity\Category;
use App\Entity\Producer;

class SearchData
{

    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var Type[]
     */
    public $types = [];

    /**
     * @var Mark[]
     */
    public $marks = [];

    /**
     * @var Producer[]
     */
    public $producers = [];

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;

}